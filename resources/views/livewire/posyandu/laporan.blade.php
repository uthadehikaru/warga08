<div>
    <div class="container mx-auto px-4 py-8">
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
                <li class="inline-flex items-center">
                    <a href="{{ route('posyandu.dashboard', ['menu' => 'laporan']) }}" class="inline-flex items-center text-sm font-medium text-blue-700 hover:text-blue-600">
                        <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                        </svg>
                        Laporan
                    </a>
                </li>
            </ol>
        </nav>
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-xl font-bold">Laporan {{ $type }}</h1>
        </div>
        <form wire:submit="search" class="flex gap-4 items-end">
            <div>
                <label for="start_date" class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
                <input type="date" wire:model="startDate" id="start_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
            </div>
            <div>
                <label for="end_date" class="block text-sm font-medium text-gray-700">Tanggal Selesai</label>
                <input type="date" wire:model="endDate" id="end_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
            </div>
            <button type="submit" class="btn btn-sm btn-primary p-1">
                Cari
            </button>
        </form>
        <div class="grid grid-cols-1 gap-2 my-4">
        @foreach($data as $key => $row)
        <div tabindex="0" class="collapse bg-base-100 border-base-300 border">
            <input type="checkbox" class="peer" />
            <div class="collapse-title font-semibold flex justify-between items-center">
                {{ $key }}
            </div>
            <div class="collapse-content text-sm flex flex-col gap-2" onclick="event.stopPropagation()">
                <h3 class="font-semibold mt-2">Usia 6-14 tahun</h3>
                <p>Target : {{ $row['target_6_14'] }}</p>
                <p>Hadir : {{ $row['present_6_14'] }}</p>
                <p>Tidak Hadir : {{ $row['not_present_6_14'] }}</p>
                <h3 class="font-semibold mt-2">Usia 15-18 tahun</h3>
                <p>Target : {{ $row['target_15_18'] }}</p>
                <p>Hadir : {{ $row['present_15_18'] }}</p>
                <p>Tidak Hadir : {{ $row['not_present_15_18'] }}</p>
                <h3 class="font-semibold mt-2">IMT</h3>
                <p>Sangat Kurus : {{ $row['imt_sangat_kurus'] }}</p>
                <p>Kurus : {{ $row['imt_kurus'] }}</p>
                <p>Normal : {{ $row['imt_normal'] }}</p>
                <p>Gemuk : {{ $row['imt_gemuk'] }}</p>
                <p>Obesitas : {{ $row['imt_obesitas'] }}</p>
                <h3 class="font-semibold mt-2">Lingkar Perut</h3>
                <p>{{ $row['lingkar_perut'] }}</p>
                <h3 class="font-semibold mt-2">Tekanan Darah</h3>
                <p>Rendah : {{ $row['tekanan_darah_rendah'] }}</p>
                <p>Tinggi : {{ $row['tekanan_darah_tinggi'] }}</p>
                <p>Normal : {{ $row['tekanan_darah_normal'] }}</p>
                <h3 class="font-semibold mt-2">Gula Darah</h3>
                <p>Rendah : {{ $row['gula_darah_rendah'] }}</p>
                <p>Tinggi : {{ $row['gula_darah_tinggi'] }}</p>
                <p>Normal : {{ $row['gula_darah_normal'] }}</p>
                <h3 class="font-semibold mt-2">Anemia</h3>
                <p>Ya : {{ $row['anemia'] }}</p>
                <p>Tidak : {{ $row['non_anemia'] }}</p>
                <h3 class="font-semibold mt-2">Gejala TBC</h3>
                <p>{{ $row['gejala_tbc'] }}</p>
                <h3 class="font-semibold mt-2">Masalah Kesehatan</h3>
                <p>{{ $row['masalah_kesehatan'] }}</p>
                <h3 class="font-semibold mt-2">Edukasi</h3>
                <p>{{ $row['edukasi'] }}</p>
                <h3 class="font-semibold mt-2">Rujukan</h3>
                <p>{{ $row['rujukan'] }}</p>
            </div>    
        </div>
        @endforeach
        </div>
    </div>
</div>
