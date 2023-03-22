<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('position_id')->unique();
            $table->foreign('position_id')->references('id')->on('positions');
            $table->unsignedBigInteger('image_id')->unique();
            $table->foreign('image_id')->references('id')->on('images');
            $table->timestamp('date_start_work');
            $table->string('phone');
            $table->string('mail');
            $table->unsignedFloat('salary');
            $table->unsignedInteger('admin_created_id');
            $table->unsignedInteger('admin_updated_id');
            $table->unsignedBigInteger('boss_id')->nullable();
            $table->foreign('boss_id')->references('id')->on('employees');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
