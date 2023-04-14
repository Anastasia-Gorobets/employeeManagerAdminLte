<?php

namespace App\Models;

use App\Models\Position;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image as ImageFacade;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = ['name','phone','email', 'salary', 'date_start_work'];

    public function position(){
        return $this->belongsTo(Position::class);
    }

    public function boss()
    {
        return $this->belongsTo(Employee::class, 'boss_id');
    }

    public function subordinates()
    {
        return $this->hasMany(Employee::class, 'boss_id');
    }

    public function image(){
        return $this->hasOne(Image::class);
    }

    public function scopeWithRelations(Builder $query)
    {
         $query->with('position')->with('boss')->with('image');
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

        if($request->file('image')){
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
                $employee->image->path =  $path;
                $employee->image->save();
            }else{
                $employee->image()->create([
                    'path' => $path
                ]);
            }

        }


    }

}
