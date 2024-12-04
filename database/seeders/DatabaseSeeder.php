<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Admin User',
        //     'username' => 'adminsatu',
        //     'email' => 'adminrentit@gmail.com',
        //     'nim' => '1234567890',
        //     'email_verified_at' => now(),
        //     'password' => 'password', // password
        //     'isAdmin' => true,
        //     // 'remember_token' => Str::random(10)
        // ]);

        \App\Models\User::create([
            'name' => 'Evelyn Aritonang',
            'username' => 'Evelyn',
            'email' => 'evlyn.art@gmail.com',
            'nim' => '123456',
            'password' => bcrypt('password'),
            'isAdmin' => 0,
        ]);
        \App\Models\User::create([
            'name' => 'Fanni Ghina',
            'username' => 'Fanni',
            'email' => 'admin@gmail.com',
            'nim' => '111111',
            'password' => bcrypt('password'),
            'isAdmin' => 1,
        ]);

        Category::create([
            'name' => 'Classes',
            'slug' => 'classes'
        ]);
        Category::create([
            'name' => 'Buildings',
            'slug' => 'buildings'
        ]);
        Category::create([
            'name' => 'Sports',
            'slug' => 'sports'
        ]);

        $this->call(FacilitySeeder::class);
        $this->call(KelasSeeder::class);
    }
}
