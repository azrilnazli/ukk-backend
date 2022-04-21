<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->index()->constrained()->cascadeOnDelete(); // Company belongsTo User
            
            // general info
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->integer('postcode')->nullable();
            $table->string('city')->nullable();
            $table->string('states')->nullable();
            $table->date('registration_date')->nullable();
            
            // suruhanjaya syarikat malaysia
            $table->string('cert_ssm')->nullable();
            $table->boolean('is_ssm_uploaded')->default(0);

            // ministry of finance
            $table->string('cert_mof')->nullable();
            $table->boolean('is_eperolehan_active')->default(0);
            $table->boolean('is_mof_cert_uploaded')->default(0);

            // kementerian komunikasi
            $table->string('cert_kkmm_publisher')->nullable();
            $table->boolean('is_kkmm_publisher_cert_uploaded')->default(0);
            $table->string('cert_kkmm_syndicated')->nullable();
            $table->boolean('is_kkmm_syndicated_cert_uploaded')->default(0);

            // finas
            $table->string('cert_finas_publisher')->nullable();
            $table->boolean('is_finas_publisher_cert_uploaded')->default(0);

            $table->boolean('is_bumiputera')->default(0);
            $table->boolean('is_bumiputera_cert_uploaded')->default(0);

            // misc info
            $table->text('board_of_directors')->nullable();
            $table->text('experiences')->nullable();
            $table->integer('paid_capital')->nullable();

            // company audit
            $table->string('current_audit_year')->nullable();
            $table->boolean('is_current_audit_year_uploaded')->default(0);

            // company bank
            $table->string('bank_name')->nullable();
            $table->string('bank_branch')->nullable();
            $table->string('bank_statement')->nullable();
            $table->date('bank_statement_date_start')->nullable();
            $table->date('bank_statement_date_end')->nullable();
            $table->integer('bank_account_number')->nullable();
            $table->boolean('is_bank_cert_uploaded')->default(0);    
            $table->boolean('is_credit_cert_uploaded')->default(0);

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
        Schema::dropIfExists('companies');
    }
}
