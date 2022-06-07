<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\User;
use App\Models\TenderSubmission;
use App\Models\Tender;
use App\Models\Company;

class CreateScoringsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scorings', function (Blueprint $table) {
            $table->id();

            // relationships
            $table->foreignIdFor(User::class); // User
            $table->foreignIdFor(TenderSubmission::class)->nullable(); // TenderSubmission
            $table->foreignIdFor(Tender::class)->nullable(); // Tender
            $table->foreignIdFor(Company::class)->nullable(); // Company

            $table->enum('assessment',  ['berupaya', 'berwibawa', 'baharu'])->nullable(); // assessment
            $table->integer('assessment_result')->nullable();; 

            $table->boolean('need_statement_comply')->default(0);

            $table->boolean('tajuk_status')->default(0);
            $table->text('tajuk_message')->nullable();

            $table->boolean('sinopsis_status')->default(0);
            $table->text('sinopsis_message')->nullable();

            $table->boolean('idea_dan_subjek_status')->default(0);
            $table->text('idea_dan_subjek_message')->nullable();

            $table->boolean('lengkap_status')->default(0);
            $table->text('lengkap_message')->nullable();

            $table->boolean('menepati_keperluan_asas_status')->default(0);
            $table->text('menepati_keperluan_asas_message')->nullable();

            $table->boolean('syor_status')->default(0);
            $table->text('syor_message_true')->nullable();
            $table->text('syor_message_false')->nullable();

            $table->boolean('pengesahan_comply')->default(0);
            $table->boolean('is_verified_by_urusetia')->default(0);
            
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
        Schema::dropIfExists('scorings');
    }
}
