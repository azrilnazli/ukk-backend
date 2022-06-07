<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\User;
use App\Models\TenderSubmission;
use App\Models\Tender;
use App\Models\Company;


class CreateSignersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('signers', function (Blueprint $table) {
            $table->id();

            // relationships
            $table->foreignIdFor(User::class); // User
            $table->foreignIdFor(TenderSubmission::class)->nullable(); // TenderSubmission
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
        Schema::dropIfExists('signers');
    }
}
