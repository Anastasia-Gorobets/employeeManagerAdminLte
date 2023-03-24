<?php

namespace App\Observers;

use App\Models\Position;

class PositionObserver
{
    /**
     * Handle the Position "created" event.
     *
     * @param  \App\Models\Position  $position
     * @return void
     */
    public function created(Position $position)
    {
        //
    }

    /**
     * Handle the Position "updated" event.
     *
     * @param  \App\Models\Position  $position
     * @return void
     */
    public function updated(Position $position)
    {
        //
    }

    /**
     * Handle the Position "deleted" event.
     *
     * @param  \App\Models\Position  $position
     * @return void
     */
    public function deleted(Position $position)
    {
        //
    }

    public function deleting(Position $position)
    {
        $positions = Position::where('id','!=',$position->id)->get();
        $position->employees->map(function ($employee) use ($positions){


            $position =  Position::find($positions->random()->id);
            if($position){
                $employee->position()->associate($position)->save();
            }



        });




    }



    /**
     * Handle the Position "restored" event.
     *
     * @param  \App\Models\Position  $position
     * @return void
     */
    public function restored(Position $position)
    {
        //
    }

    /**
     * Handle the Position "force deleted" event.
     *
     * @param  \App\Models\Position  $position
     * @return void
     */
    public function forceDeleted(Position $position)
    {
        //
    }
}
