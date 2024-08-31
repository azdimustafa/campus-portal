<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrgDepartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_org_departments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->char('ptj_id', 36);
            $table->string('code', 20)->nullable();
            $table->string('short_name', 100)->nullable();
            $table->string('name')->nullable();
            $table->string('name_my')->nullable();
            $table->string('email')->nullable();
            $table->boolean('is_academic')->default(0);
            $table->boolean('active')->default(1);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('ptj_id')->on('sys_org_ptjs')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sys_org_departments');
    }
}
