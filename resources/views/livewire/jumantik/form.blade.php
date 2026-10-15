<div x-data="{ compressing: false }">
    @assets
    <script>
        window.compressJumantikPhoto = function (file) {
            const maxEdge = 1600;

            return createImageBitmap(file, { imageOrientation: 'from-image' }).then(function (bitmap) {
                return new Promise(function (resolve, reject) {
                    const scale = Math.min(maxEdge / bitmap.width, maxEdge / bitmap.height, 1);
                    const width = Math.max(1, Math.round(bitmap.width * scale));
                    const height = Math.max(1, Math.round(bitmap.height * scale));
                    const canvas = document.createElement('canvas');
                    canvas.width = width;
                    canvas.height = height;
                    canvas.getContext('2d').drawImage(bitmap, 0, 0, width, height);
                    bitmap.close();
                    canvas.toBlob(function (blob) {
                        if (!blob) {
                            reject(new Error('compress failed'));
                            return;
                        }
                        if (blob.size >= file.size && scale === 1 && file.type === 'image/jpeg') {
                            resolve(file);
                            return;
                        }
                        const name = file.name.replace(/\.[^.]+$/, '') + '.jpg';
                        resolve(new File([blob], name, { type: 'image/jpeg', lastModified: Date.now() }));
                    }, 'image/jpeg', 0.75);
                });
            });
        };

        window.uploadJumantikPhoto = function (input, wire) {
            const file = input.files && input.files[0];
            if (!file) {
                return Promise.resolve();
            }

            return window.compressJumantikPhoto(file)
                .catch(function () { return file; })
                .then(function (photo) {
                    return new Promise(function (resolve, reject) {
                        wire.upload('photo', photo, resolve, reject);
                    });
                })
                .finally(function () {
                    input.value = '';
                });
        };
    </script>
    @endassets
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
                    <span class="label-text">Apakah ditemukan jentik?</span>
                </div>
                <div class="flex gap-4">
                    <label class="label cursor-pointer gap-2">
                        <input type="radio" name="has_jentik" wire:model="form.has_jentik" value="ya" class="radio" />
                        <span class="label-text">Ya</span>
                    </label>
                    <label class="label cursor-pointer gap-2">
                        <input type="radio" name="has_jentik" wire:model="form.has_jentik" value="tidak" class="radio" />
                        <span class="label-text">Tidak</span>
                    </label>
                </div>
                @error('form.has_jentik')
                <div class="label">
                    <span class="label-text-alt text-error">{{ $message }}</span>
                </div>
                @enderror
            </label>
            <label class="form-control">
                <div class="label">
                    <span class="label-text">Foto</span>
                </div>
                <input
                    type="file"
                    accept="image/*"
                    class="input input-bordered w-full"
                    x-on:change="compressing = true; window.uploadJumantikPhoto($event.target, $wire).finally(() => compressing = false)"
                    x-bind:disabled="compressing"
                />
                <div class="label">
                    <span class="label-text-alt" x-show="compressing" style="display: none">Mengompres foto...</span>
                </div>
                @error('photo')
                <div class="label">
                    <span class="label-text-alt text-error">{{ $message }}</span>
                </div>
                @enderror
            </label>
            <div wire:loading wire:target="photo"><x-loading /></div>
            @if ($photo)
                <img src="{{ $photo->temporaryUrl() }}" width="300px">
            @endif
            <button type="button" wire:click="next" class="btn btn-outline btn-primary mb-4" x-bind:disabled="compressing" wire:loading.attr="disabled" wire:target="photo">Lanjut</button>
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
                <tr>
                    <td width="5%" class="align-top">Ditemukan jentik</td>
                    <td>: {{ $form['has_jentik'] == 'ya' ? 'Ya' : 'Tidak' }}</td>
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
