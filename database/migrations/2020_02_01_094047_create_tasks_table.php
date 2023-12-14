<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('task');
            $table->bigInteger('project_id');
            $table->bigInteger('user_id');
            $table->longText('description');
            $table->string('estimate')->nullable();
            $table->string('version');
            $table->integer('status');
            $table->string('created_by');
            $table->timestamps();
        });

        Schema::create('attachments', function (Blueprint $table) {
            $table->bigIncrements('id');      
            $table->string('type')->nullable();
            $table->string('attachment_id')->nullable();     
            $table->longText('name')->nullable();
            $table->longText('path')->nullable();
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
        Schema::dropIfExists('files');
        Schema::dropIfExists('tasks');
    }
}
