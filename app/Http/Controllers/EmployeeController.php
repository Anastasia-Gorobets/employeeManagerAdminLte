<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

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
                ->editColumn('position', function ($row) {
                    return $row->position->name;
                })
                ->editColumn('date_start_work', function ($row) {
                    return $row->created_at->format('d.m.Y');
                })
                ->editColumn('salary', function ($row) {
                    return '$'.$row->salary;
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('employee.edit', $row->id);
                    $btnEdit = '<a href="' . $editUrl . '" class="btn btn-primary btn-sm">Edit</a>';
                    $deleteUrl = route('employee.destroy', $row->id);
                    $formDelete = '<form onsubmit="return confirmDelete(this)" class="deleteEmployeeForm" action="'.$deleteUrl.'" method="post">'.csrf_field().method_field('DELETE').'<button type="submit" class="btn btn-danger btn-sm">Delete</button></form>';
                    return $btnEdit.' '.$formDelete;

                    //{{ csrf_field() }}
                    //        {{ method_field('DELETE') }}

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
        return view('employee.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        dd('show');


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {
        //
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
