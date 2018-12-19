<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->string('doc_index');
            $table->string('project_id');
            $table->string('document_name');
            $table->string('path');
            $table->string('directory_url');
            $table->string('document_status');
            $table->string('type');
            $table->string('deleted_at');
            $table->string('restored_at');
            $table->string('uploaded_by');
            $table->string('updated_by');
            $table->string('deleted_by');
            $table->string('restored_by');
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
        Schema::dropIfExists('documents');
    }
}
