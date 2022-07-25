<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScreeningSignersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('screening_signers', function (Blueprint $table) {
            // relationships
            $table->foreignIdFor(\App\Models\User::class); // User
            $table->foreignIdFor(\App\Models\TenderSubmission::class)->nullable(); // TenderSubmission
            $table->integer('added_by')->nullable();
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
        Schema::dropIfExists('screening_signers');
    }
}
