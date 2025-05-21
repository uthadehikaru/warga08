<div>
    <div class="container mx-auto px-4 py-8">
        <nav class="flex mb-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('posyandu.dashboard') }}" class="inline-flex items-center text-sm font-medium text-blue-700 hover:text-blue-600">
                        <svg class="w-3 h-3 mr-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z"/>
                        </svg>
                        Dashboard
                    </a>
                </li>
            </ol>
        </nav>
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-xl font-bold">Data Warga</h1>
            <div class="flex items-center gap-2">
                <div wire:loading>
                    <div class="loading loading-spinner" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
                <a href="{{ route('posyandu.teens.form') }}" class="btn btn-sm btn-primary p-1">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                </a>
            </div>
        </div>
        <div class="mb-4 flex items-center gap-2 justify-between">
            <input type="text" wire:model.live.debounce.500ms="search" placeholder="Cari Nama / NIK" class="w-5/6 p-2 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            @if($search)
                <button wire:click="clearSearch" class="btn btn-sm btn-error p-1">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            @else
                <button class="btn btn-sm btn-info p-1">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                </button>
            @endif
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-2 mb-4">
            @foreach($teens as $teen)
                <div class="bg-white rounded-lg shadow-md p-2">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-md font-semibold text-gray-800 flex items-center gap-2">
                        @if($teen->gender == 'w')
                            <img src="{{ asset('images/female.gif') }}" class="w-6 h-6">
                        @else
                            <img src="{{ asset('images/male.gif') }}" class="w-6 h-6">
                        @endif
                        {{ $teen->name }}</h3>
                        <span class="px-3 py-1 text-sm rounded-full {{ $teen->gender == 'p' ? 'bg-blue-100 text-blue-800' : 'bg-pink-100 text-pink-800' }}">
                        {{ $teen->age }} tahun
                        </span>
                    </div>
                    <div class="text-gray-600">
                        <p class="mb-1 grid grid-cols-1 gap-2">
                            <span class="flex items-center gap-2"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
</svg>
RT. {{ $teen->rt }}</span>
                            <span class="flex items-center gap-2"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z" />
</svg>
 {{ $teen->nik }}</span>
                        </p>
                    </div>
                    <div class="flex items-center justify-start gap-2 mt-2">
                        <a href="{{ route('posyandu.teens.form', $teen->nik) }}" class="btn btn-sm btn-primary px-2">
                            periksa
                        </a>
                        <a href="{{ route('posyandu.teens.records', $teen->nik) }}" class="btn btn-sm btn-warning px-2">
                            riwayat
                        </a>
                        <span class="text-xs text-gray-500 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
  <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
</svg>
 {{ $teen->updated_at->format('d/m/y h:i') }}
                        </span>
                    </div>
                </div>
            @endforeach
        </div>
        {{ $teens->links() }}
    </div>
</div>
