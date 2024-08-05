<div>
<form class="grid grid-col-1 gap-2 px-2" wire:submit="submit">
    <h1 class="font-bold text-lg">Form Pengajuan</h1>
    <select class="select select-bordered w-full" wire:model.live="request.rt">
    <option disabled selected>Pilih RT</option>
    @foreach($rt as $row)
    <option value="{{ $row->rt }}">RT. {{ $row->rt }} - {{ $row->name }}</option>
    @endforeach
    </select>
    <input type="text" placeholder="Masukkan NIK" wire:model="request.nik" class="input input-bordered w-full max-w-xs" />
    <input type="text" placeholder="Nama Lengkap" wire:model="request.name" class="input input-bordered w-full max-w-xs" />
    <input type="text" placeholder="No Telp" wire:model="request.phone" class="input input-bordered w-full max-w-xs" />
    <input type="email" placeholder="Email" wire:model="request.email" class="input input-bordered w-full max-w-xs" />
    <label class="form-control">
    <div class="label">
        <span class="label-text">Alamat</span>
    </div>
    <textarea wire:model="request.address" class="textarea textarea-bordered h-24" placeholder="masukkan alamat"></textarea>
    </label>
    <label class="form-control">
    <div class="label">
        <span class="label-text">Maksud/Tujuan</span>
    </div>
    <textarea wire:model="request.description" class="textarea textarea-bordered h-24" placeholder="masukkan keterangan"></textarea>
    </label>
    <button type="submit" class="btn btn-outline btn-primary">Kirim Pengajuan</button>
</form>
</div>