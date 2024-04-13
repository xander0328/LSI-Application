<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between text-white">
            <div class="text-2xl font-semibold text-gray-800 dark:text-gray-200">
                {{ __('Batch List') }}
            </div>
        </div>

    </x-slot>
    <div id="course_list" class="mx-8 my-4">
        <div class="">
            @foreach ($batch as $batch)
                @php
                    $id = encrypt($batch->id);
                @endphp
                <a href="{{ route('batch_posts', $id) }}" data-batch-id="{{ $batch->id }}"
                    class="batch-button mb-2 flex w-full justify-between rounded-md bg-gray-700 p-2 text-start text-white hover:bg-sky-600">
                    {{ $batch->name }}
                </a>
            @endforeach
        </div>
    </div>

    @section('script')
        <script type="text/javascript"></script>
    @endsection
</x-app-layout>
