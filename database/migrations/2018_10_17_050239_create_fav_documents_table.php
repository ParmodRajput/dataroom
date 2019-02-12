<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFavDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fav_documents', function (Blueprint $table) {

            $table->increments('id');
            $table->string('document_id');
            $table->string('document_path');
            $table->string('user_id');
            $table->string('project_id');
            $table->string('directory_url');
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
        Schema::dropIfExists('fav_documents');
    }
}
