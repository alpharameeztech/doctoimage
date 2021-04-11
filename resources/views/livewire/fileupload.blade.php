<div>
{{--    <div class="flex w-full items-center justify-center bg-gray-900 pb-15">--}}
{{--        <label class="w-64 flex flex-col items-center px-4 py-6 bg-white text-blue rounded-lg shadow-lg tracking-wide uppercase border border-blue cursor-pointer hover:bg-blue hover:text-blue">--}}
{{--            <svg class="w-8 h-8" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">--}}
{{--                <path d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z" />--}}
{{--            </svg>--}}
{{--            <span class="mt-2 text-base leading-normal">Select a file</span>--}}
{{--            <input type='file' multiple class="hidden" />--}}
{{--        </label>--}}
{{--    </div>--}}

    @if (session()->has('success'))
        <div class="bg-gray-900 pb-10">

            <div class="max-w-6xl mx-auto container mx-auto">
                <div class="flex items-center bg-green-500 text-white text-sm font-bold px-4 py-3" role="alert">
                    <svg class="w-6 sm:w-5 h-6 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                         xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="ml-3">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    <form wire:submit.prevent="save">
        <div class="flex w-full items-center justify-center bg-gray-900 pb-15">
            <label class="w-64 flex flex-col items-center px-4 py-6 bg-white text-blue rounded-lg shadow-lg tracking-wide uppercase border border-blue cursor-pointer hover:bg-blue hover:text-blue">
                <svg class="w-8 h-8" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z" />
                </svg>
                <span class="mt-2 text-base leading-normal">Select Files</span>
                <input  class="hidden" type="file" wire:model="files" multiple>
            </label>

            <div class="m-6 space-y-3 w-72">
                <button
                    wire:loading.remove
                    type="submit"
                    class="block w-full px-6 py-2 text-xs font-medium
                     leading-6 text-center text-white uppercase transition
                      bg-blue-700 rounded shadow ripple hover:shadow-lg
                       hover:bg-blue-800 focus:outline-none waves-effect"
                >
                    {{ $text }}
                </button>

                @error('files.*') <span class="text-white error">{{ $message }}</span> @enderror

                <div wire:loading>
                    <p class="text-white">
                        Processing...
                    </p>

                </div>

                <button type="button" class="block w-full px-6 py-2
                text-xs font-medium leading-6 text-center
                 text-white uppercase transition bg-blue-700
                  rounded shadow ripple hover:shadow-lg hover:bg-blue-800
                   focus:outline-none waves-effect" wire:click="download"
                >
                    Download File
                </button>

            </div>
    </form>

</div>
