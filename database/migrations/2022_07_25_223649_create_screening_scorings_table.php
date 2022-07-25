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

            $table->integer('storyline')->default(0);
            $table->integer('theme')->default(0);
            $table->integer('concept')->default(0);
            $table->integer('originality')->default(0);

            $table->integer('structure')->default(0);
            $table->integer('storytelling')->default(0);
            $table->integer('objective')->default(0);
            $table->integer('props')->default(0);
            $table->integer('impact')->default(0);
            $table->integer('value_added')->default(0);

            $table->text('comment')->nullable();

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
