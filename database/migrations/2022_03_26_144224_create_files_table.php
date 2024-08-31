<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_files', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('context');
            $table->string('ori_file_name');
            $table->string('file_name');
            $table->string('file_size');
            $table->string('mime_type');
            $table->string('path');
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
        Schema::dropIfExists('sys_files');
    }
}
