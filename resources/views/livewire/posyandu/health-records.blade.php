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
                <li>
                    <div class="flex items-center">
                        <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                        </svg>
                        <a href="{{ route('posyandu.teens.index') }}" class="ml-1 text-sm font-medium text-blue-700 hover:text-blue-600 md:ml-2">Data Remaja</a>
                    </div>
                </li>
            </ol>
        </nav>
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-xl font-bold">{{ $warga->name }}</h1>
            <div class="flex items-center gap-2">
                <a href="{{ route('posyandu.teens.index') }}" class="btn btn-sm btn-warning p-1">
                    kembali
                </a>
            </div>
        </div>
        <div class="grid grid-cols-2 gap-1 mb-2">
            <p>RT : {{ $warga->rt }}</p>
            <p>NIK : {{ $warga->nik }}</p>
            <p>Ayah : {{ $warga->healthRecord->father_name }}</p>
            <p>Ibu : {{ $warga->healthRecord->mother_name }}</p>
            <p>Riwayat Penyakit Keluarga : {{ implode(', ', $warga->healthRecord->family_diseases) }}</p>
            <p>Riwayat Penyakit Pribadi : {{ implode(', ', $warga->healthRecord->personal_diseases) }}</p>
        </div>
        <hr />
        <div class="flex justify-between items-center my-4">
            <h1 class="text-xl font-bold">Riwayat Kesehatan</h1>
            <div class="flex items-center gap-2">
                <a href="{{ route('posyandu.teens.records.form', ['nik' => $warga->nik]) }}" class="btn btn-sm btn-primary p-1">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                </a>
            </div>
        </div>
        @if(session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-2 mb-4">
            @forelse($healthHistories as $healthHistory)
            <div tabindex="0" class="collapse bg-base-100 border-base-300 border">
                <div class="collapse-title font-semibold">{{ $healthHistory->check_date->format('d M Y') }}</div>
                <div class="collapse-content text-sm flex flex-col gap-2">
                    <p class="mb-1">
                        <span class="font-medium">Tinggi:</span> {{ $healthHistory->height }} cm
                    </p>
                    <p>
                        <span class="font-medium">Berat:</span> {{ $healthHistory->weight }} kg
                    </p>
                    <p>
                        <span class="font-medium">IMT:</span> {{ $healthHistory->imt }}
                    </p>
                    <p>
                        <span class="font-medium">Lingkar Perut:</span> {{ $healthHistory->lingkar_perut }} cm
                    </p>
                    <p>
                        <span class="font-medium">Sistol/Diastol:</span> {{ $healthHistory->sistol }}/{{ $healthHistory->diastol }}
                    </p>
                    <p>
                        <span class="font-medium">Tekanan Darah:</span> {{ $healthHistory->tekanan_darah }}
                    </p>
                    <p>
                        <span class="font-medium">Gula Darah:</span> {{ $healthHistory->gula_darah }}
                    </p>
                    <p>
                        <span class="font-medium">Kadar Hb:</span> {{ $healthHistory->kadar_hb }} mg/dL
                    </p>
                    @if($warga->gender == 'w')
                    <p>
                        <span class="font-medium">Kadar Hb:</span> {{ $healthHistory->kadar_hb }} g/dL
                    </p>
                    <p>
                        <span class="font-medium">Anemia:</span> {{ $healthHistory->anemia? 'Ya' : 'Tidak' }}
                    </p>
                    @endif
                    <hr />
                    <h3 class="font-bold mt-2">Skrining TBC</h3>
                    <p>
                        <span class="font-medium">Batuk terus menerus:</span> {{ $healthHistory->batuk? 'Ya' : 'Tidak' }}
                    </p>
                    <p>
                        <span class="font-medium">Demam lebih dari 2 pekan:</span> {{ $healthHistory->demam? 'Ya' : 'Tidak' }}
                    </p>
                    <p>
                        <span class="font-medium">BB tidak naik/turun dalam 2 bulan berturut-turut:</span> {{ $healthHistory->bb_stagnan? 'Ya' : 'Tidak' }}
                    </p>
                    <p>
                        <span class="font-medium">Kontak Erat dengan pasien TB:</span> {{ $healthHistory->kontak_tb? 'Ya' : 'Tidak' }}
                    </p>
                    <hr />
                    <h3 class="font-bold mt-2">Skrining Masalah Kesehatan</h3>
                    <p>
                        <span class="font-medium">Masalah di rumah:</span> {{ $healthHistory->masalah_di_rumah? 'Ya' : 'Tidak' }}
                    </p>
                    <p>
                        <span class="font-medium">Masalah dalam pendidikan/pekerjaan:</span> {{ $healthHistory->masalah_instansi? 'Ya' : 'Tidak' }}
                    </p>
                    <p>
                        <span class="font-medium">Masalah dengan aktivitas:</span> {{ $healthHistory->masalah_aktivitas? 'Ya' : 'Tidak' }}
                    </p>
                    <p>
                        <span class="font-medium">Masalah dengan aktivitas fisik:</span> {{ $healthHistory->masalah_aktivitas? 'Ya' : 'Tidak' }}
                    </p>
                    <p>
                        <span class="font-medium">Masalah dengan obat obatan:</span> {{ $healthHistory->masalah_obat? 'Ya' : 'Tidak' }}
                    </p>
                    <p>
                        <span class="font-medium">Masalah dengan seksualitas:</span> {{ $healthHistory->masalah_seksual? 'Ya' : 'Tidak' }}
                    </p>
                    <p>
                        <span class="font-medium">Masalah dengan keamanan:</span> {{ $healthHistory->masalah_keamanan? 'Ya' : 'Tidak' }}
                    </p>
                    <p>
                        <span class="font-medium">Memiliki keinginan bunuh diri:</span> {{ $healthHistory->masalah_depresi? 'Ya' : 'Tidak' }}
                    </p>
                    <p>
                        <span class="font-medium">Masalah dengan kebersihan:</span> {{ $healthHistory->masalah_bersih? 'Ya' : 'Tidak' }}
                    </p>
                    <p>
                        <span class="font-medium">Rujuk ke PUSTU/Puskesmas:</span> {{ $healthHistory->rujukan? 'Ya' : 'Tidak' }}
                    </p>
                    <p>
                        <span class="font-medium">Edukasi:</span> {{ $healthHistory->edukasi }}
                    </p>

                </div>
            </div>
            @empty
                <div class="bg-white rounded-lg shadow-md p-2">
                    <p class="text-gray-600">Belum ada riwayat kesehatan</p>
                </div>
            @endforelse
        </div>
        {{ $healthHistories->links() }}
    </div>
</div>
