<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('user_id')->index()->constrained()->cascadeOnDelete(); // Company belongsTo User
            $table->integer('user_id');
            $table->integer('company_id');
            $table->text('message');
            $table->boolean('is_case_closed')->default(1)->nullable(); // 0 is open, 1 is closed
            
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
        Schema::dropIfExists('comments');
    }
}
