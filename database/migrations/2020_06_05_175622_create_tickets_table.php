<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('submitter_id');
            $table->foreignId('assignee_id');
            $table->foreignId('project_id');
            $table->foreign('submitter_id')->references('id')->on('users');
            $table->foreign('assignee_id')->references('id')->on('users');
            $table->foreign('project_id')->references('id')->on('projects');
            $table->string('title');
            $table->string('description');
            $table->string('priority');
            $table->string('status');
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
        Schema::dropIfExists('tickets');
    }
}
