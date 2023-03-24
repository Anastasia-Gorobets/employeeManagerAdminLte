<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use App\Models\Comment;
use App\Models\Employee;
use App\Models\Position;
use App\Models\User;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $positions = Position::all();

        Employee::factory(10)->make()->each(function ($employee) use ($positions){
            $employee->position_id = $positions->random()->id;

          /*  $all = Employee::all();
            $bossId = 1;
            if(Employee::count() > 0){
                $bossId = $all->random()->id;
            }
            if($employee->id != 1){
                $employee->boss_id = $bossId;
            }*/

            // Get a random boss from existing employees with a lower hierarchy level
            $bosses = Employee::where('id', '<>', $employee->id)
                ->where('id', '<>', 1)
                ->where(function ($query) use ($employee) {
                    $query->whereNull('boss_id')
                        ->orWhere('boss_id', $employee->id);
                })
                ->get();

            if ($bosses->isNotEmpty()) {
                $boss = $bosses->random();
                $employee->boss_id = $boss->id;
            }

            $employee->save();
        });




    }
}
