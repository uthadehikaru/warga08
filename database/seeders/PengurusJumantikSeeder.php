<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PengurusJumantikSeeder extends Seeder
{
    /**
     * Pengurus jumantik RW 08.
     * The coordinator has an empty RT and can open jumantik data for every RT.
     * A new account uses the password jumantik123. Running this again does not reset it.
     */
    public function run(): void
    {
        foreach ($this->officers() as $officer) {
            $user = User::firstOrNew(['email' => $officer['email']]);
            $user->name = $officer['name'];
            $user->phone = $officer['phone'];
            $user->rt = $officer['rt'];
            $user->role = 'jumantik';

            if (! $user->exists) {
                $user->password = Hash::make('jumantik123');
                $user->address = 'RW 08';
            }

            $user->save();
        }
    }

    /**
     * @return array<int, array{name: string, email: string, phone: string, rt: int|null}>
     */
    private function officers(): array
    {
        return [
            ['name' => 'Indah Astrida', 'email' => 'indahastrida11@gmail.com', 'phone' => '089531636293', 'rt' => null],
            ['name' => 'Lindawati', 'email' => 'athalinda19@mail.com', 'phone' => '085894019757', 'rt' => 4],
            ['name' => 'Diana Tjatja', 'email' => 'dianatjatja@gmail.com', 'phone' => '083896559182', 'rt' => 5],
            ['name' => 'Hasanah', 'email' => 'hasanah.hanah77@gmail.com', 'phone' => '087876723459', 'rt' => 2],
            ['name' => 'Yunani', 'email' => 'yunaniyunani1978@gmail.com', 'phone' => '085100659012', 'rt' => 4],
            ['name' => 'Muzdalipah', 'email' => 'ipahmuzdalipah97@gmail.com', 'phone' => '085814193046', 'rt' => 1],
            ['name' => 'Rina Herlina', 'email' => 'cahayarizkydina@gmail.com', 'phone' => '087783028964', 'rt' => 6],
            ['name' => 'Harumyati', 'email' => 'harumyati0406@gmail.com', 'phone' => '085697663087', 'rt' => 8],
            ['name' => 'Nur Amaliyah', 'email' => 'nuramaliyah2504@gmail.com', 'phone' => '089521350613', 'rt' => 5],
            ['name' => 'Edeh Wahidah', 'email' => 'edehwahidah77@gmail.com', 'phone' => '083876081139', 'rt' => 7],
            ['name' => 'Siti Fatimah', 'email' => 'sitif3037@gmail.com', 'phone' => '085756757366', 'rt' => 3],
        ];
    }
}
