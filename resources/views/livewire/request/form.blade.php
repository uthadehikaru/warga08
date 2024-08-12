<div>
    <div class="w-full text-center py-4">
        
    <h1 class="font-bold text-lg">Form Pengajuan</h1>
    <ul class="steps my-4">
        <li class="step {{ $step>=1?'step-primary':'' }}">Data Warga</li>
        <li class="step {{ $step>=2?'step-primary':'' }}">Keperluan</li>
        <li class="step {{ $step>=3?'step-primary':'' }}">Konfirmasi</li>
    </ul>
    </div>
<form class="grid grid-col-1 gap-2 px-2" wire:submit="submit">
    @if($step==1)
    <select class="select select-bordered w-full" wire:model.live="request.rt">
    <option disabled selected>Pilih RT</option>
    @foreach($rt as $row)
    <option value="{{ $row->rt }}">RT. {{ $row->rt }} - {{ $row->name }}</option>
    @endforeach
    </select>
    <input type="email" placeholder="Masukkan Email" wire:model="request.email" class="input input-bordered w-full" />
    <input type="text" placeholder="Masukkan NIK" wire:model="request.nik" class="input input-bordered w-full" />
    <input type="text" placeholder="Nama Lengkap" wire:model="request.name" class="input input-bordered w-full" />
    <label class="form-control">
        <div class="label">
            <span class="label-text">Jenis Kelamin</span>
        </div>
        <div class="flex gap-2">
        <input type="radio" name="gender" wire:model="gender" value="p" class="radio" checked="checked" /> Pria
        <input type="radio" name="gender" wire:model="gender" value="w" class="radio" /> Wanita
    </div>
    </label>
    <input type="text" placeholder="No Telp" wire:model="request.phone" class="input input-bordered w-full" />
    <label class="form-control">
        <div class="label">
            <span class="label-text">Tempat, Tanggal Lahir</span>
        </div>
        <div class="flex gap-2">
            <input type="text" placeholder="Tempat Lahir" wire:model="request.birth_place" class="input input-bordered w-full" />
            <input type="date" placeholder="Tanggal Lahir" wire:model="request.birth_date" class="input input-bordered w-full" />
        </div>    
    </label>
    <input type="text" placeholder="Pekerjaan" wire:model="request.work" class="input input-bordered w-full" />
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
    <textarea wire:model="request.address" class="textarea textarea-bordered h-24" placeholder="masukkan alamat jalan dan no rumah. tidak perlu rt, rw dan lainnya"></textarea>
    </label>
    <button type="button" wire:click="next" class="btn btn-outline btn-primary">Selanjutnya</button>
    @elseif($step==2)
    <label class="form-control">
    <div class="label">
        <span class="label-text">Keperluan</span>
    </div>
    <textarea wire:model="request.description" class="textarea textarea-bordered h-24" placeholder="masukkan keterangan"></textarea>
    </label>
    <button type="button" wire:click="next" class="btn btn-outline btn-primary">Selanjutnya</button>
    @elseif($step==3)
    <h3>Konfirmasi Pengajuan Surat Pengantar</h3>
    <table>
        <tr>
            <td width="5%">NIK</td>
            <td>: {{ $request['nik'] }}</td>
        </tr>
        <tr>
            <td width="5%">Nama</td>
            <td>: {{ $request['name'] }}</td>
        </tr>
        <tr>
            <td width="5%">Jenis Kelamin</td>
            <td>: @lang('gender.'.$request['gender'])</td>
        </tr>
        <tr>
            <td width="5%">Tempat, Tanggal Lahir</td>
            <td>: {{ $request['birth_place'] }}, {{ $request['birth_date'] }}</td>
        </tr>
        <tr>
            <td width="5%">Email</td>
            <td>: {{ $request['email'] }}</td>
        </tr>
        <tr>
            <td width="5%">Telp</td>
            <td>: {{ $request['phone'] }}</td>
        </tr>
        <tr>
            <td width="5%">Alamat</td>
            <td>: {{ $request['address'] }} {{ $request['rt'] }}</td>
        </tr>
        <tr>
            <td width="5%">Agama</td>
            <td>: {{ $request['religion'] }}</td>
        </tr>
        <tr>
            <td width="5%">Pekerjaan</td>
            <td>: {{ $request['work'] }}</td>
        </tr>
        <tr>
            <td width="5%">Keperluan</td>
            <td>: {{ $request['description'] }}</td>
        </tr>
    </table>
    <button type="submit" class="btn btn-outline btn-primary">Kirim Pengajuan</button>
    @endif
</form>
</div>