<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('soe_budget_distribution', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('department_id');
            $table->unsignedBigInteger('majorhead_id');
            $table->unsignedBigInteger('scheme_id');
            $table->unsignedBigInteger('soe_id');
            $table->unsignedBigInteger('fin_year_id');
            $table->decimal('outlay',11,2);
            $table->unsignedBigInteger('district_id');
            $table->timestamps();
            $table->foreign('department_id')->references('id')->on('departments');
            $table->foreign('majorhead_id')->references('id')->on('majorhead');
            $table->foreign('scheme_id')->references('id')->on('scheme_master');
            $table->foreign('soe_id')->references('id')->on('soe_master');
            $table->foreign('fin_year_id')->references('id')->on('fin-years');
            $table->foreign('district_id')->references('id')->on('districts');
        });
    }

    public function down()
    {
        Schema::dropIfExists('soe_budget_distribution');
    }
};
