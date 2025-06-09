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
            <li>
                <div class="flex items-center">
                    <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <a href="{{ route('posyandu.dashboard', ['menu' => 'posyandu']) }}" class="ml-1 text-sm font-medium text-blue-700 hover:text-blue-600 md:ml-2">Posyandu</a>
                </div>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <a href="{{ route('posyandu.pos', ['type' => $type, 'step' => $step]) }}" class="ml-1 text-sm font-medium text-blue-700 hover:text-blue-600 md:ml-2">Pos {{ $step }}</a>
                </div>
            </li>
        </ol>
    </nav>
    <h1 class="text-xl text-center text-primary font-bold my-2">{{ $step }}. {{ $pos_name }}</h1>
    <div class="flex justify-center my-2">
        <a href="#" wire:click="refresh" class="btn btn-sm btn-primary">refresh
            <div wire:loading wire:target="refresh">
                <x-loading />
            </div>
        </a>
    </div>
    <div class="flex justify-center">
        <input type="date" wire:model.live.debounce.500ms="check_date" class="w-full p-2 border border-gray-300 rounded-full">
    </div>
    @if(session()->has('message'))
    <div class="alert alert-success my-2 text-sm">
        {{ session('message') }}
    </div>
    @endif
    <div class="grid grid-cols-1 gap-2">
        @forelse($healthHistory as $history)
        <div class="mt-2">
            <div class="w-full text-primary hover:text-blue-200 p-4 flex justify-between items-center gap-2">
                @if($history->healthRecord->user->gender == 'p')
                    <img src="{{ asset('images/male.gif') }}" class="w-6 h-6">
                @else
                    <img src="{{ asset('images/female.gif') }}" class="w-6 h-6">
                @endif
                <span class="text-sm text-gray-500">{{ $history->healthRecord->user->name }}<br/> <x-nik :nik="$history->healthRecord->user->nik" /></span>
                <div class="flex gap-2">
                    @if($step == 6)
                        <a href="https://wa.me/{{ $history->healthRecord->user->phone }}?text={{ $history->summary }}" {{ $history->healthRecord->user->phone?'':'disabled' }} target="_blank" class="btn btn-sm btn-primary">whatsapp</a>
                        <button wire:click="check('{{ $history->healthRecord->user->nik }}', {{ $history->id }})" class="btn btn-sm btn-info">lihat</button>
                        
                    @else
                        <button wire:click="check('{{ $history->healthRecord->user->nik }}', {{ $history->id }})" class="btn btn-sm btn-primary">pilih</button>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="text-center p-4">
            <p>Belum ada data</p>
        </div>
        @endforelse
        @if($healthHistory)
        {{ $healthHistory->links() }}
        @endif
</div>
