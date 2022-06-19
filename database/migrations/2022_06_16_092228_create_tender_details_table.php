<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTenderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tender_details', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\User::class); // User
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->integer('max')->default(0);
            $table->date('start')->nullable();
            $table->date('end')->nullable();
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
        Schema::dropIfExists('tender_details');
    }
}
