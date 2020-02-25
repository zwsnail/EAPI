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
        //注意这个顺序，必须先有user才能有product和review
        factory(App\User::class,5)->create();
        factory(App\Model\Product::class,50)->create();
        factory(App\Model\Review::class,300)->create();
    }
}
