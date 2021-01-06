<?php

use App\Models\ScorecardSkill;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScorecardSkillTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scorecard_skill', function (Blueprint $table) {
            $table->softDeletes();
            $table->increments('id');
            $table->timestamps();

            $table->string('state')->default(ScorecardSkill::NOT_SEEN);

            $table->unsignedInteger('skill_id');
            $table->foreign('skill_id')->references('id')->on('skills');

            $table->unsignedInteger('scorecard_id');
            $table->foreign('scorecard_id')->references('id')->on('scorecards')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('scorecard_skill');
    }
}
