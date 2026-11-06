@extends('layouts.admin')
@section('content')
@php
    $editing = $report->exists;
    $selectedJentik = old('has_jentik', $editing ? ($report->has_jentik ? 'ya' : 'tidak') : null);
@endphp
<form method="post" action="{{ $editing ? route('pengurus.jumantik.update', $report) : route('pengurus.jumantik.store') }}" enctype="multipart/form-data" class="p-4">
    @csrf
    @if($editing)
    <input type="hidden" name="_method" value="put" />
    @endif
    <h1 class="font-bold text-lg">{{ $editing ? 'Ubah' : 'Input' }} Data Jumantik</h1>
    @unless($editing)
    @if($rts->isNotEmpty())
    <p class="text-sm mt-1">Pilih RT untuk laporan ini. Data dicatat sebagai input pengurus.</p>
    @else
    <p class="text-sm mt-1">RT. {{ $report->rt }}. Data ini dicatat sebagai input pengurus.</p>
    @endif
    @endunless
    <x-alert />
    <label class="form-control w-full max-w-xs">
        <div class="label">
            <span class="label-text">Nama</span>
        </div>
        <input type="text" placeholder="nama warga" name="name"
        value="{{ old('name', $report->name) }}" class="input input-bordered w-full max-w-xs" required />
    </label>
    <label class="form-control w-full max-w-xs">
        <div class="label">
            <span class="label-text">No. Telepon</span>
        </div>
        <input type="text" placeholder="masukkan telp" name="phone"
        value="{{ old('phone', $report->phone) }}" class="input input-bordered w-full max-w-xs" required />
    </label>
    <label class="form-control w-full max-w-xs">
        <div class="label">
            <span class="label-text">Alamat</span>
        </div>
        <textarea class="textarea textarea-bordered h-24" name="address" required
        placeholder="masukkan alamat">{{ old('address', $report->address) }}</textarea>
    </label>
    @if($rts->isNotEmpty())
    <label class="form-control w-full max-w-xs">
        <div class="label">
            <span class="label-text">RT</span>
        </div>
        <select name="rt" class="select select-bordered w-full max-w-xs" required>
            @foreach ($rts as $rt)
            <option value="{{ $rt->rt }}" @selected((string) old('rt', $report->rt) === (string) $rt->rt)>RT. {{ $rt->rt }} - {{ $rt->name }}</option>
            @endforeach
        </select>
    </label>
    @elseif($editing)
    <p class="mt-3 text-sm">RT. {{ $report->rt }}</p>
    @endif
    <div class="form-control w-full max-w-xs">
        <div class="label">
            <span class="label-text">Apakah ditemukan jentik?</span>
        </div>
        <div class="flex gap-4">
            <label class="label cursor-pointer gap-2">
                <input type="radio" name="has_jentik" value="ya" class="radio" @checked($selectedJentik === 'ya') required />
                <span class="label-text">Ya</span>
            </label>
            <label class="label cursor-pointer gap-2">
                <input type="radio" name="has_jentik" value="tidak" class="radio" @checked($selectedJentik === 'tidak') />
                <span class="label-text">Tidak</span>
            </label>
        </div>
    </div>
    <label class="form-control w-full max-w-xs">
        <div class="label">
            <span class="label-text">Foto</span>
        </div>
        <input type="file" name="photo" accept="image/*" class="file-input file-input-bordered w-full max-w-xs" @unless($editing) required @endunless />
        @if($editing)
        <div class="label">
            <span class="label-text-alt">Kosongkan jika foto tidak diubah.</span>
        </div>
        @endif
    </label>
    @if($editing && $report->photo)
    <img src="{{ Storage::disk('public')->url($report->photo) }}" alt="Foto saat ini" class="mt-2 w-full max-w-xs rounded border border-base-300" />
    @endif
    <label class="form-control w-full max-w-xs">
        <div class="label">
            <span class="label-text">Latitude</span>
        </div>
        <input type="text" inputmode="decimal" placeholder="-6.1890000" name="latitude"
        value="{{ old('latitude', $report->latitude) }}" class="input input-bordered w-full max-w-xs" />
    </label>
    <label class="form-control w-full max-w-xs">
        <div class="label">
            <span class="label-text">Longitude</span>
        </div>
        <input type="text" inputmode="decimal" placeholder="106.7660000" name="longitude"
        value="{{ old('longitude', $report->longitude) }}" class="input input-bordered w-full max-w-xs" />
    </label>
    <button type="button" class="btn btn-outline btn-sm mt-2" onclick="fillJumantikLocation(this)">Gunakan lokasi saat ini</button>
    <p id="jumantik-location-status" class="text-sm mt-1"></p>
    <button type="submit" class="btn btn-primary mt-2 text-sm">Simpan</button>
    <a href="{{ route('pengurus.jumantik.index') }}" class="ml-2 btn border border-warning text-warning mt-2 text-sm">Kembali</a>
</form>
<script>
    function fillJumantikLocation(button) {
        const status = document.getElementById('jumantik-location-status');
        if (!navigator.geolocation) {
            status.textContent = 'Peramban tidak mendukung lokasi.';
            return;
        }

        button.disabled = true;
        status.textContent = 'Meminta izin lokasi...';
        navigator.geolocation.getCurrentPosition(function (position) {
            document.querySelector('[name=latitude]').value = position.coords.latitude.toFixed(7);
            document.querySelector('[name=longitude]').value = position.coords.longitude.toFixed(7);
            status.textContent = 'Koordinat terisi dari lokasi saat ini.';
            button.disabled = false;
        }, function () {
            status.textContent = 'Lokasi tidak diizinkan. Isi latitude dan longitude secara manual, atau kosongkan.';
            button.disabled = false;
        }, { enableHighAccuracy: true, timeout: 15000, maximumAge: 0 });
    }
</script>
@endsection
