<div>
    <div class="w-full text-center py-4">
        <h1 class="font-bold text-lg">Form Pendatang</h1>
        <ul class="steps my-4">
            <li class="step {{ $step>=1?'step-primary':'' }}"><span class="px-4">Data Pendatang</span></li>
            <li class="step {{ $step>=2?'step-primary':'' }}">Dokumen Pendukung</li>
            <li class="step {{ $step>=3?'step-primary':'' }}">Konfirmasi</li>
        </ul>
        <x-alert />
    </div>
    <form class="grid grid-col-1 gap-2 px-2" wire:submit="submit">
        @if($step==1)
            <label class="form-control">
                <div class="label">
                    <span class="label-text">RT</span>
                </div>
                <select class="select select-bordered w-full" wire:model="request.rt" required>
                    <option value="">Pilih RT</option>
                    @foreach($rt as $row)
                    <option value="{{ $row->rt }}">RT. {{ $row->rt }} - {{ $row->name }}</option>
                    @endforeach
                </select>
            </label>
            <label class="form-control">
                <div class="label">
                    <span class="label-text">NIK</span>
                </div>
                <input type="text" name="nik" placeholder="Masukkan NIK" wire:model="request.nik" class="input input-bordered w-full placeholder-gray-500" required />
                @error('nik')
                <div class="label">
                    <span class="label-text-alt text-danger">{{ $message }}</span>
                </div>
                @enderror
            </label>
            <label class="form-control">
                <div class="label">
                    <span class="label-text">Nama</span>
                </div>
                <input type="text" name="name" placeholder="Nama Lengkap" wire:model="request.name" class="input input-bordered w-full placeholder-gray-500" required />
            </label>
            <label class="form-control">
                <div class="label">
                    <span class="label-text">Telp</span>
                </div>
                <input type="text" name="phone" placeholder="No Telp" wire:model="request.phone" class="input input-bordered w-full placeholder-gray-500" required />
            </label>
            <label class="form-control">
                <div class="label">
                    <span class="label-text">Alamat Sebelumnya</span>
                </div>
                <textarea wire:model="request.old_address" name="old_address" class="textarea textarea-bordered h-24 placeholder-gray-500" placeholder="masukkan alamat lengkap tempat tinggal sebelumnya"></textarea>
            </label>
            <label class="form-control">
                <div class="label">
                    <span class="label-text">Nama Pemilik Rumah</span>
                </div>
                <input type="text" name="home_owner" placeholder="Nama Lengkap" wire:model="request.home_owner" class="input input-bordered w-full placeholder-gray-500" required />
            </label>
            <label class="form-control">
                <div class="label">
                    <span class="label-text">Alamat Kontrakan/Kostan</span>
                </div>
                <textarea wire:model="request.home_address" name="home_address" class="textarea textarea-bordered h-24 placeholder-gray-500" placeholder="masukkan alamat rumah yang ditempati saat ini"></textarea>
            </label>
            <label class="form-control">
                <div class="label">
                    <span class="label-text">Status Pernikahan</span>
                </div>
                <select class="select select-bordered w-full" wire:model="request.is_married">
                    <option value="tidak">Belum menikah</option>
                    <option value="sudah">Sudah menikah</option>
                </select>
            </label>
            <button type="button" wire:click="next" class="btn btn-outline btn-primary mb-4">Lanjut</button>
        @elseif($step==2)
            @if($request['is_married']=='tidak')
                <label class="form-control">
                    <div class="label">
                        <span class="label-text">Foto KTP</span>
                    </div>
                    <input type="file" accept="image/*" class="input input-bordered w-full" wire:model="ktp" />
                </label>
                <div wire:loading><x-loading /></div>
                @if ($ktp) 
                    <img src="{{ $ktp->temporaryUrl() }}" width="300px">
                @endif
            @endif
            <label class="form-control">
                <div class="label">
                    <span class="label-text">Foto KK</span>
                </div>
                <input type="file" accept="image/*" class="input input-bordered w-full" wire:model="kk" />
            </label>
            <div wire:loading><x-loading /></div>
            @if ($kk) 
                <img src="{{ $kk->temporaryUrl() }}" width="300px">
            @endif
            @if($request['is_married']=='sudah')
                <label class="form-control">
                    <div class="label">
                        <span class="label-text">Foto Buku Nikah</span>
                    </div>
                    <input type="file" accept="image/*" class="input input-bordered w-full" wire:model="bukunikah" />
                </label>
                <div wire:loading><x-loading /></div>
                @if ($bukunikah) 
                    <img src="{{ $bukunikah->temporaryUrl() }}" width="300px">
                @endif
            @endif
            <button type="button" wire:click="previous" class="btn btn-outline btn-warning mb-2">Sebelumnya</button>
            <button type="button" wire:click="next" class="btn btn-outline btn-primary mb-4">Lanjut</button>
        @else
            <h3>Konfirmasi Data Pendatang</h3>
            <table>
                <tr>
                    <td width="5%" class="align-top">NIK</td>
                    <td>: {{ $request['nik'] }}</td>
                </tr>
                <tr>
                    <td width="5%" class="align-top">Nama</td>
                    <td>: {{ $request['name'] }}</td>
                </tr>
                <tr>
                    <td width="5%" class="align-top">Telp</td>
                    <td>: {{ $request['phone'] }}</td>
                </tr>
                <tr>
                    <td width="5%" class="align-top">Alamat Sebelumnya</td>
                    <td>: {{ $request['old_address'] }}</td>
                </tr>
                <tr>
                    <td width="5%" class="align-top">Nama Pemilik Rumah</td>
                    <td>: {{ $request['home_owner'] }}</td>
                </tr>
                <tr>
                    <td width="5%" class="align-top">Alamat Kontrakan/Kostan</td>
                    <td>: {{ $request['home_address'] }}</td>
                </tr>
                <tr>
                    <td width="5%" class="align-top">Status Pernikahan</td>
                    <td>: {{ $request['is_married']?'Sudah':'Belum' }} menikah</td>
                </tr>
                @if($ktp)
                <tr>
                    <td width="5%" class="align-top">Foto KTP</td>
                    <td>: <img src="{{ $ktp->temporaryUrl() }}" width="300px" /></td>
                </tr>
                @endif
                @if($kk)
                <tr>
                    <td width="5%" class="align-top">Foto KK</td>
                    <td>: <img src="{{ $kk->temporaryUrl() }}" width="300px" /></td>
                </tr>
                @endif
                @if($bukunikah)
                <tr>
                    <td width="5%" class="align-top">Foto Buku Nikah</td>
                    <td>: <img src="{{ $bukunikah->temporaryUrl() }}" width="300px" /></td>
                </tr>
                @endif
            </table>
            <button type="submit" class="btn btn-outline btn-primary">Kirim Data
                <div wire:loading>
                <span class="loading loading-spinner loading-xs"></span>
                </div>
            </button>
            <button type="button" wire:click="previous" class="btn btn-outline btn-warning">Kembali</button>
        @endif
        <x-alert />
    </form>
</div>
