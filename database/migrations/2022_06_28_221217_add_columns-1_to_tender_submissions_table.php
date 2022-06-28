<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumns1ToTenderSubmissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tender_submissions', function (Blueprint $table) {
            //

            $table->integer('published_year')->nullable();
            $table->text('casts')->nullable();
            $table->text('languages')->nullable();
            $table->string('total_episode')->nullable();
            $table->string('duration')->nullable();
            $table->string('country')->nullable();

            $table->decimal('price_episode', 13, 2);
            $table->decimal('price_overall', 13, 2);

            $table->text('rules')->nullable();
            $table->text('informations')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tender_submissions', function (Blueprint $table) {
            //
            $table->dropColumn('published_year');
            $table->dropColumn('casts');
            $table->dropColumn('languages');
            $table->dropColumn('total_episode');
            $table->dropColumn('duration');
            $table->dropColumn('country');
            $table->dropColumn('price_episode');
            $table->dropColumn('price_overall');
            $table->dropColumn('rules');
            $table->dropColumn('informations');

        });
    }
}
