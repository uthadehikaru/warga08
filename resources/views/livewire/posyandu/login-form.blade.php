<div class="min-h-screen flex flex-col justify-center items-center px-6 sm:px-8">
    <div class="fixed inset-0 z-0">
        <img src="{{ asset('images/login2.jpg') }}" class="w-full h-full object-cover object-center" alt="Background" />
    </div>
    <div class="relative z-10 bg-white rounded-3xl w-full max-w-md mx-auto p-6 shadow-lg">
        <section class="text-gray-600 body-font">
            <div class="container mx-auto">
                <div class="flex flex-col text-center w-full mb-4">
                    <a href="{{ route('posyandu.dashboard') }}" class="flex justify-center items-center gap-2">
                        <img src="{{ asset('rw08 small.png') }}" class="w-8 h-8" alt="Logo" />
                        <h1 class="sm:text-3xl text-xl font-medium title-font text-[#2d4724]">RW 08 Kelapa Dua</h1>
                    </a>
                    @if(session()->has('error'))
                    <p class="p-2 text-error">{{ session('error') }}</p>
                    @endif
                    @error('error')
                    <p class="p-2 text-error">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mx-auto">
                    <form class="flex flex-col flex-wrap -m-2" wire:submit="submit">
                        <div class="p-2 w-full input-wrapper">
                            <div class="relative">
                                <label for="username" class="leading-7 text-sm text-gray-800">ID Pengguna</label>
                                <div class="relative">
                                    <input type="text" id="username" name="username" wire:model="username"
                                        class="w-full rounded border border-gray-300 p-2 text-gray-800 pr-10"
                                        autocomplete="username">
                                    <div class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="p-2 w-full input-wrapper">
                            <div class="relative">
                                <label for="password" class="leading-7 text-sm text-gray-800">Password</label>
                                <div class="relative">
                                    <input type="{{ $showPassword ? 'text' : 'password' }}" id="password" name="password" wire:model="password"
                                        class="w-full rounded border border-gray-300 p-2 text-gray-800"
                                        autocomplete="current-password">
                                    <button type="button" wire:click="togglePassword" class="absolute right-2 top-1/2 -translate-y-1/2">
                                        @if($showPassword)
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                                            </svg>
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        @endif
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="p-2 w-full mb-4">
                            <button class="btn bg-[#2d4724] text-white w-full">Masuk</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>
