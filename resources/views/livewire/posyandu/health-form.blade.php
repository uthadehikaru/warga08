<div class="p-6">
    <nav class="flex mb-4" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('posyandu.dashboard') }}" class="inline-flex items-center text-sm font-medium text-blue-700 hover:text-blue-600">
                    <svg class="w-3 h-3 mr-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z"/>
                    </svg>
                    Dashboard
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <a href="{{ route('posyandu.teens.index') }}" class="ml-1 text-sm font-medium text-blue-700 hover:text-blue-600 md:ml-2">Data Warga</a>
                </div>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <a href="{{ route('posyandu.teens.records', $warga->nik) }}" class="ml-1 text-sm font-medium text-blue-700 hover:text-blue-600 md:ml-2">{{ $warga->name }}</a>
                </div>
            </li>
        </ol>
    </nav>
    <h1 class="text-xl font-bold">Form Pemeriksaan Kesehatan</h1>
    <p>{{ $warga->name }}, @lang('gender.'.$warga->gender), usia {{ $warga->age}} Tahun</p>
    <form wire:submit="save" class="space-y-2">
        @if (session()->has('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('message') }}</span>
            </div>
        @endif

        <!-- Basic Information -->
        <div class="bg-white shadow-sm rounded-lg p-6">
            @if($step == 1)
            <h3 class="text-lg font-medium text-gray-900 my-4">Langkah 2</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Tinggi Badan (cm)</label>
                    <input type="number" wire:model.blur="height" placeholder="Masukkan tinggi badan" class="mt-1 block w-full rounded-md border border-gray-300 p-2 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('height') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Berat Badan (kg)</label>
                    <input type="number" wire:model.blur="weight" placeholder="Masukkan berat badan" class="mt-1 block w-full rounded-md border border-gray-300 p-2 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('weight') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                @if($warga->age >= 15)
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Lingkar Perut (cm)</label>
                        <input type="number" wire:model="lingkar_perut" placeholder="Masukkan lingkar perut" class="mt-1 block w-full rounded-md border border-gray-300 p-2 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('lingkar_perut') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Sistol</label>
                        <input type="number" wire:model.blur="sistol" placeholder="Masukkan nilai sistol" class="mt-1 block w-full rounded-md border border-gray-300 p-2 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('sistol') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Diastol</label>
                        <input type="number" wire:model.blur="diastol" placeholder="Masukkan nilai diastol" class="mt-1 block w-full rounded-md border border-gray-300 p-2 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('diastol') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tekanan Darah</label>
                        <input type="text" wire:model="tekanan_darah" placeholder="Tekanan darah akan terisi otomatis" readonly disabled class="mt-1 block w-full rounded-md border border-gray-300 p-2 bg-gray-100 shadow-sm">
                    </div>
                @endif
            </div>
            @elseif($step == 2)
            <h3 class="text-lg font-medium text-gray-900 my-4">Langkah 3</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">IMT</label>
                    <input type="text" wire:model="imt" placeholder="IMT akan terisi otomatis" readonly disabled class="mt-1 block w-full rounded-md border border-gray-300 p-2 bg-gray-100 shadow-sm">
                </div>
            </div>
            <hr />
            @elseif($step == 3)
            <h3 class="text-lg font-medium text-gray-900">Langkah 4</h3>
            @if($warga->age >= 15)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Gula Darah</label>
                    <div class="mt-2 space-y-2">
                        <div class="flex items-center">
                            <input type="radio" id="gula_darah_rendah" wire:model="gula_darah" value="Rendah" class="rounded-full border border-gray-300 p-2 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <label for="gula_darah_rendah" class="ml-2 block text-sm text-gray-900">Rendah</label>
                        </div>
                        <div class="flex items-center">
                            <input type="radio" id="gula_darah_normal" wire:model="gula_darah" value="Normal" class="rounded-full border border-gray-300 p-2 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <label for="gula_darah_normal" class="ml-2 block text-sm text-gray-900">Normal</label>
                        </div>
                        <div class="flex items-center">
                            <input type="radio" id="gula_darah_tinggi" wire:model="gula_darah" value="Tinggi" class="rounded-full border border-gray-300 p-2 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <label for="gula_darah_tinggi" class="ml-2 block text-sm text-gray-900">Tinggi</label>
                        </div>
                    </div>
                    @error('gula_darah') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                @if($warga->gender == 'w')
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Kadar HB</label>
                        <input type="number" wire:model.blur="kadar_hb" placeholder="Masukkan kadar HB" class="mt-1 block w-full rounded-md border border-gray-300 p-2 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('kadar_hb') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Anemia</label>
                        <div class="mt-2 gap-2 flex justify-around">
                            <div class="flex items-center">
                                <input type="radio" id="anemia_ya" wire:model="anemia" value="Ya" class="rounded-full border border-gray-300 p-2 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <label for="anemia_ya" class="ml-2 block text-sm text-gray-900">Ya</label>
                            </div>
                            <div class="flex items-center">
                                <input type="radio" id="anemia_tidak" wire:model="anemia" value="Tidak" class="rounded-full border border-gray-300 p-2 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <label for="anemia_tidak" class="ml-2 block text-sm text-gray-900">Tidak</label>
                            </div>
                        </div>
                        @error('anemia') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                @endif
            </div>
            @endif
        </div>

        <!-- Health Conditions -->
        <div class="bg-white shadow-sm rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Skrining TBC</h3>
            <p class="text-sm text-gray-500 mb-4">
                <span class="font-bold">jika ada 2 atau lebih indikator dibawah ini, maka perlu rujukan ke PUSTU/Puskesmas</span>.
            </p>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="flex items-center">
                    <input type="checkbox" wire:model.live="tbc.batuk" value="1" class="rounded border border-gray-300 p-2 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <label class="ml-2 block text-sm text-gray-900">Batuk terus menerus</label>
                </div>
                <div class="flex items-center">
                    <input type="checkbox" wire:model.live="tbc.demam" value="1" class="rounded border border-gray-300 p-2 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <label class="ml-2 block text-sm text-gray-900">Demam lebih dari 2 pekan</label>
                </div>
                <div class="flex items-center">
                    <input type="checkbox" wire:model.live="tbc.bb_stagnan" value="1" class="rounded border border-gray-300 p-2 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <label class="ml-2 block text-sm text-gray-900">BB tidak naik / tidak turun selama 2 bulan berturut-turut</label>
                </div>
                <div class="flex items-center">
                    <input type="checkbox" wire:model.live="tbc.kontak_tbc" value="1" class="rounded border border-gray-300 p-2 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <label class="ml-2 block text-sm text-gray-900">Kontak erat dengan pasien TBC</label>
                </div>
            </div>
        </div>

        <!-- Problem Indicators -->
        <div class="bg-white shadow-sm rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Indikator Masalah</h3>
            <p class="text-sm text-gray-500 mb-4">
                <span class="font-bold">jika ada 1 atau lebih indikator dibawah ini, maka perlu rujukan ke PUSTU/Puskesmas</span>.
            </p>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="flex items-center">
                    <input type="checkbox" wire:model.live="masalah.di_rumah" value="1" class="rounded border border-gray-300 p-2 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <label class="ml-2 block text-sm text-gray-900">memiliki masalah di dalam rumah (Home)</label>
                </div>
                <div class="flex items-center">
                    <input type="checkbox" wire:model.live="masalah.di_instansi" value="1" class="rounded border border-gray-300 p-2 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <label class="ml-2 block text-sm text-gray-900">memiliki masalah dengan pendidikan atau pekerjaan (Education / Employment)</label>
                </div>
                <div class="flex items-center">
                    <input type="checkbox" wire:model.live="masalah.pola_makan" value="1" class="rounded border border-gray-300 p-2 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <label class="ml-2 block text-sm text-gray-900">Memiliki masalah dengan pola makan (Eating)</label>
                </div>
                <div class="flex items-center">
                    <input type="checkbox" wire:model.live="masalah.aktivitas" value="1" class="rounded border border-gray-300 p-2 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <label class="ml-2 block text-sm text-gray-900">memiliki masalah dengan aktivitas (Activity)</label>
                </div>
                <div class="flex items-center">
                    <input type="checkbox" wire:model.live="masalah.obat" value="1" class="rounded border border-gray-300 p-2 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <label class="ml-2 block text-sm text-gray-900">memiliki masalah dengan obat-obatan (drugs)</label>
                </div>
                <div class="flex items-center">
                    <input type="checkbox" wire:model.live="masalah.seksual" value="1" class="rounded border border-gray-300 p-2 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <label class="ml-2 block text-sm text-gray-900">memiliki masalah dengan kesehatan seksual (Sexuality)</label>
                </div>
                <div class="flex items-center">
                    <input type="checkbox" wire:model.live="masalah.keamanan" value="1" class="rounded border border-gray-300 p-2 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <label class="ml-2 block text-sm text-gray-900">memiliki masalah dengan keamanan (Self Image)</label>
                </div>
                <div class="flex items-center">
                    <input type="checkbox" wire:model.live="masalah.depresi" value="1" class="rounded border border-gray-300 p-2 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <label class="ml-2 block text-sm text-gray-900">Memiliki keinginan bunuh diri / Depresi (Safety)</label>
                </div>
                <div class="flex items-center space-x-4">
                    <label class="block text-sm font-bold text-gray-900">Perlu Rujukan:</label>
                    <div class="flex items-center space-x-2">
                        <input type="radio" wire:model="rujuk" value="1" id="rujuk_ya" class="text-indigo-600 border border-gray-300 p-2 focus:ring-indigo-500">
                        <label for="rujuk_ya" class="text-sm text-gray-900">Ya</label>
                    </div>
                    <div class="flex items-center space-x-2">
                        <input type="radio" wire:model="rujuk" value="0" id="rujuk_tidak" class="text-indigo-600 border border-gray-300 p-2 focus:ring-indigo-500">
                        <label for="rujuk_tidak" class="text-sm text-gray-900">Tidak</label>
                    </div>
                </div>
            </div>
        </div>
        @else
        <!-- Additional Information -->
        <div class="bg-white shadow-sm rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Langkah 5</h3>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Edukasi</label>
                    <textarea wire:model="edukasi" rows="3" placeholder="Masukkan catatan edukasi" class="mt-1 block w-full rounded-md border border-gray-300 p-2 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                    @error('edukasi') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>
        @endif

        <div class="flex justify-start gap-2 mt-4">
            <button type="submit" class="btn btn-sm btn-primary">
                <div wire:loading.remove wire:target="save">
                    Simpan Data
                </div>
                <div wire:loading wire:target="save">
                    <span class="loading loading-spinner loading-md"></span>
                </div>
            </button>
            <a href="{{ route('posyandu.teens.records', $warga->nik) }}" class="btn btn-sm btn-warning">
                Batal
            </a>
        </div>
    </form>
</div>
