<?php

namespace App\Models;

use App\Models\Position;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

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

}
