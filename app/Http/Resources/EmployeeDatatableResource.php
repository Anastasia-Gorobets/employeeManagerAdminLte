<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class EmployeeDatatableResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $image = '/storage/employees_images/greyCircle.png';
        if ($this->image) {
            $image =  Storage::url($this->image->path);
        }
        $editUrl = '/edit-employee/'.$this->id;
        $btnEdit = '<a class="btn btn-primary editEmployeeLink" href="' . $editUrl . '" ><i class="fa-solid fa-pen-to-square"></i> Edit</a>';
        $formDelete = '<a data-id="'.$this->id.'" type="button" class="btn btn-danger deleteEmployeeForm">
    <i class="fa-solid fa-trash"></i> Delete</button>';
        $action =  $btnEdit.' '.$formDelete;
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'date_start_work'=>date('d.m.Y',strtotime($this->date_start_work)),
            'phone'=>$this->phone,
            'email'=>$this->email,
            'salary'=>$this->salary,
            'boss_name'=>$this->boss ? $this->boss->name : '',
            'boss_id'=>$this->boss ? $this->boss->id : 0,
            'position'=>$this->position->name,
            'image'=>$image,
            'action'=>$action,
        ];
    }
}
