<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
            'email' => 'bisri.ali@warga08.test',
            'password' => Hash::make('rw8'),
            'role' => 'rw',
        ]);
            
        \App\Models\User::factory()->create([
            'name' => 'Kurtubi',
            'email' => "rt1@warga08.test",
            'password' => Hash::make('rt1'),
            'role' => 'rt',
            'rt'=>1,
        ]);
        
        \App\Models\User::factory()->create([
            'name' => 'Ir. H. Jamaludin',
            'email' => "rt2@warga08.test",
            'password' => Hash::make('rt2'),
            'role' => 'rt',
            'rt'=>2,
        ]);
        
        \App\Models\User::factory()->create([
            'name' => 'Muhammad Fitrah udin',
            'email' => "rt3@warga08.test",
            'password' => Hash::make('rt3'),
            'role' => 'rt',
            'rt'=>3,
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Abdullah Ali',
            'email' => "rt4@warga08.test",
            'password' => Hash::make('rt4'),
            'role' => 'rt',
            'rt'=>4,
            'address' => 'Jalan Haji Kelik Gang Lada No 180 telp 089676391532',
            'email' => 'alihajis@gmail.com',
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Muhammad Irvan',
            'email' => "rt5@warga08.test",
            'password' => Hash::make('rt5'),
            'role' => 'rt',
            'rt'=>5,
        ]);

        \App\Models\User::factory()->create([
            'name' => 'H. Dody Syaiful Anwar',
            'email' => "rt6@warga08.test",
            'password' => Hash::make('rt6'),
            'role' => 'rt',
            'rt'=>6,
            'address' => 'Komplek DPR RI No. 28 Rt. 006 / Rw 08',
            'phone' => '081318649427',
        ]);

        \App\Models\User::factory()->create([
            'name' => 'H. Uus Agustino',
            'email' => "rt7@warga08.test",
            'password' => Hash::make('rt7'),
            'role' => 'rt',
            'rt'=>7,
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Drs. Deny Hardipriyatna',
            'email' => "rt8@warga08.test",
            'password' => Hash::make('rt8'),
            'role' => 'rt',
            'rt'=>8,
            'address' => 'Jl. H. Usman No. 96 Rt. 008 / Rw. 08',
            'phone' => '081210066123',
        ]);
    }
}
