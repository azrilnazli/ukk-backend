<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TenderTenderLanguages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tender_tender_language', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Tender::class)->nullable(); // TenderDetail
            $table->foreignIdFor(\App\Models\TenderLanguage::class)->nullable(); // TenderRequirement
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
        Schema::dropIfExists('tender_tender_language');
    }
}
