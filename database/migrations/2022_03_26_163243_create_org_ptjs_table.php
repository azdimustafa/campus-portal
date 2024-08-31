<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrgPtjsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_org_ptjs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('code', 10)->nullable();
            $table->string('short_name', 100)->nullable();
            $table->string('name')->nullable();
            $table->string('name_my')->nullable();
            $table->string('email')->nullable();
            $table->boolean('is_academic')->default(0);
            $table->boolean('active')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sys_org_ptjs');
    }
}
