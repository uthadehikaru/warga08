<?php

namespace Database\Seeders;

use App\Models\Jumantik;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class JumantikSeeder extends Seeder
{
    /**
     * Jumantik samples around the RT secretariat address from UserSeeder.
     * Coordinates are the OpenStreetMap position of that street in Kelapa Dua.
     * A coordinate entered manually is left as-is.
     */
    public function run(): void
    {
        if (! app()->environment(['local', 'testing'])) {
            return;
        }

        $this->seedRtCoordinates();
        $this->seedPlaceholderPhoto();
        $this->seedReports();
    }

    private function seedRtCoordinates(): void
    {
        foreach ($this->rtCoordinates() as $rt => $coordinate) {
            $user = User::rt()->where('rt', $rt)->first();
            if (! $user) {
                continue;
            }

            $placeholder = $this->sameCoordinate($user->latitude, $this->previousCoordinates()[$rt][0] ?? null)
                && $this->sameCoordinate($user->longitude, $this->previousCoordinates()[$rt][1] ?? null);

            if ($coordinate === null) {
                if ($placeholder) {
                    $user->update(['latitude' => null, 'longitude' => null]);
                }

                continue;
            }

            if ($user->latitude === null || $user->longitude === null || $placeholder) {
                $user->update([
                    'latitude' => $coordinate[0],
                    'longitude' => $coordinate[1],
                ]);
            }
        }
    }

    private function seedPlaceholderPhoto(): void
    {
        if (Storage::disk('public')->exists('jumantik/sample.jpg') || ! function_exists('imagejpeg')) {
            return;
        }

        $image = imagecreatetruecolor(8, 8);
        ob_start();
        imagejpeg($image, null, 80);
        imagedestroy($image);
        Storage::disk('public')->put('jumantik/sample.jpg', ob_get_clean());
    }

    private function seedReports(): void
    {
        Jumantik::whereIn('name', [
            'Contoh Lokasi Sendiri',
            'Contoh Lokasi Default RT',
            'Contoh RT 2',
            'Contoh RT 2 Default',
            'Contoh RT 3',
            'Contoh RT 4 Default',
            'Contoh RT 5',
            'Contoh RT 8 Default',
        ])->delete();

        $coordinates = $this->rtCoordinates();
        $streets = [
            1 => 'Jl. Raya Kelapa Dua',
            2 => 'Jl. H. Rausin',
            3 => 'Jl. Raya Kelapa Dua',
            4 => 'Jl. Haji Kelik Gang Lada',
            5 => 'Jl. H. Rausin Gang Kayu Manis II',
            6 => 'Komplek DPR RI',
            7 => 'Jl. H. Arisan',
            8 => 'Jl. H. Usman',
        ];
        $names = [
            'Siti Aminah',
            'Budi Santoso',
            'Dewi Lestari',
            'Agus Wijaya',
            'Rina Kartika',
            'Hendra Saputra',
            'Maya Putri',
            'Joko Susilo',
            'Fitri Handayani',
            'Rudi Hartono',
        ];

        foreach (User::rt()->orderBy('rt')->get() as $user) {
            $rt = (int) $user->rt;
            if (! array_key_exists($rt, $coordinates) || ! isset($streets[$rt])) {
                continue;
            }

            $coordinate = $coordinates[$rt];

            foreach ($names as $index => $name) {
                $angle = (2 * M_PI * $index) / count($names);
                $radius = 0.00045;
                $address = $streets[$rt].' No. '.($index + 1);
                $latitude = $coordinate === null ? null : round($coordinate[0] + cos($angle) * $radius, 7);
                $longitude = $coordinate === null ? null : round($coordinate[1] + sin($angle) * $radius, 7);

                $report = Jumantik::firstOrCreate(
                    ['name' => $name.' RT '.$rt, 'rt' => $rt],
                    [
                        'phone' => sprintf('0812%02d%06d', $rt, $index + 1),
                        'address' => $address,
                        'has_jentik' => $index % 2 === 0,
                        'latitude' => $latitude,
                        'longitude' => $longitude,
                        'photo' => 'jumantik/sample.jpg',
                        'created_at' => now()->subDays(count($names) - $index),
                    ],
                );

                if (! $report->wasRecentlyCreated) {
                    $report->update([
                        'address' => $address,
                        'latitude' => $latitude,
                        'longitude' => $longitude,
                    ]);
                }
            }
        }
    }

    private function sameCoordinate(mixed $stored, ?float $expected): bool
    {
        if ($stored === null || $expected === null) {
            return false;
        }

        return number_format((float) $stored, 7, '.', '') === number_format($expected, 7, '.', '');
    }

    /**
     * Street position in Kelapa Dua, Kebon Jeruk from OpenStreetMap.
     * House numbers are not mapped, so each point is the street in RW 08.
     * RT 1 and RT 3 are both on Jalan Kelapa Dua Raya and are spaced along it.
     * RT 7, Jl. H. Arisan, is not on OpenStreetMap.
     *
     * @return array<int, array{0: float, 1: float}|null>
     */
    private function rtCoordinates(): array
    {
        return [
            1 => [-6.2069385, 106.7692954],
            2 => [-6.2075305, 106.7667149],
            3 => [-6.2062000, 106.7693200],
            4 => [-6.2080002, 106.7658358],
            5 => [-6.2066803, 106.7657461],
            6 => [-6.2060715, 106.7687038],
            7 => null,
            8 => [-6.2053522, 106.7669217],
        ];
    }

    /**
     * Earlier approximate points, replaced when they are still stored.
     *
     * @return array<int, array{0: float, 1: float}>
     */
    private function previousCoordinates(): array
    {
        return [
            1 => [-6.1890500, 106.7661200],
            2 => [-6.1898200, 106.7672400],
            3 => [-6.1906100, 106.7683600],
            4 => [-6.1914300, 106.7694800],
            5 => [-6.1922100, 106.7667800],
            6 => [-6.1929800, 106.7679100],
            7 => [-6.1901400, 106.7702200],
            8 => [-6.1918600, 106.7708400],
        ];
    }
}
