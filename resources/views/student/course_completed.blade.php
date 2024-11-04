<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="text-2xl font-semibold text-sky-950 dark:text-white">
                {{ __('Course/s Completed') }}
            </div>
        </div>
    </x-slot>
    <div x-data="completedList" class="mx-8 my-4 pt-36">
        <ul class="space-y-2 text-black dark:text-white">
            <template x-if="completed.length == 0">
                <div class="rounded-lg bg-white p-4 text-center dark:bg-gray-800">
                    <div class="text-xl font-bold">Keep Going!</div>
                    <div>No completed course yet</div>
                </div>
            </template>
            <template x-if="completed.length > 0">
                <template x-for="course in completed" :key="course.id">
                    <li id="course-item" class="rounded-md bg-white p-4 dark:bg-gray-700">
                        <div class="justify-between align-middle text-sm">
                            <div class="mb-1 text-xl font-bold" x-text="course.course.name"></div>
                            <div>
                                <span class="font-semibold">Batch:</span>
                                <span x-text="`${course.course.code}-${course.batch.name}`"></span>
                            </div>
                            <div>
                                <span class="font-semibold">Date Completed:</span>
                                <span x-text="moment(course.completed_at).format('ll')"></span>
                            </div>
                        </div>
                    </li>
                </template>
            </template>
        </ul>
    </div>
    @section('script')
        <script>
            function completedList() {
                return {
                    @section('enrollee')
                        @json($enrollee ?? '')
                    @endsection
                    completed: @json($completed ?? ''),
                    init() {

                    }
                }
            }
        </script>
    @endsection
</x-app-layout>
