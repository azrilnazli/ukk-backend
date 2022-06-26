<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToTenderSubmissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tender_submissions', function (Blueprint $table) {
            $table->foreignIdFor(\App\Models\TenderDetail::class)->nullable(); // TenderDetail
            $table->foreignIdFor(\App\Models\Company::class)->nullable(); // Company
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tender_submissions', function (Blueprint $table) {
            //
            $table->dropColumn('tender_detail_id');
            $table->dropColumn('company_id');
        });
    }
}
