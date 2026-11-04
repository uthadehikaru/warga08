<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Street positions in Kelapa Dua, Kebon Jeruk from OpenStreetMap.
     * House numbers are not mapped. RT 7, Jl. H. Arisan, has no mapped street.
     *
     * @var array<int, array{0: string|null, 1: string|null}>
     */
    private array $coordinates = [
        1 => ['-6.2069385', '106.7692954'],
        2 => ['-6.2075305', '106.7667149'],
        3 => ['-6.2062000', '106.7693200'],
        4 => ['-6.2080002', '106.7658358'],
        5 => ['-6.2066803', '106.7657461'],
        6 => ['-6.2060715', '106.7687038'],
        7 => [null, null],
        8 => ['-6.2053522', '106.7669217'],
    ];

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        foreach ($this->coordinates as $rt => [$latitude, $longitude]) {
            DB::table('users')
                ->where('role', 'rt')
                ->where('rt', $rt)
                ->update([
                    'latitude' => $latitude,
                    'longitude' => $longitude,
                ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        foreach ($this->coordinates as $rt => [$latitude, $longitude]) {
            if ($latitude === null || $longitude === null) {
                continue;
            }

            DB::table('users')
                ->where('role', 'rt')
                ->where('rt', $rt)
                ->where('latitude', $latitude)
                ->where('longitude', $longitude)
                ->update([
                    'latitude' => null,
                    'longitude' => null,
                ]);
        }
    }
};
