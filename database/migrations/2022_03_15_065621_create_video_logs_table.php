<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVideoLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('video_logs', function (Blueprint $table) {
            $table->id();
            //$table->foreignId('user_id')->index()->constrained()->cascadeOnDelete(); 
            //$table->foreignId('video_id')->index()->constrained()->cascadeOnDelete(); 
            $table->integer('user_id')->nullable();
            $table->integer('video_id')->nullable();
            $table->string('request')->nullable();
            $table->string('bitrate')->nullable();
            $table->dateTime('time')->nullable();
            $table->integer('status')->nullable();
            $table->integer('responseBytes')->nullable();
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
        Schema::dropIfExists('video_logs');
    }
}
