<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiplomaSkillTemplateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diploma_skill_template', function (Blueprint $table) {
            $table->softDeletes();
            $table->increments('id');
            $table->timestamps();

            $table->unsignedInteger('skill_template_id');
            $table->foreign('skill_template_id')->references('id')->on('skill_templates');

            $table->unsignedInteger('diploma_id');
            $table->foreign('diploma_id')->references('id')->on('diplomas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('diploma_skill_template');
    }
}
