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
            $table->text('login_text')->nullable();
            $table->text('dashboard_text')->nullable();
            $table->text('proposal_text')->nullable();
            $table->boolean('is_active')->default(false);

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
