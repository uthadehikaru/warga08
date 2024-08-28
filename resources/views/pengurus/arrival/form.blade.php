@extends('layouts.admin')
@section('content')
<div class="p-2">
    <h1 class="font-bold text-xl py-2">Ubah Pengajuan</h1>
    <x-alert />
    <form class="grid grid-col-1 gap-2 px-2" method="post" action="{{ route('pengurus.request.update', $request->id) }}">
        @csrf
        <input type="hidden" name="_method" value="put" />
        <label class="form-control">
            <div class="label">
                <span class="label-text">Nomor Surat</span>
            </div>
            <input type="text" name="document_no" placeholder="Masukkan no surat jika ada" value="{{ $request?->document_no }}" class="input input-bordered w-full placeholder-gray-500" />
        </label>
        <label class="form-control">
            <div class="label">
                <span class="label-text">Email</span>
            </div>
            <input type="email" name="email" placeholder="Masukkan Email" value="{{ $request?->email }}" class="input input-bordered w-full placeholder-gray-500" required />
        </label>
        <label class="form-control">
            <div class="label">
                <span class="label-text">NIK</span>
            </div>
            <input type="text" name="nik" placeholder="Masukkan NIK" value="{{ $request?->nik }}" class="input input-bordered w-full placeholder-gray-500" required />
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
            <input type="text" name="name" placeholder="Nama Lengkap" value="{{ $request?->name }}" class="input input-bordered w-full placeholder-gray-500" required />
        </label>
            <label class="form-control">
            <div class="label">
                <span class="label-text">Jenis Kelamin</span>
            </div>
            <div class="flex gap-2">
            <input type="radio" name="gender" value="p" class="radio" @checked($request->gender=='p') /> Pria
            <input type="radio" name="gender" value="w" class="radio" @checked($request->gender=='w') /> Wanita
        </div>
        </label>
        <label class="form-control">
            <div class="label">
                <span class="label-text">Telp</span>
            </div>
            <input type="text" name="phone" placeholder="No Telp" value="{{ $request?->phone }}" class="input input-bordered w-full placeholder-gray-500" required />
        </label>
        <label class="form-control">
            <div class="label">
                <span class="label-text">Tempat Lahir</span>
            </div>
                <input type="text" name="birth_place" name="birth_place" placeholder="Tempat Lahir" value="{{ $request?->birth_place }}" class="input input-bordered placeholder-gray-500" required />

        </label>
        <label class="form-control">
            <div class="label">
                <span class="label-text">Tanggal Lahir</span>
            </div>
                <input type="date" placeholder="Tanggal Lahir" name="birth_date" class="input input-bordered" value="{{ $request?->birth_date->format('Y-m-d') }}" required />
            
        </label>
        <label class="form-control">
            <div class="label">
                <span class="label-text">Pekerjaan</span>
            </div>
            <input type="text" placeholder="Pekerjaan" name="work" class="input input-bordered w-full placeholder-gray-500" value="{{ $request?->work }}" required />
        </label>
        <label class="form-control">
            <div class="label">
                <span class="label-text">Agama</span>
            </div>
            <select class="select select-bordered w-full" name="religion" required>
            <option value="">Pilih Agama</option>
            @foreach($religions as $religion)
            <option value="{{ $religion }}" @selected($request->religion==$religion)>{{ $religion }}</option>
            @endforeach
            </select>
        </label>
        <label class="form-control">
            <div class="label">
                <span class="label-text">Alamat</span>
            </div>
            <textarea name="address" class="textarea textarea-bordered h-24 placeholder-gray-500" placeholder="masukkan alamat jalan dan no rumah. tidak perlu rt, rw dan lainnya"
            >{{ $request?->address }}</textarea>
        </label>
        <label class="form-control">
            <div class="label">
                <span class="label-text">Keperluan</span>
            </div>
            <textarea name="description" class="textarea textarea-bordered h-24 placeholder-gray-500" placeholder="masukkan maksud/tujuan yang diinginkan"
            >{{ $request?->description }}</textarea>
        </label>
        <x-alert />
        <button type="submit" class="btn btn-outline btn-primary mb-4">Simpan</button>
    </form>
</div>
@endsection
