<div>
    <section class="text-gray-600 body-font relative">
        <div class="container px-5 py-5 mx-auto">
            <div class="flex flex-col text-center w-full mb-12">
                <h1 class="sm:text-3xl text-2xl font-medium title-font text-gray-200">Masuk</h1>
                @error('error')
                <p class="p-2 text-error">{{ $message }}</p>
                @enderror
            </div>
            <div class="lg:w-1/2 md:w-2/3 mx-auto">
                <form class="flex flex-col flex-wrap -m-2" wire:submit="submit">
                    <div class="p-2 w-full">
                        <div class="relative">
                            <label for="email" class="leading-7 text-sm text-gray-200">Email</label>
                            <input type="email" id="email" name="email" wire:model="email"
                                class="w-full rounded border border-gray-300 p-2 text-white">
                        </div>
                    </div>
                    <div class="p-2 w-full">
                        <div class="relative">
                            <label for="password" class="leading-7 text-sm text-gray-200">Password</label>
                            <input type="password" id="password" name="password" wire:model="password"
                                class="w-full rounded border border-gray-300 p-2 text-white">
                        </div>
                    </div>
                    <div class="p-2 w-full">
                        <button class="btn btn-primary w-full">Masuk</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
