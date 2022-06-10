<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\User;
use App\Models\TenderSubmission;
use App\Models\Tender;

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

            // relationship
            $table->foreignIdFor(User::class); // user
            $table->foreignIdFor(TenderSubmission::class)->nullable(); // video
            $table->foreignIdFor(Tender::class); // Tender
            $table->string('job_id')->nullable(); // Job

            $table->string('original_filename')->nullable();
            $table->boolean('is_processing')->default(0); // true for processing
            $table->boolean('is_ready')->default(0); // true for ready
            $table->bigInteger('processing_duration')->nullable()->default(0); // processing duration in seconds
            $table->bigIinteger('uploading_duration')->nullable()->default(0); // upload duration in seconds

            // hello world

            // ffprobe -v error -select_streams v:0 -show_entries stream=width,height,duration,bit_rate -of default=noprint_wrappers=1 input.mp4
            $table->integer('duration')->nullable()->default(0); // video length in seconds
            $table->string('filesize')->nullable()->default(0); // video size
            $table->integer('width')->nullable()->default(0); // video width
            $table->integer('height')->nullable()->default(0); // video height
            $table->integer('bitrate')->nullable()->default(0); // video bitrate in bps
            $table->integer('asset_size')->nullable()->default(0); // HLS asset size
            $table->string('format')->nullable(); // original video format
            $table->integer('max_resolution')->nullable()->default(0); // video resoluti

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
        Schema::dropIfExists('videos');
    }
}
