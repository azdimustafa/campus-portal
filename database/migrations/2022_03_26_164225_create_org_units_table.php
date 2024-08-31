<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrgUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_org_units', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->char('ptj_id', 36);
            $table->char('department_id', 36);
            $table->char('division_id', 36);
            $table->char('section_id', 36);
            $table->string('code', 50)->nullable();
            $table->string('short_name', 100)->nullable();
            $table->string('name')->nullable();
            $table->string('name_my')->nullable();
            $table->boolean('active')->default(1);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('ptj_id')->on('sys_org_ptjs')->references('id')->onDelete('cascade');
            $table->foreign('department_id')->on('sys_org_departments')->references('id')->onDelete('cascade');
            $table->foreign('division_id')->on('sys_org_divisions')->references('id')->onDelete('cascade');
            $table->foreign('section_id')->on('sys_org_sections')->references('id')->onDelete('cascade');

            
        });

        Schema::table('sys_org_units', function (Blueprint $table) {
            $table->unsignedBigInteger('created_by')->after('created_at')->nullable();
            $table->unsignedBigInteger('updated_by')->after('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sys_org_units');
    }
}
