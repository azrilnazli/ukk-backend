<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTenderDetailIdToTenderCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tender_categories', function (Blueprint $table) {
            //
            //$table->foreignIdFor(\App\Models\TenderDetail::class); // User
            $table->string('tender_detail_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tender_categories', function (Blueprint $table) {
            //
            $table->dropColumn('tender_detail_id');
        });
    }
}
