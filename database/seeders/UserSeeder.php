<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        \App\Models\User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@warga08.test',
            'password' => Hash::make('admin100%'),
            'role' => 'admin',
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Bisri Ali',
            'email' => 'alibisri158@gmail.com',
            "phone" => "087783103733",
            'address' => 'Jalan Haji Kelik Gang Lada',
            'password' => Hash::make('rw123'),
            'role' => 'rw',
        ]);
            
        \App\Models\User::factory()->create([
            'name' => 'Kurtubi',
            'email' => "kurtubi2111@gmail.com",
            "phone" => "082122903115",
            'address' => 'Jln.Raya Kelapa Dua No. 12',
            'password' => Hash::make('rt123'),
            'role' => 'rt',
            'rt'=>1,
        ]);
        
        \App\Models\User::factory()->create([
            'name' => 'Ir. H. Jamaludin',
            'email' => "hjamal2008@gmail.com",
            "phone" => "0817878008",
            'address' => 'Jln. H. Rausin No. 25',
            'password' => Hash::make('rt123'),
            'role' => 'rt',
            'rt'=>2,
        ]);
        
        \App\Models\User::factory()->create([
            'name' => 'Muhammad Fitrah udin',
            'email' => "aufklarung1899@gmail.com",
            "phone" => "0817724441",
            "address" => 'jl. Raya kelapa dua no. 1',
            'password' => Hash::make('rt123'),
            'role' => 'rt',
            'rt'=>3,
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Abdullah Ali',
            'email' => "alihajis@gmail.com",
            "phone" => "089676391532",
            'address' => 'Jalan Haji Kelik Gang Lada No 180',
            'password' => Hash::make('rt123'),
            'role' => 'rt',
            'rt'=>4,
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Muhammad Irvan',
            'email' => "boydratz@Gmail.com",
            "phone" => "081295846888",
            'address' => 'Jln.H.Rausin Gang. Kayu Manis II',
            'password' => Hash::make('rt123'),
            'role' => 'rt',
            'rt'=>5,
        ]);

        \App\Models\User::factory()->create([
            'name' => 'H. Dody Syaiful Anwar',
            'email' => "Dodysaifulanwar@gmail.com",
            'phone' => '081905508141',
            'address' => 'Komplek DPR RI No. 28',
            'password' => Hash::make('rt6'),
            'role' => 'rt',
            'rt'=>6,
        ]);

        \App\Models\User::factory()->create([
            'name' => 'H. Uus Agustino',
            'email' => "uus.agustino1150@gmail.com",
            'phone' => '081316313273',
            'address' => 'Jln. H. Arisan No. 72A',
            'password' => Hash::make('rt123'),
            'role' => 'rt',
            'rt'=>7,
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Drs. Deny Hardipriyatna',
            'email' => "denihardi22@gmail.com",
            'address' => 'Jl. H. Usman No. 96 Rt. 008 / Rw. 08',
            'phone' => '081210066123',
            'password' => Hash::make('rt8'),
            'role' => 'rt',
            'rt'=>8,
        ]);
    }
}
