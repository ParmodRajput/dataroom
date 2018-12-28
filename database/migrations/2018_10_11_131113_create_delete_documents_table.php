<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeleteDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delete_documents', function (Blueprint $table) {
            $table->increments('id');
            $table->string('deleted_file');
            $table->string('deleted_folder');
            $table->string('project_id');
            $table->string('deleted_from');
            $table->string('document_status');
            $table->string('deleted_by');
            $table->string('restored_by');
            $table->string('deleted_time');
            $table->string('restored_time');
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
        Schema::dropIfExists('delete_documents');
    }
}
