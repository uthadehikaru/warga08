<div>
    <div class="w-full text-center py-4">
        <h1 class="font-bold text-lg">Form Pengajuan</h1>
        <ul class="steps my-4">
            <li class="step {{ $step>=1?'step-primary':'' }}"><span class="px-4">Data Warga</span></li>
            <li class="step {{ $step>=2?'step-primary':'' }}">Konfirmasi</li>
        </ul>
        <x-alert />
    </div>
<form class="grid grid-col-1 gap-2 px-2" wire:submit="submit">
    @if($step==1)
    <label class="form-control">
        <div class="label">
            <span class="label-text">RT</span>
        </div>
        <select class="select select-bordered w-full" wire:model.live="request.rt" required>
            <option>Pilih RT</option>
            @foreach($rt as $row)
            <option value="{{ $row->rt }}">RT. {{ $row->rt }} - {{ $row->name }}</option>
            @endforeach
        </select>
    </label>
    <label class="form-control">
        <div class="label">
            <span class="label-text">Email</span>
        </div>
        <input type="email" name="email" placeholder="Masukkan Email" wire:model="request.email" class="input input-bordered w-full" required />
    </label>
    <label class="form-control">
        <div class="label">
            <span class="label-text">NIK</span>
        </div>
        <input type="text" name="nik" placeholder="Masukkan NIK" wire:model="request.nik" class="input input-bordered w-full" required />
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
        <input type="text" name="name" placeholder="Nama Lengkap" wire:model="request.name" class="input input-bordered w-full" required />
    </label>
        <label class="form-control">
        <div class="label">
            <span class="label-text">Jenis Kelamin</span>
        </div>
        <div class="flex gap-2">
        <input type="radio" name="gender" wire:model="gender" value="p" class="radio" checked="checked" /> Pria
        <input type="radio" name="gender" wire:model="gender" value="w" class="radio" /> Wanita
    </div>
    </label>
    <label class="form-control">
        <div class="label">
            <span class="label-text">Telp</span>
        </div>
        <input type="text" name="phone" placeholder="No Telp" wire:model="request.phone" class="input input-bordered w-full" required />
    </label>
    <label class="form-control">
        <div class="label">
            <span class="label-text">Tempat, Tanggal Lahir</span>
        </div>
        <div class="flex gap-2">
            <input type="text" name="birth_place" placeholder="Tempat Lahir" wire:model="request.birth_place" class="input input-bordered w-full" required />
            <input type="date" placeholder="Tanggal Lahir" wire:model="request.birth_date" class="input input-bordered w-full" required />
        </div>    
    </label>
    <label class="form-control">
        <div class="label">
            <span class="label-text">Pekerjaan</span>
        </div>
        <input type="text" placeholder="Pekerjaan" wire:model="request.work" class="input input-bordered w-full" required />
    </label>
    <label class="form-control">
        <div class="label">
            <span class="label-text">Agama</span>
        </div>
        <select class="select select-bordered w-full" wire:model.live="request.religion" required>
        <option disabled selected>Pilih Agama</option>
        @foreach($religions as $religion)
        <option value="{{ $religion }}">{{ $religion }}</option>
        @endforeach
        </select>
    </label>
    <label class="form-control">
        <div class="label">
            <span class="label-text">Alamat</span>
        </div>
        <textarea wire:model="request.address" name="address" class="textarea textarea-bordered h-24" placeholder="masukkan alamat jalan dan no rumah. tidak perlu rt, rw dan lainnya"></textarea>
    </label>
    <label class="form-control">
        <div class="label">
            <span class="label-text">Keperluan</span>
        </div>
        <textarea wire:model="request.description" name="description" class="textarea textarea-bordered h-24" placeholder="masukkan keterangan"></textarea>
    </label>
    <x-alert />
    <button type="button" wire:click="next" class="btn btn-outline btn-primary">Lanjut</button>
    @else
    <h3>Konfirmasi Pengajuan Surat Pengantar</h3>
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
            <td width="5%" class="align-top">Jenis Kelamin</td>
            <td>: @lang('gender.'.$request['gender'])</td>
        </tr>
        <tr>
            <td width="5%" class="align-top">TTL</td>
            <td>: {{ $request['birth_place'] }}, {{ $request['birth_date'] }}</td>
        </tr>
        <tr>
            <td width="5%" class="align-top">Email</td>
            <td>: {{ $request['email'] }}</td>
        </tr>
        <tr>
            <td width="5%" class="align-top">Telp</td>
            <td>: {{ $request['phone'] }}</td>
        </tr>
        <tr>
            <td width="5%" class="align-top">Alamat</td>
            <td>: {{ $request['address'] }} {{ $request['rt'] }}</td>
        </tr>
        <tr>
            <td width="5%" class="align-top">Agama</td>
            <td>: {{ $request['religion'] }}</td>
        </tr>
        <tr>
            <td width="5%" class="align-top">Pekerjaan</td>
            <td>: {{ $request['work'] }}</td>
        </tr>
        <tr>
            <td width="5%" class="align-top">Keperluan</td>
            <td>: {{ $request['description'] }}</td>
        </tr>
    </table>
    <button type="submit" class="btn btn-outline btn-primary">Kirim Pengajuan
        <div wire:loading>
        <span class="loading loading-spinner loading-xs"></span>
        </div>
    </button>
    <button type="button" wire:click="back" class="btn btn-outline btn-warning">Kembali</button>
    @endif
</form>
</div>