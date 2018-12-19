<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groups', function (Blueprint $table) {
            $table->increments('id');
            $table->string('group_name');
            $table->string('project_id');
            $table->boolean('group_status',true)->comment   = "0=inactive,1=active";
            $table->string('group_for');
            $table->string('group_user_type');
            $table->string('collaboration_with');
            $table->string('access_limit');
            $table->date('active_date');
            $table->string('QA_access_limit');
            $table->string('created_by');
            $table->string('updated_by');
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
        Schema::dropIfExists('groups');
    }
}
