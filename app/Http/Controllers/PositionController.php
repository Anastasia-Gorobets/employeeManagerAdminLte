<?php

namespace App\Http\Controllers;

use App\Http\Requests\PositionRequest;
use App\Http\Resources\PositionResource;
use App\Models\Employee;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class PositionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('positions.index');
    }

    public function getAllPositions()
    {
        return PositionResource::collection(Position::all());

    }

    public function getList(Request $request)
    {
        if ($request->ajax()) {
            $data = Position::all();

            return DataTables::of($data)
                ->editColumn('updated_at', function ($row) {
                    return date('d.m.Y', strtotime($row->updated_at));
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('position.edit', $row->id);
                    $btnEdit = '<a class="btn btn-primary" href="' . $editUrl . '" ><i class="fa-solid fa-pen-to-square"></i> Edit</a>';
                    $deleteUrl = route('position.destroy', $row->id);
                    $formDelete = '<form onsubmit="return confirmDelete(this)" class="deletePositionForm mt-2" action="'.$deleteUrl.'" method="post">'.csrf_field().method_field('DELETE').'<button type="submit" class="btn btn-danger">
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
        return view('positions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PositionRequest $request)
    {

        $validated = $request->validated();
        Position::create($validated);

        return redirect()->route('position.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function show(Position $position)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function edit(Position $position)
    {

        return view('positions.edit', ['position'=>$position]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function update(PositionRequest $request, Position $position)
    {
        $validated = $request->validated();
        $position->fill($validated);
        $position->save();
        return redirect()->route('position.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function destroy(Position $position)
    {
        $position->delete();
        return redirect()->route('position.index');


    }
}
