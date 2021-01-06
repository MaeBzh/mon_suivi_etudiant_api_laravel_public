<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) { $table->softDeletes();
            $table->increments('id');
            $table->timestamps();
            $table->boolean('active')->default(true);

            $table->unsignedInteger('school_id');
            $table->foreign('school_id')->references('id')->on('schools');

            $table->unsignedInteger('tutor_id');
            $table->foreign('tutor_id')->references('id')->on('tutors');

            $table->unsignedInteger('user_id')->unique();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedInteger('address_id');
            $table->foreign('address_id')->references('id')->on('addresses')->onDelete('cascade');
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::dropIfExists('students');
    }
}
