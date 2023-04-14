<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeRequest;
use App\Http\Resources\EmployeeDatatableResource;
use App\Http\Resources\EmployeeResource;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
    public function index()
    {
        $data = EmployeeDatatableResource::collection(Employee::withRelations()->get());
        return  $data;

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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

        $validated['date_start_work'] = Carbon::createFromFormat('D M d Y H:i:s e+', $validated['date_start_work'])->format('Y-m-d');


        $employee = Employee::create($validated);

        $employee->employeeSetRelations($request, $employee);

        return response()->json([
            'message' => 'Employee was created',
            'employee' => $employee
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $employee = Employee::withRelations()->find($id);
        return new EmployeeResource($employee);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(EmployeeRequest $request, Employee $employeeapi)
    {

        $validated = $request->validated();
        $validated['date_start_work'] = Carbon::createFromFormat('D M d Y H:i:s e+', $validated['date_start_work'])->format('Y-m-d');

        $employeeapi->fill($validated);
        $employeeapi->save();

        $employeeapi->employeeSetRelations($request, $employeeapi);


        return response()->json([
            'message' => 'Employee was updated',
            'employee' => $employeeapi
        ]);

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employeeapi)
    {
        $employeeapi->delete();
        return response()->json([
            'message' => 'Employee was deleted',
        ]);
    }
}
