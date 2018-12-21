<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionReplyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('question_reply', function (Blueprint $table) {
            
            $table->increments('id'); 
            $table->string('question_id');
            $table->string('project_id');
            $table->string('reply_subject');
            $table->string('reply_content');
            $table->string('reply_status');
            $table->string('reply_by');
            $table->string('reply_to');
            $table->string('time');
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
        Schema::dropIfExists('question_reply');
    }
}
