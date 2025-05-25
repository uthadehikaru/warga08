<?php

namespace Database\Seeders;

use App\Models\HealthHistory;
use App\Models\HealthRecord;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HealthHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if(app()->environment('local')){
            foreach(HealthRecord::all() as $record){
                if(rand(0, 1) == 0){
                    HealthHistory::factory()->create([
                        'health_record_id' => $record->id,
                        'check_date' => now(),
                        'type' => 'remaja',
                        'age' => $record->user->age,
                    ]);
                }

                if(rand(0, 1) == 0){
                    HealthHistory::factory()->create([
                        'health_record_id' => $record->id,
                        'check_date' => now()->addMonth(),
                        'type' => 'remaja',
                        'age' => $record->user->age,
                    ]);
                }
            }
        }
    }
}
