<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTenderDetailTenderRequirementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tender_detail_tender_requirement', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\TenderDetail::class)->nullable(); // TenderDetail
            $table->foreignIdFor(\App\Models\TenderRequirement::class)->nullable(); // TenderRequirement

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tender_detail_tender_requirement');
 
    }
}
