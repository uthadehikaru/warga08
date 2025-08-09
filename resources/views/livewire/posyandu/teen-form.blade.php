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
            </ol>
        </nav>
        <h1 class="text-xl font-bold text-primary">1. Registrasi dan Verifikasi</h1>
        @if(session()->has('success'))
            <div class="alert alert-sm alert-success p-1 text-sm my-2">
                {{ session('success') }}
            </div>
        @endif
        @if(!$form)
        <form wire:submit="searchTeen" class="w-full max-w-lg mt-2">
            <div class="relative">
                <input type="text" wire:model="search" placeholder="Cari Nama/NIK" class="w-full pl-4 pr-12 py-2 border-2 border-gray-500 bg-gray-100 backdrop-blur-sm rounded-full focus:outline-none focus:border-blue-500 text-gray-700 placeholder-gray-700">
                <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 p-2 text-primary hover:text-blue-200 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </button>
            </div>
            <button type="submit" class="btn btn-sm btn-primary mt-2">Cari</button>
            <button type="button" wire:click="register" class="btn btn-sm btn-warning mt-2">Daftar Baru</button>
        </form>
        
        @foreach($teens as $teen)
            <div class="mt-2">
                <button wire:click="selectTeen('{{ preg_replace('/[^0-9]/', '', $teen->nik) }}')" class="w-full text-primary hover:text-blue-200 p-4 flex justify-between items-center gap-2">
                @if($teen->gender == 'p')
                    <img src="{{ asset('images/male.gif') }}" class="w-6 h-6">
                @else
                    <img src="{{ asset('images/female.gif') }}" class="w-6 h-6">
                @endif
                <span class="text-sm text-gray-500">{{ $teen->name }} <span class="badge badge-sm badge-primary">{{ $teen->age }} tahun</span><br/> <x-nik :nik="$teen->nik" /></span>
            <span class="btn btn-sm btn-primary">periksa</span></button>
            </div>
            @endforeach
        @else
        <h1 class="text-xl font-bold text-primary mt-2">Data Warga</h1>
        <form wire:submit="save" class="bg-white rounded-lg shadow-md p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div>
                    <label class="block text-sm font-medium text-gray-700">Tanggal Periksa</label>
                    <input id="check_date" type="date" wire:model="check_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    @error('check_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">RT</label>
                    <select id="rt" wire:model="rt" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Pilih RT</option>
                        @foreach(range(1, 8) as $rt)
                            <option value="{{ $rt }}">{{ $rt }}</option>
                        @endforeach
                    </select>
                    @error('rt') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">NIK</label>
                    <input id="nik" type="text" wire:model="nik" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    @error('nik') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                    <input id="name" type="text" wire:model="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">No telp</label>
                    <input id="phone" type="number" wire:model="phone" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    @error('phone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Nama Ayah</label>
                    <input id="father_name" type="text" wire:model="father_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    @error('father_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Nama Ibu</label>
                    <input id="mother_name" type="text" wire:model="mother_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    @error('mother_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Tempat Lahir</label>
                    <input id="birth_place" type="text" wire:model="birth_place" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    @error('birth_place') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                    <input id="birth_date" type="date" wire:model="birth_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    @error('birth_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Kelamin</label>
                    <div class="flex justify-start gap-2 items-center">
                        <div class="flex items-center">
                            <input type="radio" id="gender_p" name="gender" value="p" wire:model="gender" class="border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <label for="gender_p" class="ml-2 text-sm text-gray-700">Laki-laki</label>
                        </div>
                        <div class="flex items-center">
                            <input type="radio" id="gender_w" name="gender" value="w" wire:model="gender" class="border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <label for="gender_w" class="ml-2 text-sm text-gray-700">Perempuan</label>
                        </div>
                    </div>
                    @error('gender') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Alamat</label>
                    <textarea id="address" wire:model="address" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                    @error('address') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Riwayat Penyakit Keluarga</label>
                    <p class="text-sm text-gray-500 mb-2">Pilih penyakit yang pernah dialami keluarga jika ada</p>
                    <div class="space-y-2">
                        @foreach($diseases as $key => $disease)
                        <div class="flex items-center">
                            <input id="family_disease_{{ $key }}" type="checkbox" wire:model="family_disease.{{ $key }}" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <label class="ml-2 text-sm text-gray-700" for="family_disease_{{ $key }}">{{ $disease }}</label>
                        </div>
                        @endforeach
                    </div>
                    @error('family_disease') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Riwayat Penyakit Sendiri</label>
                    <p class="text-sm text-gray-500 mb-2">Pilih penyakit yang pernah dialami jika ada</p>
                    <div class="space-y-2">
                        @foreach($diseases as $key => $disease)
                        <div class="flex items-center">
                            <input id="personal_disease_{{ $key }}" type="checkbox" wire:model="personal_disease.{{ $key }}" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <label class="ml-2 text-sm text-gray-700" for="personal_disease_{{ $key }}">{{ $disease }}</label>
                        </div>
                        @endforeach
                    </div>
                    @error('personal_disease') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                
                
            </div>

            @if($errors->any())
                <div class="mt-6">
                    <div class="alert alert-warning">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
            


            <div class="mt-6">
                <button type="submit" class="btn btn-sm btn-primary">
                    <div wire:loading wire:target="save">
                        Memproses <div class="loading loading-spinner loading-sm" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                    <div wire:loading.remove wire:target="save">
                        Simpan Data
                    </div>
                </button>
                <button type="button" wire:click="cancel" class="btn btn-sm btn-warning mt-2">Batal</button>
            </div>
        </form>
        @endif
    </div>
</div>
