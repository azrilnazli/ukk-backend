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
           // $table->foreignId('user_id')->index()->constrained()->cascadeOnDelete(); // Company belongsTo User
           $table->integer('user_id');
            
            // general info
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('postcode')->nullable();
            $table->string('city')->nullable();
            $table->string('states')->nullable();
            $table->date('registration_date')->nullable();
            
            // suruhanjaya syarikat malaysia
            $table->string('ssm_registration_number')->nullable();
            $table->boolean('is_ssm_cert_uploaded')->default(0);
            $table->date('ssm_expiry_date')->nullable();
            

            // ministry of finance
            $table->string('mof_registration_number')->nullable();
            $table->boolean('is_mof_active')->default(0);
            $table->boolean('is_mof_cert_uploaded')->default(0);
            $table->date('mof_expiry_date')->nullable();

            // kementerian komunikasi
            $table->string('kkmm_fp_registration_number')->nullable();
            $table->boolean('is_kkmm_fp_cert_uploaded')->default(0);
            $table->date('kkmm_fp_expiry_date')->nullable();

            $table->string('kkmm_fd_registration_number')->nullable();
            $table->boolean('is_kkmm_fd_cert_uploaded')->default(0);
            $table->date('kkmm_fd_expiry_date')->nullable();

            // finas
            $table->string('finas_fp_registration_number')->nullable();
            $table->boolean('is_finas_fp_cert_uploaded')->default(0);
            $table->date('finas_fp_expiry_date')->nullable();

            $table->string('finas_fd_registration_number')->nullable();
            $table->boolean('is_finas_fd_cert_uploaded')->default(0);
            $table->date('finas_fd_expiry_date')->nullable();

            // bumiputera
            $table->boolean('is_bumiputera')->default(0);
            $table->string('bumiputera_registration_number')->nullable();
            $table->boolean('is_bumiputera_cert_uploaded')->default(0);
            $table->date('bumiputera_expiry_date')->nullable();

            // misc info
            $table->text('board_of_directors')->nullable();
            $table->text('experiences')->nullable();

            // kewangan
            $table->float('paid_capital')->nullable();
            $table->string('current_audit_year')->nullable();
            $table->boolean('is_current_audit_year_cert_uploaded')->default(0);

            // company bank
            $table->string('bank_name')->nullable();
            $table->string('bank_branch')->nullable();


            $table->date('is_bank_cert_uploaded')->nullable();
            $table->date('bank_statement_date_start')->nullable();
            $table->date('bank_statement_date_end')->nullable();


            $table->string('bank_account_number')->nullable();    
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
