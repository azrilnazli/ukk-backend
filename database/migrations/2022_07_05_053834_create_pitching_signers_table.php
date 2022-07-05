<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePitchingSignersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pitching_signers', function (Blueprint $table) {
            $table->id();

            // relationships
            $table->foreignIdFor(\App\Models\User::class); // User
            $table->foreignIdFor(\App\Models\TenderSubmission::class)->nullable(); // TenderSubmission
            $table->string('type')->string()->nullable(); // penanda / urusetia
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
        Schema::dropIfExists('pitching_signers');
    }
}
