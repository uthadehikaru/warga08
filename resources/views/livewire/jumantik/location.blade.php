<div class="rounded-lg border border-base-300 p-3 text-left">
    <div class="font-semibold">Koordinat</div>
    <p x-show="locating" style="display: none">Meminta izin lokasi...</p>
    <p x-show="!locating && locationMessage" x-text="locationMessage" class="text-sm text-warning" style="display: none"></p>
    @if(filled($form['latitude']) && filled($form['longitude']))
        <p class="font-mono">{{ number_format((float) $form['latitude'], 7, '.', '') }}, {{ number_format((float) $form['longitude'], 7, '.', '') }}</p>
    @else
        <p class="text-sm" x-show="!locating && !locationMessage">Lokasi belum tersedia.</p>
    @endif
    @error('form.latitude')
        <p class="text-sm text-error">{{ $message }}</p>
    @enderror
    @error('form.longitude')
        <p class="text-sm text-error">{{ $message }}</p>
    @enderror
    <button type="button" class="btn btn-outline btn-sm mt-2" x-on:click="requestLocation()" x-bind:disabled="locating">Ambil lokasi</button>
</div>
