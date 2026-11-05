<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jumantik extends Model
{
    use HasFactory;

    protected $casts = [
        'rt' => 'integer',
        'has_jentik' => 'boolean',
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
    ];

    /**
     * Coordinate stored on the report, or the RT user's default coordinate.
     *
     * @return array{id: int, name: string, rt: int, address: string, phone: string, has_jentik: bool, created_at: string|null, latitude: float, longitude: float, source: string}|null
     */
    public function mapPoint(?User $rt = null): ?array
    {
        $latitude = $this->latitude;
        $longitude = $this->longitude;
        $source = 'laporan';

        if ($latitude === null || $longitude === null) {
            $rt ??= User::rt()->where('rt', $this->rt)->first();

            if ($rt === null || $rt->latitude === null || $rt->longitude === null) {
                return null;
            }

            $latitude = $rt->latitude;
            $longitude = $rt->longitude;
            $source = 'rt';
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'rt' => $this->rt,
            'address' => $this->address,
            'phone' => $this->phone,
            'has_jentik' => (bool) $this->has_jentik,
            'created_at' => $this->created_at?->format('d M Y H:i'),
            'latitude' => (float) $latitude,
            'longitude' => (float) $longitude,
            'source' => $source,
        ];
    }
}
