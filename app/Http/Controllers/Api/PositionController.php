<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PositionRequest;
use App\Http\Resources\PositionDatatableResource;
use App\Http\Resources\PositionResource;
use App\Models\Employee;
use App\Models\Position;
use Illuminate\Http\Resources\Json\JsonResource;

class PositionController extends Controller
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
        $data = PositionDatatableResource::collection(Position::all());
        return  $data;

    }

    public function show($id)
    {
        $position = Position::find($id);
        return new PositionResource($position);
    }


    public function store(PositionRequest $request)
    {
        $validated = $request->validated();
        $position = Position::create($validated);
        return request()->json([
           'msg'=>'Position was created',
           'position'=>$position
        ]);
    }

    public function update(PositionRequest $request, Position $positionapi)
    {
        $validated = $request->validated();
        $positionapi->fill($validated);
        $positionapi->save();
        return request()->json([
            'msg'=>'Position was updated',
            'position'=>$positionapi
        ]);
    }

    public function destroy(Position $positionapi)
    {
        $positionapi->delete();
        return request()->json([
            'msg'=>'Position was deleted'
        ]);
    }


}
