<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScreeningOwnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('screening_owners', function (Blueprint $table) {
            $table->id();

            // relationships
            $table->foreignIdFor(\App\Models\User::class); // Owner for TenderSubmission
            $table->foreignIdFor(\App\Models\TenderSubmission::class)->nullable(); // TenderSubmission
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
        Schema::dropIfExists('screening_owners');
    }
}
