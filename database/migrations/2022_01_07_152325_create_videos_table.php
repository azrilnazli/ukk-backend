<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->index()->constrained()->cascadeOnDelete(); // Video belongsTo User
            $table->foreignId('category_id')->index()->constrained()->cascadeOnDelete(); // Video belongsTo Category
       
            $table->string('original_filename');
            $table->string('title');
            $table->text('synopsis');
            
            $table->boolean('processing')->default(0); // flag for video readiness
            $table->integer('processing_duration')->nullable()->default(0); // processing duration in seconds
            $table->integer('uploading_duration')->nullable()->default(0); // upload duration in seconds
            $table->boolean('public')->default(0); // flag to show to public
            $table->boolean('downloadable')->default(0); // allow download ? 

            // ffprobe -v error -select_streams v:0 -show_entries stream=width,height,duration,bit_rate -of default=noprint_wrappers=1 input.mp4
            $table->integer('duration')->nullable()->default(0); // video length in seconds
            $table->biginteger('filesize')->nullable()->default(0); // video size
            $table->integer('width')->nullable()->default(0); // video width
            $table->integer('height')->nullable()->default(0); // video height
            $table->integer('bitrate')->nullable()->default(0); // video bitrate in bps
            $table->integer('asset_size')->nullable()->default(0); // HLS asset size
            $table->string('format')->nullable(); // original video format

            $table->uuid('job_id')->nullable(); // to detect failed jobs
            $table->integer('max_resolution')->nullable()->default(0); // video resolution

            $table->enum('classifications',  ['18SG', '18SX', '18PA','18PL','U','P13'])->default('U'); // classifications
            $table->integer('publish')->default(0); // publish to public flag
         


            $table->timestamps();
        });

        Schema::table('videos', function($table) {
            // fk for Category
            /*
            $table->foreign('category_id')->references('id')
            ->on('categories')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            */
            //$table->integer('category_id')->unsigned();
            //$table->foreignId('category_id')->index()->constrained()->cascadeOnDelete(); // Video belongsTo User
        });
     
    }




    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('videos');
    }
}
