<x-app-layout>
<x-slot name="header">
        <div class="flex items-center justify-between text-white">
            <div class="text-2xl font-semibold text-gray-800 dark:text-gray-200">
                {{ __('Report') }}
            </div>
        </div>
    </x-slot>
    <div x-data="report" class="pt-40 pb-4 mx-4 text-black dark:text-white md:mx-8">
        <div class="pb-4 text-lg font-bold">Select Category</div>
        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
            <template x-for="report in report_list" >
                <a :href="report.link" class="flex items-center space-x-2 bg-white shadow-md p-4 border-cyan-500 border-s-4 hover:border-s-8 rounded-lg">
                    <span class="iconify h-8 w-8" :data-icon="report.icon"></span>
                    <span x-text="report.name"></span>
                </a>
            </template>
        </div>
    </div>
    @section('script')
    <script>
        function report(){
            return {
                report_list: [
                    {name: "Accounts", link:"{{route('show_report_accounts')}}", icon:"mdi:account"},
                        {name: "Courses", link:"{{route('show_report_courses')}}", icon:"mdi:school"},
                 ]
            }
        }
    </script>
    @endsection
</x-app-layout>
