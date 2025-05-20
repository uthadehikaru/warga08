<div>
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
        <img src="{{ asset('images/kelapa-dua.jpg') }}" class="w-full" />
    </div>
    <div class="grid grid-cols-2 gap-1 p-4">
        <a href="{{ route('posyandu.teens.index') }}" class="items-center text-center">
            <img src="{{ asset('images/remaja.png') }}" class="w-full">
        </a>
        
        <a href="#" class="items-center text-center">
            <img src="{{ asset('images/balita.png') }}" class="w-full">
        </a>
        
        <a href="#" class="items-center text-center">
            <img src="{{ asset('images/ibu-hamil.png') }}" class="w-full">
        </a>
        
        <a href="#" class="items-center text-center">
            <img src="{{ asset('images/lansia.png') }}" class="w-full">
        </a>

        <a href="{{ config('app.url') }}" target="_blank" class="items-center text-center">
            <img src="{{ asset('images/layanan.png') }}" class="w-full">
        </a>

        <a href="https://media.rw08kelapadua.web.id/" target="_blank" class="items-center text-center">
            <img src="{{ asset('images/media08.png') }}" class="w-full">
        </a>
    </div>

</div>
