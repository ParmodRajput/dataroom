<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShareDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('share_documents', function (Blueprint $table) {
            $table->increments('id');
            $table->date('duration_time');
            $table->string('project_id');
            $table->string('document_id');
            $table->string('Shared_with');
            $table->string('Shared_by');
            $table->string('register_required');
            $table->string('printable');
            $table->string('downloadable');
            $table->string('access_token');
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
        Schema::dropIfExists('share_documents');
    }
}
