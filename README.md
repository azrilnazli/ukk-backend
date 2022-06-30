composer update
php artisan key:generate
php artisan storage:link
php artisan migrate:fresh --seed
php artisan queue:listen --timeout=0
-- insert video at system first --
-- make sure to configure ffmpeg, check path in config file 
php artisan db:seed --class=VideoTableSeeder
php artisan video:copy


