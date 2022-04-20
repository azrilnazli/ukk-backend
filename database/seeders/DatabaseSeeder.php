<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Filesystem\Filesystem;
use File;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $file = new Filesystem;
        $file->cleanDirectory('storage/uploads');
        $file->cleanDirectory('storage/temp');
        $file->cleanDirectory('storage/secrets');

        $file->cleanDirectory('storage/assets');
        $file->cleanDirectory('storage/app/public/streaming');

        $file->cleanDirectory('storage/logs');
        File::put(storage_path() . '/logs/laravel.log', '');


        // \App\Models\User::factory(10)->create();
        //\App\Models\Video::factory(50)->create();
       
        $this->call(UserTableSeeder::class);
        $this->call(PermissionTableSeeder::class);
        $this->call(CategoryTableSeeder::class);
    }
}
