<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Test-user',
            'email' => 'test@example.com',
            'password' => bcrypt('test-video-uploader'),
        ]);

    }
}
