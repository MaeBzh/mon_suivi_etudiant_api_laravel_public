<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateDiplomaStudentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diploma_student', function (Blueprint $table) {
            $table->softDeletes();
            $table->increments('id');
            $table->timestamps();

            $table->string('state')->default('in_progress');
            $table->string('start_year');
            $table->string('end_year');

            $table->unsignedInteger('diploma_id');
            $table->foreign('diploma_id')->references('id')->on('diplomas');

            $table->unsignedInteger('student_id');
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('diploma_student');
    }
}
