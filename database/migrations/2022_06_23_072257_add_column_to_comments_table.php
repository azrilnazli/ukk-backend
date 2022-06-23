<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('comments', function (Blueprint $table) {
            //
            //$table->dropColumn('company_id');
            //$table->integer('company_id')->nullable()->change();
            $table->foreignIdFor(\App\Models\CompanyApproval::class)->nullable(); // CompanyApproval

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('comments', function (Blueprint $table) {
            //

            $table->dropColumn('company_approval_id');
        });
    }
}
