<div>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-xl font-bold text-primary">Pendaftaran</h1>
        <form wire:submit="save" class="bg-white rounded-lg shadow-md p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
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
                            <label class="ml-2 text-sm text-gray-700">{{ $disease }}</label>
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
                            <label class="ml-2 text-sm text-gray-700">{{ $disease }}</label>
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
                <a href="{{ route('posyandu.teens.index') }}" class="btn btn-sm btn-warning">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
