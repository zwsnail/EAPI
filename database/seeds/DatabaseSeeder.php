<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        //这三个是自己建立的，然后用php artisan db:seed
        factory(App\User::class,5)->create();
        factory(App\Model\Product::class,50)->create();
        factory(App\Model\Review::class,300)->create();
    }
}