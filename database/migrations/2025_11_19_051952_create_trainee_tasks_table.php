<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTraineeTasksTable extends Migration
{
    public function up()
    {
        Schema::create('trainee_tasks', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->unsignedBigInteger('trainee_id');
            $table->string('task');
            $table->text('desc');
            $table->date('start_date');
            $table->date('deadline');
            $table->enum('status', ['Progress', 'Done', 'Late', 'Canceled'])->default('Progress');
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('trainee_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('trainee_tasks');
    }
}
