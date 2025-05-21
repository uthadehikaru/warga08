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
        \App\Models\User::firstOrCreate([
            'email' => 'admin@warga08.test',
        ],[
            'name' => 'Admin',
            'password' => Hash::make('admin100%'),
            'role' => 'admin',
        ]);

        \App\Models\User::firstOrCreate([
            'email' => 'alibisri158@gmail.com',
        ],[
            'name' => 'Bisri Ali',
            "phone" => "087783103733",
            'address' => 'Jalan Haji Kelik Gang Lada',
            'password' => Hash::make('rw123'),
            'role' => 'rw',
        ]);
            
        \App\Models\User::firstOrCreate([
            'email' => "kurtubi2111@gmail.com",
        ],[
            'name' => 'Kurtubi',
            "phone" => "082122903115",
            'address' => 'Jln.Raya Kelapa Dua No. 12',
            'password' => Hash::make('rt123'),
            'role' => 'rt',
            'rt'=>1,
        ]);
        
        \App\Models\User::firstOrCreate([
            'email' => "hjamal2008@gmail.com",
        ],[
            'name' => 'Ir. H. Jamaludin',
            "phone" => "0817878008",
            'address' => 'Jln. H. Rausin No. 25',
            'password' => Hash::make('rt123'),
            'role' => 'rt',
            'rt'=>2,
        ]);
        
        \App\Models\User::firstOrCreate([
            'email' => "aufklarung1899@gmail.com",
        ],[
            'name' => 'Muhammad Fitrah udin',
            "phone" => "0817724441",
            "address" => 'jl. Raya kelapa dua no. 1',
            'password' => Hash::make('rt123'),
            'role' => 'rt',
            'rt'=>3,
        ]);

        \App\Models\User::firstOrCreate([
            'email' => "alihajis@gmail.com",
        ],[
            'name' => 'Abdullah Ali',
            "phone" => "089676391532",
            'address' => 'Jalan Haji Kelik Gang Lada No 180',
            'password' => Hash::make('rt123'),
            'role' => 'rt',
            'rt'=>4,
        ]);

        \App\Models\User::firstOrCreate([
            'email' => "boydratz@Gmail.com",
        ],[
            'name' => 'Muhammad Irvan',
            "phone" => "081295846888",
            'address' => 'Jln.H.Rausin Gang. Kayu Manis II',
            'password' => Hash::make('rt123'),
            'role' => 'rt',
            'rt'=>5,
        ]);

        \App\Models\User::firstOrCreate([
            'email' => "Dodysaifulanwar@gmail.com",
        ],[
            'name' => 'H. Dody Syaiful Anwar',
            'phone' => '081905508141',
            'address' => 'Komplek DPR RI No. 28',
            'password' => Hash::make('rt6'),
            'role' => 'rt',
            'rt'=>6,
        ]);

        \App\Models\User::firstOrCreate([
            'email' => "uus.agustino1150@gmail.com",
        ],[
            'name' => 'H. Uus Agustino',
            'phone' => '081316313273',
            'address' => 'Jln. H. Arisan No. 72A',
            'password' => Hash::make('rt123'),
            'role' => 'rt',
            'rt'=>7,
        ]);

        \App\Models\User::firstOrCreate([
            'email' => "denihardi22@gmail.com",
        ],[
            'name' => 'Drs. Deny Hardipriyatna',
            'address' => 'Jl. H. Usman No. 96 Rt. 008 / Rw. 08',
            'phone' => '081210066123',
            'password' => Hash::make('rt8'),
            'role' => 'rt',
            'rt'=>8,
        ]);
        
        \App\Models\User::firstOrCreate([
            'email' => "posyandu1@warga08.test",
        ],[
            'name' => 'Posyandu 1',
            'password' => Hash::make('posyandu123'),
            'role' => 'posyandu',
        ]);

        if(app()->environment('local')){

            \App\Models\User::factory()->count(10)->create([
                'role' => 'warga',
            ]);
        }
    }
}
