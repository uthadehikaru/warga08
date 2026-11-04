@extends('layouts.admin')
@section('content')
<form method="post" action="{{ route('pengurus.rt.update', $user->id) }}" class="p-4">
    @csrf
    <input type="hidden" name="_method" value="put" />
    <h1 class="font-bold text-lg">Data RT {{ $user->rt }}</h1>
    <x-alert />
    <label class="form-control w-full max-w-xs">
        <div class="label">
            <span class="label-text">Nama</span>
        </div>
        <input type="text" placeholder="nama RT" name="name" 
        value="{{ $user->name }}" class="input input-bordered w-full max-w-xs" required />
    </label>
    <label class="form-control w-full max-w-xs">
        <div class="label">
            <span class="label-text">Email</span>
        </div>
        <input type="email" placeholder="masukkan email" name="email" 
        value="{{ $user->email }}" class="input input-bordered w-full max-w-xs" required />
    </label>
    <label class="form-control w-full max-w-xs">
        <div class="label">
            <span class="label-text">Telp</span>
        </div>
        <input type="text" placeholder="masukkan telp" name="phone" 
        value="{{ $user->phone }}" class="input input-bordered w-full max-w-xs" required />
    </label>
    <label class="form-control w-full max-w-xs">
        <div class="label">
            <span class="label-text">Alamat Sekretariat</span>
        </div>
        <textarea class="textarea textarea-bordered h-24" name="address" required
        placeholder="masukkan nama jalan no tanpa rt dan rw">{{ $user->address }}</textarea>
    </label>
    @if($user->role === 'rt')
    <label class="form-control w-full max-w-xs">
        <div class="label">
            <span class="label-text">Latitude</span>
        </div>
        <input type="text" inputmode="decimal" placeholder="-6.1890000" name="latitude"
        value="{{ old('latitude', $user->latitude) }}" class="input input-bordered w-full max-w-xs" />
        @error('latitude')
        <div class="label">
            <span class="label-text-alt text-error">{{ $message }}</span>
        </div>
        @enderror
    </label>
    <label class="form-control w-full max-w-xs">
        <div class="label">
            <span class="label-text">Longitude</span>
        </div>
        <input type="text" inputmode="decimal" placeholder="106.7660000" name="longitude"
        value="{{ old('longitude', $user->longitude) }}" class="input input-bordered w-full max-w-xs" />
        @error('longitude')
        <div class="label">
            <span class="label-text-alt text-error">{{ $message }}</span>
        </div>
        @enderror
    </label>
    <p class="text-sm max-w-xs mt-1">Koordinat default RT. Laporan jumantik tanpa lokasi akan memakai titik ini di peta.</p>
    <button type="button" class="btn btn-outline btn-sm mt-2" onclick="fillRtLocation(this)">Gunakan lokasi saat ini</button>
    <p id="rt-location-status" class="text-sm mt-1"></p>
    <script>
        function fillRtLocation(button) {
            const status = document.getElementById('rt-location-status');
            if (!navigator.geolocation) {
                status.textContent = 'Peramban tidak mendukung lokasi.';
                return;
            }

            button.disabled = true;
            status.textContent = 'Meminta izin lokasi...';
            navigator.geolocation.getCurrentPosition(function (position) {
                document.querySelector('[name=latitude]').value = position.coords.latitude.toFixed(7);
                document.querySelector('[name=longitude]').value = position.coords.longitude.toFixed(7);
                status.textContent = 'Koordinat terisi dari lokasi saat ini. Simpan untuk memakai titik ini.';
                button.disabled = false;
            }, function () {
                status.textContent = 'Lokasi tidak diizinkan. Isi latitude dan longitude secara manual.';
                button.disabled = false;
            }, { enableHighAccuracy: true, timeout: 15000, maximumAge: 0 });
        }
    </script>
    @endif
    <button type="submit" class="btn btn-primary mt-2 text-sm">Simpan</button>
    <a href="{{ route('pengurus.rt.index') }}" class="ml-2 btn border border-warning text-warning mt-2 text-sm">Kembali</a>
</form>
@endsection
