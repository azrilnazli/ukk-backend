<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScreeningScoringsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('screening_scorings', function (Blueprint $table) {
            $table->foreignIdFor(\App\Models\User::class); // User
            $table->foreignIdFor(\App\Models\TenderSubmission::class)->nullable(); // TenderSubmission

            $table->integer('criteria')->default(0); // 40%
            $table->integer('storyline')->default(0); // 10%
            $table->integer('creativity')->default(0); // 10%
            $table->integer('technical')->default(0); // 10%
            $table->integer('acting')->default(0); // 10%
            $table->integer('value_added')->default(0); // 20%

            $table->text('comment')->nullable();

            $table->boolean('pematuhan')->default(0); // pematuhan need_statement
            $table->boolean('is_suitable')->default(0); // show suitability
            $table->boolean('need_statement_comply')->default(0);
            $table->boolean('is_comply')->default(0);

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
        Schema::dropIfExists('screening_scorings');
    }
}
