<div>
    @if(!$menu)
    <div class="relative">
        <div class="absolute inset-0 flex items-center justify-center z-10">
            <form action="{{ route('posyandu.teens.index') }}" method="GET" class="w-3/4 max-w-lg">
                <div class="relative">
                    <input type="text" name="search" placeholder="Cari Nama/NIK" class="w-full pl-4 pr-12 py-2 border-2 border-white bg-white/30 backdrop-blur-sm rounded-full focus:outline-none focus:border-blue-500 text-white placeholder-white">
                    <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 p-2 text-white hover:text-blue-200 focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </button>
                </div>
            </form>
        </div>
        <img src="{{ asset('images/kelapa-dua.jpg') }}" class="w-full h-[200px] object-cover" />
    </div>
    @endif
    <div class="grid grid-cols-1 gap-1">
        @if($menu && !$type)
        <a wire:click="resetMenu()" href="#" class="items-center text-center bg-warning p-2">
            <p class="text-white text-sm">Dashboard</p>
        </a>
        <a wire:click="selectType('remaja')" href="#" class="items-center text-center bg-[#28C76F] p-2">
            <img src="{{ asset('images/remaja.png') }}" class="h-24 mx-auto">
            <p class="text-white text-sm">{{ $menu }} Remaja</p>
        </a>

        <a href="#" class="items-center text-center bg-[#28C76F] p-2">
            <img src="{{ asset('images/balita.png') }}" class="h-24 mx-auto">
            <p class="text-white text-sm">{{ $menu }} Balita</p>
        </a>
        
        <a href="#" class="items-center text-center bg-[#28C76F] p-2">
            <img src="{{ asset('images/ibu-hamil.png') }}" class="h-24 mx-auto">
            <p class="text-white text-sm">{{ $menu }} Ibu Hamil</p>
        </a>
        
        <a href="#" class="items-center text-center bg-[#28C76F] p-2">
            <img src="{{ asset('images/dewasa.png') }}" class="h-24 mx-auto">
            <p class="text-white text-sm">{{ $menu }} Dewasa</p>
        </a>
        
        <a href="#" class="items-center text-center bg-[#28C76F] p-2">
            <img src="{{ asset('images/lansia.png') }}" class="h-24 mx-auto">
            <p class="text-white text-sm">{{ $menu }} Lansia</p>
        </a>
        @elseif($menu && $type)
        <a wire:click="resetType()" href="#" class="items-center text-center bg-warning p-2">
            <p class="text-white text-sm">Kembali</p>
        </a>
        <a href="#" class="items-center text-center bg-gray-500 p-2">
            <img src="{{ asset('images/'.$type.'.png') }}" class="h-24 mx-auto">
            <p class="text-white text-sm">Posyandu {{ $type }}</p>
        </a>
        @foreach($steps as $step=>$value)
        <a wire:click="selectStep({{ $step }})" href="#" class="items-center text-center bg-[#28C76F] p-4 text-white">
            Pos {{ $step }}. {{ $value }}
        </a>
        @endforeach
        <a href="{{ route('posyandu.summary', $type) }}" class="items-center text-center bg-[#28C76F] p-4 text-white">
            Rekapitulasi
        </a>

        @else
        @auth
        <a wire:click="selectMenu('posyandu')" href="#" class="items-center text-center bg-[#28C76F] p-2">
            <img src="{{ asset('images/posyandu.png') }}" class="h-24 mx-auto">
            <p class="text-white text-sm">Posyandu</p>
        </a>
        @endauth
        @guest
        <a href="{{ route('posyandu.teens.index') }}" class="items-center text-center bg-[#28C76F] p-2">
            <img src="{{ asset('images/posyandu.png') }}" class="h-24 mx-auto">
            <p class="text-white text-sm">Posyandu</p>
        </a>
        @endguest
        <a href="#" class="items-center text-center bg-[#28C76F] p-2">
            <img src="{{ asset('images/kunjungan.png') }}" class="h-24 mx-auto">
            <p class="text-white text-sm">Kunjungan</p>
        </a>
        <a href="{{ route('posyandu.teens.index') }}" class="items-center text-center bg-[#28C76F] p-2">
            <img src="{{ asset('images/warga.png') }}" class="h-24 mx-auto">
            <p class="text-white text-sm">Warga</p>
        </a>
        <a wire:click="selectMenu('laporan')" href="#" class="items-center text-center bg-[#28C76F] p-2">
            <img src="{{ asset('images/laporan.png') }}" class="h-24 mx-auto">
            <p class="text-white text-sm">Laporan</p>
        </a>
        <a href="{{ config('app.url') }}" target="_blank" class="items-center text-center bg-[#28C76F] p-2">
            <img src="{{ asset('images/layanan.png') }}" class="h-24 mx-auto">
            <p class="text-white text-sm">Layanan</p>
        </a>

        <a href="https://media.rw08kelapadua.web.id/" target="_blank" class="items-center text-center bg-[#28C76F] p-2">
            <img src="{{ asset('images/media08.png') }}" class="h-24 mx-auto">
        </a>
        @endif
    </div>

</div>
