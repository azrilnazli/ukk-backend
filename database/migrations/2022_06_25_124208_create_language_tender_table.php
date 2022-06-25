<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLanguageTenderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('language_tender', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Tender::class)->nullable(); // Tender
            $table->foreignIdFor(\App\Models\Language::class)->nullable(); // Language
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
        Schema::dropIfExists('language_tender');
    }
}
