composer update
php artisan key:generate
php artisan storage:link
php artisan migrate:fresh --seed

-- insert video at system first --
php artisan db:seed --class=VideoTableSeeder
php artisan video:copy
#   u k k - b a c k e n d  
 