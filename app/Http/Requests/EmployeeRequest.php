<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

use Illuminate\Support\Facades\Gate;


class EmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('only.admin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = null;

        if ($this->route('employeeapi')) {
            $id = $this->route('employeeapi')->id;
        } elseif ($this->route('employee')) {
            $id = $this->route('employee')->id;
        }

        $rules  = [
            'name'=>'required|min:2|max:256',
            /*'date_start_work'=>'date_format:d.m.y',*/
            'date_start_work'=>'required',
            'phone' => 'required|regex:/^\+380\d{2}\d{3}\d{2}\d{2}$/',
            'email' => [
                'required',
                'email',
                Rule::unique('employees', 'email')
                    ->ignore($id)
            ],
            'salary'=>'required|numeric|between:0,500000',
            'boss_id'=>'required|exists:employees,id',
            'image' => 'image|mimes:jpeg,png,jpg|dimensions:min_width=300,min_height=300'
        ];

        return $rules;
    }
}
