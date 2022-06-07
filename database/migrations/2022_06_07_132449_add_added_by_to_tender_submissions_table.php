<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAddedByToTenderSubmissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tender_submissions', function (Blueprint $table) {
            //
            $table->integer('added_by')->nullable()->default(0);
            $table->boolean('is_scoring_completed')->nullable()->default(0); // if user upload PDF
            $table->boolean('is_verification_completed')->nullable()->default(0); // if user upload PDF
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
            $table->dropColumn('added_by');
            $table->dropColumn('is_scoring_completed');
            $table->dropColumn('is_verification_completed');
        });
    }
}
