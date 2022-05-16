<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\User;
use App\Models\Video;
use App\Models\Tender;

class CreateTenderSubmissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tender_submissions', function (Blueprint $table) {
            $table->id(); // submission id

            // relationship
            $table->foreignIdFor(User::class); // user 
            $table->foreignIdFor(Video::class)->nullable(); // video
            $table->foreignIdFor(Tender::class); // Tender

            // core data
            $table->string('theme')->nullable(); // user submit
            $table->string('genre')->nullable(); // user submit
            $table->text('concept')->nullable(); // user submit
            $table->text('synopsis')->nullable(); // user submit

            // flags
            $table->boolean('is_video')->nullable()->default(0); // if user upload video
            $table->boolean('is_pdf_cert_uploaded')->nullable()->default(0); // if user upload PDF

            $table->timestamps(); // datetime
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tender_submissions');
    }
}
