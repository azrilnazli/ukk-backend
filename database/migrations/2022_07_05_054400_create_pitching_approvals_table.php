<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePitchingApprovalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pitching_approvals', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\User::class); // User
            $table->foreignIdFor(\App\Models\TenderSubmission::class)->nullable(); // TenderSubmission
            $table->boolean('is_approved')->default(0);
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
        Schema::dropIfExists('pitching_approvals');
    }
}
