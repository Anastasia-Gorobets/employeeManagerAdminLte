<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PositionDatatableResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $editUrl = '/edit-position/'.$this->id;
        $btnEdit = '<a class="btn btn-primary editPositionLink" href="' . $editUrl . '" ><i class="fa-solid fa-pen-to-square"></i> Edit</a>';
        $formDelete = '<button data-id="'.$this->id.'" type="button" class="btn btn-danger deletePositionForm">
    <i class="fa-solid fa-trash"></i> Delete</button>';
        $action =  $btnEdit.' '.$formDelete;
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'updated_at'=>date('d.m.Y',strtotime($this->updated_at)),
            'action'=>$action,

        ];


    }
}
