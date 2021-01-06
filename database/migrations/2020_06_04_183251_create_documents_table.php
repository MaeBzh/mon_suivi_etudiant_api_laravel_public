<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->softDeletes();
            $table->increments('id');
            $table->timestamps();
            $table->string('filename');
            $table->string('extension');
            $table->string('relative_path');
            $table->string('disk')->default('local');

            $table->unsignedInteger('document_type_id');
            $table->foreign('document_type_id')->references('id')->on('document_types')->onDelete('cascade');

            $table->unsignedInteger('debrief_id')->nullable();
            $table->foreign('debrief_id')->references('id')->on('debriefs')->onDelete('cascade');

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
        Schema::dropIfExists('documents');
    }
}
