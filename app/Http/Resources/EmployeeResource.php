<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class EmployeeResource extends JsonResource
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
            'position_id'=>$this->position->id,
            'image'=>$image,

        ];
    }
}
