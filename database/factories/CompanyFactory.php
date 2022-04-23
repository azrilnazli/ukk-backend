<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [

            // company info
            'user_id' => 1,
            'name' => $this->faker->company(),
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
            'city' => $this->faker->city(),
            'postcode' => $this->faker->postcode(),
            'states' => $this->faker->state(),
            'registration_date' => $this->faker->date(),

            // ssm
            'ssm_registration_number' => $this->faker->numerify('ssm-#####'),
            'is_ssm_cert_uploaded' => $this->faker->boolean(),
            'ssm_expiry_date' => $this->faker->date(),

            // // mof
            'mof_registration_number' => $this->faker->numerify('mof-#####'),
            'is_mof_cert_uploaded' => $this->faker->boolean(),
            'is_mof_active' => $this->faker->boolean(),
            'mof_expiry_date' => $this->faker->date(),

            // // kkmm fp
            'kkmm_fp_registration_number' => $this->faker->numerify('kkmm-fp-#####'),
            'is_kkmm_fp_cert_uploaded' => $this->faker->boolean(),
            'kkmm_fp_expiry_date' => $this->faker->date(),

            // // kkmm fd
            'kkmm_fd_registration_number' => $this->faker->numerify('kkmm-fd-#####'),
            'is_kkmm_fd_cert_uploaded' => $this->faker->boolean(),
            'kkmm_fd_expiry_date' => $this->faker->date(),

            // // finas fp
            'finas_fp_registration_number' => $this->faker->numerify('finas-fp-#####'),
            'is_finas_fp_cert_uploaded' => $this->faker->boolean(),
            'finas_fp_expiry_date' => $this->faker->date(),

            // // finas fd
            'finas_fd_registration_number' => $this->faker->numerify('finas-fd-#####'),
            'is_finas_fd_cert_uploaded' => $this->faker->boolean(),
            'finas_fd_expiry_date' => $this->faker->date(),
      
            // status bumi
            'is_bumiputera' => $this->faker->boolean(),
            'is_bumiputera_cert_uploaded' => $this->faker->boolean(),
            'bumiputera_expiry_date' => $this->faker->date(),

            // board of directors
            'board_of_directors' => $this->faker->words(5,true),
            'experiences' => $this->faker->paragraph(),
            'paid_capital' => $this->faker->numberBetween(5000,100000),

            // audit
            'current_audit_year' => $this->faker->date('Y'),
            'is_current_audit_year_cert_uploaded' => $this->faker->boolean(),

            // bank info
            'bank_name' => $this->faker->word(),
            'bank_branch' => $this->faker->city(),
            'bank_account_number' => $this->faker->numerify('bank-#####'),
            'bank_statement_date_start' => $this->faker->date(),
            'bank_statement_date_end' => $this->faker->date(),
            'is_credit_cert_uploaded' => $this->faker->boolean(),

        ];
    }
}
