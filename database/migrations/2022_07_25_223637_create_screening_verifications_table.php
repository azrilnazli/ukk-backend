<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScreeningVerificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('screening_verifications', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\User::class); // User
            $table->foreignIdFor(\App\Models\TenderSubmission::class)->nullable(); // TenderSubmission
            $table->boolean('is_verified')->default(0);
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
        Schema::dropIfExists('screening_verifications');
    }
}
