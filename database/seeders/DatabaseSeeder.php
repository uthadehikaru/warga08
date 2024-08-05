<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@warga08.test',
            'password' => Hash::make('admin100%'),
            'role' => 'admin',
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Bisri Ali',
            'email' => 'bisri.ali@warga08.test',
            'password' => Hash::make('rw123'),
            'role' => 'rw',
        ]);

        $rt = ['','Kurtubi','Ir. H. Jamaludin','Muhammad Fitrah udin','Abdullah Ali','Muhammad Irvan','H. Dody Syaiful Anwar','H. Uus Agustino','Drs. Deny Hardipriyatna'];
        foreach($rt as $i=>$name){
            if($i==0)
                continue;
            
            \App\Models\User::factory()->create([
                'name' => $name,
                'email' => "rt.$i@warga08.test",
                'password' => Hash::make('rt'.$i),
                'role' => 'rt',
                'rt'=>$i,
            ]);
        }
    }
}
