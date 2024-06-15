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
        Schema::table('soe_budget_allocation', function (Blueprint $table) {
            $table->decimal('hod_outlay', 11, 2);
            $table->decimal('district_outlay', 11, 2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('soe_budget_allocation', function (Blueprint $table) {
            $table->dropColumn('hod_outlay');
            $table->dropColumn('hod_outlay');
        });
    }
};