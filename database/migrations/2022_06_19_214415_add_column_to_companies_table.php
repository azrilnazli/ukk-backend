<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->foreignIdFor(\App\Models\TenderDetail::class)->nullable(); // TenderDetail
            // authorization_letter
            $table->boolean('is_authorization_letter_cert_uploaded')->nullable()->default(0);

            // company_official_letter
            $table->boolean('is_official_company_letter_cert_uploaded')->nullable()->default(0);
            $table->boolean('is_pending')->default(0)->nullable(); // pending
            $table->string('status')->nullable(); // current status
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn('tender_detail_id');
            $table->dropColumn('is_authorization_letter_cert_uploaded');
            $table->dropColumn('is_company_official_letter_cert_uploaded');
            $table->dropColumn('is_pending');
            $table->dropColumn('status');
        });
    }
}
