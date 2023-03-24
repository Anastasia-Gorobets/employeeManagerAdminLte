<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeRequest;
use App\Models\Employee;
use App\Models\Position;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Storage;


use App\Models\Image;

use Intervention\Image\Facades\Image as ImageFacade;

class EmployeeController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:only.admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('employee.index');
    }

    public function getList(Request $request)
    {
        if ($request->ajax()) {
            $data = Employee::with('position')->with('boss')
                ->get();

            return DataTables::of($data)

                ->editColumn('image', function ($row) {
                    if ($row->image) {
                        return Storage::url($row->image->path);
                    }
                    return  '/storage/employees_images/greyCircle.png';
                })
                ->editColumn('position', function ($row) {
                    return $row->position->name;
                })
                ->editColumn('date_start_work', function ($row) {

                    return date('d.m.Y', strtotime($row->date_start_work));
                })
                ->editColumn('salary', function ($row) {
                    return '$'.$row->salary;
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('employee.edit', $row->id);
                    $btnEdit = '<a class="btn btn-primary" href="' . $editUrl . '" ><i class="fa-solid fa-pen-to-square"></i> Edit</a>';
                    $deleteUrl = route('employee.destroy', $row->id);
                    $formDelete = '<form onsubmit="return confirmDelete(this)" class="deleteEmployeeForm mt-2" action="'.$deleteUrl.'" method="post">'.csrf_field().method_field('DELETE').'<button type="submit" class="btn btn-danger">
    <i class="fa-solid fa-trash"></i> Delete</button></form>';
                    return $btnEdit.' '.$formDelete;


                })
                ->rawColumns(['action'])

                ->toJson();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('employee.create', ['positions'=>Position::all()]);
    }


    public function employeeSetRelations($request,$employee)
    {

        if($request->input('position')){
            $position =  Position::find($request->input('position'));
            if($position){
                $employee->position()->associate($position)->save();
            }
        }

        if($request->input('boss_id')){
            $boss =  Employee::find($request->input('boss_id'));
            if($boss){
                $employee->boss()->associate($boss)->save();
            }
        }

        if($request->hasFile('image')){
            $path = $request->file('image')->store('employees_images', 'public');
            $fullPath = Storage::disk('public')->path($path);
            /*echo $path . '<br>';
            echo public_path('storage/'.$path) . '<br>';
            die;*/

            $image = ImageFacade::make($fullPath)
                ->orientate() // autorotate the image if necessary
                ->fit(300, 300, function ($constraint) {
                    $constraint->aspectRatio(); // maintain aspect ratio
                    $constraint->upsize(); // prevent upsizing
                })
                ->crop(300, 300, null, null, true) // crop the center of the image
                ->encode('jpg', 80);

            Storage::disk('public')->put($path, (string) $image);

            if($employee->image){
                Storage::delete($employee->image->path);
                $employee->image->path =  $fullPath;
                $employee->image->save();
            }else{
                $employee->image()->create([
                    'path' => $fullPath
                ]);
            }

        }


    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmployeeRequest $request)
    {
        $validated = $request->validated();
        $validated['date_start_work'] = date('Y-m-d', strtotime($validated['date_start_work']));

        $employee = Employee::create($validated);

        $this->employeeSetRelations($request, $employee);


        return redirect()->route('employee.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        return view('employee.edit', ['employee'=>$employee,'positions'=>Position::all()]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(EmployeeRequest $request, Employee $employee)
    {
        $validated = $request->validated();
        $validated['date_start_work'] = date('Y-m-d', strtotime($validated['date_start_work']));

        $employee->fill($validated);
        $employee->save();

        $this->employeeSetRelations($request, $employee);


        return redirect()->route('employee.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()->route('employee.index');

    }


}
