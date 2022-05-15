<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTendersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tenders', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();

            $table->integer('ordering')->default(0)->nullable();
            $table->boolean('is_publish')->default(0)->nullable();

            $table->enum('type',  ['SAMBUNG SIRI' , 'SWASTA'])->default('SAMBUNG SIRI'); // classifications
            $table->enum('channel',  ['TV1', 'TV2', 'OKEY','BERITA','SUKAN'])->default('TV1'); // classifications
            $table->enum('language',  ['MELAYU', 'INGGERIS', 'TAMIL','MANDARIN'])->default('MELAYU'); // classifications

            $table->integer('tender_category_id')->nullable(); // belongsTo TenderCategory
            $table->integer('programme_code_id')->nullable(); // belongsTo ProgrammeCode
            
            $table->string('languages')->nullable();
            $table->string('programme_code')->nullable();
            $table->string('tender_category')->nullable();

            $table->string('number_of_episode')->nullable();
            $table->integer('duration')->nullable();
            
            //$table->string('title')->nullable();
            $table->text('description')->nullable();
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
        Schema::dropIfExists('tenders');
    }
}
