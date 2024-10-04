<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between text-white">
            <div class="md:flex flex-row items-center md:space-x-1 text-2xl font-semibold text-white">
                <div>{{ __('Stream') }}</div>
                <div class="hidden md:block text-slate-600">|</div>
                <div class="md:text-lg text-sm leading-none font-normal text-sky-500">{{ $batch->course->name }}</div>
            </div>
            <div class="hidden md:flex items-center">
                <div class="flex space-x-1 mr-4">
                    <div class="text-white/75"> Batch: </div>
                    <div>
                        {{ $batch->course->code }}-{{ $batch->name }}
                    </div>
                </div>
            </div>
            <div class="flex md:hidden items-center">
                <x-dropdown width="40" align="right">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center p-1  rounded-md hover:bg-gray-900/50">
                            <svg class="h-7 w-7 text-white" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24">
                                <title>dots-vertical</title>
                                <path
                                    d="M12,16A2,2 0 0,1 14,18A2,2 0 0,1 12,20A2,2 0 0,1 10,18A2,2 0 0,1 12,16M12,10A2,2 0 0,1 14,12A2,2 0 0,1 12,14A2,2 0 0,1 10,12A2,2 0 0,1 12,10M12,4A2,2 0 0,1 14,6A2,2 0 0,1 12,8A2,2 0 0,1 10,6A2,2 0 0,1 12,4Z" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="m-1.5 flex-row">
                            <div class="my-2 flex justify-center text-xs space-x-1">
                                <div class="text-white/75"> Batch: </div>
                                <div>
                                    {{ $batch->course->code }}-{{ $batch->name }}
                                </div>
                            </div>
                            <x-course-nav :selected="'stream'" :batch="$batch->id"></x-course-nav>
                        </div>
                    </x-slot>
                </x-dropdown>
            </div>
        </div>
        <div class="hidden md:block">

            <x-course-nav :selected="'stream'" :batch="$batch->id"></x-course-nav>
        </div>
    </x-slot>

</x-app-layout>
