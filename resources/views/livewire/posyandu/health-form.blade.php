<div class="p-6">
    <h1 class="text-xl font-bold">Pemeriksaan Kesehatan</h1>
    <h2 class="text-lg">{{ $warga->name }}</h2>
    <p>@lang('gender.'.$warga->gender), usia {{ $warga->age}} Tahun</p>
    <form wire:submit="save" class="space-y-6">
        @if (session()->has('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('message') }}</span>
            </div>
        @endif

        <!-- Basic Information -->
        <div class="bg-white shadow-sm rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 my-4">Langkah 1</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Tanggal Pemeriksaan</label>
                    <input type="date" wire:model="check_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('check_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>
            <hr />
            <h3 class="text-lg font-medium text-gray-900 my-4">Langkah 2</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Tinggi Badan (cm)</label>
                    <input type="number" wire:model.blur="height" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('height') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Berat Badan (kg)</label>
                    <input type="number" wire:model.blur="weight" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('weight') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Lingkar Perut (cm)</label>
                    <input type="number" wire:model="lingkar_perut" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('lingkar_perut') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Sistol</label>
                    <input type="number" wire:model.blur="sistol" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('sistol') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Diastol</label>
                    <input type="number" wire:model.blur="diastol" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('diastol') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Tekanan Darah</label>
                    <input type="text" wire:model="tekanan_darah" readonly disabled class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm">
                </div>
            </div>
            
            <hr />
            <h3 class="text-lg font-medium text-gray-900 my-4">Langkah 3</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">IMT</label>
                    <input type="text" wire:model="imt" readonly disabled class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm">
                </div>
            </div>
            <hr />
            <h3 class="text-lg font-medium text-gray-900 my-4">Langkah 4</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Gula Darah</label>
                    <div class="mt-2 space-y-2">
                        <div class="flex items-center">
                            <input type="radio" id="gula_darah_rendah" wire:model="gula_darah" value="Rendah" class="rounded-full border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <label for="gula_darah_rendah" class="ml-2 block text-sm text-gray-900">Rendah</label>
                        </div>
                        <div class="flex items-center">
                            <input type="radio" id="gula_darah_normal" wire:model="gula_darah" value="Normal" class="rounded-full border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <label for="gula_darah_normal" class="ml-2 block text-sm text-gray-900">Normal</label>
                        </div>
                        <div class="flex items-center">
                            <input type="radio" id="gula_darah_tinggi" wire:model="gula_darah" value="Tinggi" class="rounded-full border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <label for="gula_darah_tinggi" class="ml-2 block text-sm text-gray-900">Tinggi</label>
                        </div>
                    </div>
                    @error('gula_darah') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                @if($warga->gender == 'w')
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Kadar HB</label>
                        <input type="number" wire:model.blur="kadar_hb" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('kadar_hb') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Anemia</label>
                        <div class="mt-2 gap-2 flex justify-around">
                            <div class="flex items-center">
                                <input type="radio" id="anemia_ya" wire:model="anemia" value="Ya" class="rounded-full border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <label for="anemia_ya" class="ml-2 block text-sm text-gray-900">Ya</label>
                            </div>
                            <div class="flex items-center">
                                <input type="radio" id="anemia_tidak" wire:model="anemia" value="Tidak" class="rounded-full border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <label for="anemia_tidak" class="ml-2 block text-sm text-gray-900">Tidak</label>
                            </div>
                        </div>
                        @error('anemia') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                @endif
            </div>
        </div>

        <!-- Health Conditions -->
        <div class="bg-white shadow-sm rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Skrining TBC</h3>
            <p class="text-sm text-gray-500 mb-4">
                <span class="font-bold">jika ada 2 atau lebih indikator dibawah ini, maka perlu rujukan ke PUSTU/Puskesmas</span>.
            </p>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="flex items-center">
                    <input type="checkbox" wire:model.live="tbc.batuk" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <label class="ml-2 block text-sm text-gray-900">Batuk terus menerus</label>
                </div>
                <div class="flex items-center">
                    <input type="checkbox" wire:model.live="tbc.demam" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <label class="ml-2 block text-sm text-gray-900">Demam lebih dari 2 pekan</label>
                </div>
                <div class="flex items-center">
                    <input type="checkbox" wire:model.live="tbc.bb_stagnan" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <label class="ml-2 block text-sm text-gray-900">BB tidak naik / tidak turun selama 2 bulan berturut-turut</label>
                </div>
                <div class="flex items-center">
                    <input type="checkbox" wire:model.live="tbc.kontak_tbc" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
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
                    <input type="checkbox" wire:model.live="masalah.di_rumah" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <label class="ml-2 block text-sm text-gray-900">memiliki masalah di dalam rumah (Home)</label>
                </div>
                <div class="flex items-center">
                    <input type="checkbox" wire:model.live="masalah.di_instansi" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <label class="ml-2 block text-sm text-gray-900">memiliki masalah dengan pendidikan atau pekerjaan (Education / Employment)</label>
                </div>
                <div class="flex items-center">
                    <input type="checkbox" wire:model.live="masalah.pola_makan" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <label class="ml-2 block text-sm text-gray-900">Memiliki masalah dengan pola makan (Eating)</label>
                </div>
                <div class="flex items-center">
                    <input type="checkbox" wire:model.live="masalah.aktivitas" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <label class="ml-2 block text-sm text-gray-900">memiliki masalah dengan aktivitas (Activity)</label>
                </div>
                <div class="flex items-center">
                    <input type="checkbox" wire:model.live="masalah.obat" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <label class="ml-2 block text-sm text-gray-900">memiliki masalah dengan obat-obatan (drugs)</label>
                </div>
                <div class="flex items-center">
                    <input type="checkbox" wire:model.live="masalah.seksual" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <label class="ml-2 block text-sm text-gray-900">memiliki masalah dengan kesehatan seksual (Sexuality)</label>
                </div>
                <div class="flex items-center">
                    <input type="checkbox" wire:model.live="masalah.keamanan" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <label class="ml-2 block text-sm text-gray-900">memiliki masalah dengan keamanan (Self Image)</label>
                </div>
                <div class="flex items-center">
                    <input type="checkbox" wire:model.live="masalah.depresi" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <label class="ml-2 block text-sm text-gray-900">Memiliki keinginan bunuh diri / Depresi (Safety)</label>
                </div>
                <div class="flex items-center space-x-4">
                    <label class="block text-sm font-bold text-gray-900">Perlu Rujukan:</label>
                    <div class="flex items-center space-x-2">
                        <input type="radio" wire:model="rujuk" value="1" id="rujuk_ya" class="text-indigo-600 border-gray-300 focus:ring-indigo-500">
                        <label for="rujuk_ya" class="text-sm text-gray-900">Ya</label>
                    </div>
                    <div class="flex items-center space-x-2">
                        <input type="radio" wire:model="rujuk" value="0" id="rujuk_tidak" class="text-indigo-600 border-gray-300 focus:ring-indigo-500">
                        <label for="rujuk_tidak" class="text-sm text-gray-900">Tidak</label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Information -->
        <div class="bg-white shadow-sm rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Langkah 5</h3>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Edukasi</label>
                    <textarea wire:model="edukasi" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                    @error('edukasi') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        <div class="flex justify-start gap-2">
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
