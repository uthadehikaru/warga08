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
                HealthHistory::factory()->count(10)->create([
                    'health_record_id' => $record->id,
                ]);
            }
        }
    }
}
