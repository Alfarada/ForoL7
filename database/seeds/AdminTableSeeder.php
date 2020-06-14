<?php

use App\User;
use Illuminate\Database\Seeder;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class)->create([
            'first_name' => 'Alfredo',
            'last_name' => 'Yepez',
            'username' => 'Alfarada',
            'email' => 'hi@example.com',
            'role' => 'admin'
        ]);
    }
}
