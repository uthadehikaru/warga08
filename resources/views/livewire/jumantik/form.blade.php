<div>
    <div class="w-full text-center py-4">
        <h1 class="font-bold text-lg">Laporan Mandiri Jumantik</h1>
        <ul class="steps my-4">
            <li class="step {{ $step>=1?'step-primary':'' }}"><span class="px-4">Data Laporan</span></li>
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
                <select class="select select-bordered w-full" wire:model="form.rt" required>
                    <option value="">Pilih RT</option>
                    @foreach($rt as $row)
                    <option value="{{ $row->rt }}">RT. {{ $row->rt }} - {{ $row->name }}</option>
                    @endforeach
                </select>
            </label>
            <label class="form-control">
                <div class="label">
                    <span class="label-text">Nama</span>
                </div>
                <input type="text" name="name" placeholder="Nama Lengkap" wire:model="form.name" class="input input-bordered w-full placeholder-gray-500" required />
                @error('form.name')
                <div class="label">
                    <span class="label-text-alt text-error">{{ $message }}</span>
                </div>
                @enderror
            </label>
            <label class="form-control">
                <div class="label">
                    <span class="label-text">No. Telepon</span>
                </div>
                <input type="text" name="phone" placeholder="No Telp" wire:model="form.phone" class="input input-bordered w-full placeholder-gray-500" required />
                @error('form.phone')
                <div class="label">
                    <span class="label-text-alt text-error">{{ $message }}</span>
                </div>
                @enderror
            </label>
            <label class="form-control">
                <div class="label">
                    <span class="label-text">Alamat</span>
                </div>
                <textarea wire:model="form.address" name="address" class="textarea textarea-bordered h-24 placeholder-gray-500" placeholder="Masukkan alamat lengkap" required></textarea>
                @error('form.address')
                <div class="label">
                    <span class="label-text-alt text-error">{{ $message }}</span>
                </div>
                @enderror
            </label>
            <label class="form-control">
                <div class="label">
                    <span class="label-text">Foto</span>
                </div>
                <input type="file" accept="image/*" class="input input-bordered w-full" wire:model="photo" />
                @error('photo')
                <div class="label">
                    <span class="label-text-alt text-error">{{ $message }}</span>
                </div>
                @enderror
            </label>
            <div wire:loading><x-loading /></div>
            @if ($photo)
                <img src="{{ $photo->temporaryUrl() }}" width="300px">
            @endif
            <button type="button" wire:click="next" class="btn btn-outline btn-primary mb-4">Lanjut</button>
        @else
            <h3>Konfirmasi Laporan Mandiri Jumantik</h3>
            <table>
                <tr>
                    <td width="5%" class="align-top">RT</td>
                    <td>: {{ $form['rt'] }}</td>
                </tr>
                <tr>
                    <td width="5%" class="align-top">Nama</td>
                    <td>: {{ $form['name'] }}</td>
                </tr>
                <tr>
                    <td width="5%" class="align-top">Telp</td>
                    <td>: {{ $form['phone'] }}</td>
                </tr>
                <tr>
                    <td width="5%" class="align-top">Alamat</td>
                    <td>: {{ $form['address'] }}</td>
                </tr>
                @if($photo)
                <tr>
                    <td width="5%" class="align-top">Foto</td>
                    <td>: <img src="{{ $photo->temporaryUrl() }}" width="300px" /></td>
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
