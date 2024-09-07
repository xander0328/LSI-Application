<x-app-layout>
    @section('style')
        [x-cloak] { display: none !important; }
    @endsection
    <x-slot name="header">
        <div class="flex items-center justify-between pr-4 text-white">
            <div class="text-2xl font-semibold text-white">
                {{ __('Payments') }}
            </div>
            <div class="w-1/2">
                <select id="course_select"
                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-sm text-gray-900 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400">
                    @foreach ($all_courses as $courseSelection)
                        <option {{ $course_id == $courseSelection->id ? 'selected' : '' }}
                            value="{{ $courseSelection->id }}">
                            {{ $courseSelection->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

    </x-slot>

    <div x-data="managePayments" class="p-2 px-8 pb-16 pt-40">
        <section class="bg-gray-50 dark:bg-gray-900">
            <div class="mx-auto max-w-screen-xl">
                <!-- Start coding here -->
                <div class="overflow-hidden bg-white shadow-md dark:bg-gray-800 sm:rounded-lg">
                    <div
                        class="flex flex-col items-center justify-between space-y-3 p-4 md:flex-row md:space-x-4 md:space-y-0">
                        <div class="w-full md:w-1/2">
                            <form class="flex items-center">
                                <label for="simple-search" class="sr-only">Search</label>
                                <div class="relative w-full">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                        <svg aria-hidden="true" class="h-5 w-5 text-gray-500 dark:text-gray-400"
                                            fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <input type="text" id="simple-search"
                                        class="focus:ring-primary-500 focus:border-primary-500 dark:focus:ring-primary-500 dark:focus:border-primary-500 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 pl-10 text-sm text-gray-900 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400"
                                        placeholder="Search" required="">
                                </div>
                            </form>
                        </div>
                        <div
                            class="flex w-full flex-shrink-0 flex-col items-stretch justify-end space-y-2 md:w-auto md:flex-row md:items-center md:space-x-3 md:space-y-0">
                            <div class="flex w-full items-center md:w-auto">
                                <select @change="batchChanged($event)"
                                    class="flex w-full items-center justify-center rounded-lg border px-4 py-2 text-sm font-medium text-gray-400 focus:z-10 dark:border-gray-600 dark:bg-gray-800 md:w-auto">
                                    <template x-for="batch in all_batches" :key="batch.id">
                                        <option :selected="selectedBatch == batch.id" :value="batch.id"
                                            x-text="`${course.code}-${batch.name}`"></option>
                                    </template>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-gray-500 dark:text-gray-400">
                            <thead
                                class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-4 py-3">Name</th>
                                    <th scope="col" class="px-4 py-3">Employment</th>
                                    <th scope="col" class="px-4 py-3">Balance</th>
                                    <th scope="col" class="px-4 py-3">
                                        <span class="sr-only"></span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <template x-for="enrollee in course.batches[0].enrollee">
                                    <tr class="border-b dark:border-gray-700">
                                        <th scope="row"
                                            class="whitespace-nowrap px-4 py-3 font-medium text-gray-900 dark:text-white">
                                            <div class="flex items-center whitespace-nowrap text-white">
                                                <template x-if="enrollee.enrollee_files?.length < 1">
                                                    <img src="{{ asset('images/temporary/profile.png') }}"
                                                        class="h-10 w-10 rounded-full" alt="profile">
                                                </template>
                                                <template x-for="file in enrollee.enrollee_files"
                                                    :key="file.id">
                                                    <template x-if="file.credential_type === 'id_picture'">
                                                        <img :src="'{{ asset('storage/enrollee_files/') }}/' +
                                                        course.id + '/' + enrollee.id + '/id_picture' +
                                                            '/' + file.folder + '/' + file.filename"
                                                            class="h-10 w-10 rounded-full" alt="profile">
                                                    </template>
                                                </template>
                                                <div class="pl-3">
                                                    <div class="text-base font-semibold"
                                                        x-text="`${enrollee.user.lname}, ${enrollee.user.fname} ${enrollee.user.mname || ''}`">
                                                    </div>
                                                    <div class="font-normal text-gray-500" x-text="enrollee.user.email">
                                                    </div>
                                                </div>
                                            </div>
                                        </th>
                                        <td class="px-4 py-3">
                                            <div>Type: <span class="capitalize"
                                                    x-text="enrollee.employment_type ?? '---'"></span></div>
                                            <div>Status: <span class="capitalize"
                                                    x-text="enrollee.employment_status ?? '---' "></span></div>
                                        </td>
                                        <td class="px-4 py-3">
                                            <span
                                                :class="enrollee.payments[0]?.balance == 0 ?
                                                    'bg-sky-900 text-sky-300 px-2 py-1 rounded text-sm' : ''"
                                                x-text="enrollee.payments[0]?.balance == 0 ? 'Paid' : `Php ${enrollee.payments[0]?.balance}`"></span>
                                        </td>
                                        <td class="flex items-center justify-end px-4 py-3">
                                            <x-dropdown width="40" align="right">
                                                <x-slot name="trigger">
                                                    <button
                                                        class="inline-flex items-center rounded-md border border-transparent bg-white text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out hover:text-gray-700 focus:outline-none dark:bg-gray-800 dark:text-gray-400 dark:hover:text-gray-300">
                                                        <svg class="h-7 w-7 text-white"
                                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                            <path fill="currentColor"
                                                                d="M16,12A2,2 0 0,1 18,10A2,2 0 0,1 20,12A2,2 0 0,1 18,14A2,2 0 0,1 16,12M10,12A2,2 0 0,1 12,10A2,2 0 0,1 14,12A2,2 0 0,1 12,14A2,2 0 0,1 10,12M4,12A2,2 0 0,1 6,10A2,2 0 0,1 8,12A2,2 0 0,1 6,14A2,2 0 0,1 4,12Z" />
                                                        </svg>
                                                    </button>
                                                </x-slot>

                                                <x-slot name="content">
                                                    <div class="m-1.5">
                                                        <a @click="triggerModal('history', enrollee.id)"
                                                            class="flex w-full cursor-pointer items-center space-x-1.5 rounded-md px-4 py-2 text-start text-sm leading-5 text-gray-300 transition duration-150 ease-in-out hover:bg-gray-800 focus:bg-gray-800 focus:outline-none">
                                                            <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                                                viewBox="0 0 24 24">
                                                                <title>history</title>
                                                                <path fill="currentColor"
                                                                    d="M13.5,8H12V13L16.28,15.54L17,14.33L13.5,12.25V8M13,3A9,9 0 0,0 4,12H1L4.96,16.03L9,12H6A7,7 0 0,1 13,5A7,7 0 0,1 20,12A7,7 0 0,1 13,19C11.07,19 9.32,18.21 8.06,16.94L6.64,18.36C8.27,20 10.5,21 13,21A9,9 0 0,0 22,12A9,9 0 0,0 13,3" />
                                                            </svg>
                                                            <div>History</div>
                                                        </a>
                                                        <a @click="triggerModal('pay', enrollee.id)"
                                                            class="flex w-full cursor-pointer items-center space-x-1.5 rounded-md px-4 py-2 text-start text-sm leading-5 text-gray-300 transition duration-150 ease-in-out hover:bg-gray-800 focus:bg-gray-800 focus:outline-none">
                                                            <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                                                viewBox="0 0 24 24">
                                                                <title>cash-payment</title>
                                                                <path fill="currentColor"
                                                                    d="M15 15V17H18V20H20V17H23V15H20V12H18V15M14.97 11.61C14.85 10.28 13.59 8.97 12 9C10.3 9.03 9 10.3 9 12C9 13.7 10.3 14.94 12 15C12.38 15 12.77 14.92 13.14 14.77C13.41 13.67 13.86 12.63 14.97 11.61M13 16H7C7 14.9 6.11 14 5 14V10C6.11 10 7 9.11 7 8H17C17 9.11 17.9 10 19 10V10.06C19.67 10.06 20.34 10.18 21 10.4V6H3V18H13.32C13.1 17.33 13 16.66 13 16Z" />
                                                            </svg>
                                                            <div>Pay</div>
                                                        </a>
                                                        <a @click="triggerModal('refund', enrollee.id)"
                                                            class="flex w-full cursor-pointer items-center space-x-1.5 rounded-md px-4 py-2 text-start text-sm leading-5 text-gray-300 transition duration-150 ease-in-out hover:bg-red-900 focus:bg-gray-800 focus:outline-none">
                                                            <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                                                viewBox="0 0 24 24">
                                                                <title>cash-refund</title>
                                                                <path fill="currentColor"
                                                                    d="M3 6V18H13.32C13.1 17.33 13 16.66 13 16H7C7 14.9 6.11 14 5 14V10C6.11 10 7 9.11 7 8H17C17 9.11 17.9 10 19 10V10.06C19.67 10.06 20.34 10.18 21 10.4V6H3M12 9C10.3 9.03 9 10.3 9 12S10.3 14.94 12 15C12.38 15 12.77 14.92 13.14 14.77C13.41 13.67 13.86 12.63 14.97 11.61C14.85 10.28 13.59 8.97 12 9M19 11L21.25 13.25L19 15.5V14C17.15 14 15.94 15.96 16.76 17.62L15.67 18.71C13.91 16.05 15.81 12.5 19 12.5V11M19 22L16.75 19.75L19 17.5V19C20.85 19 22.06 17.04 21.24 15.38L22.33 14.29C24.09 16.95 22.19 20.5 19 20.5V22" />
                                                            </svg>
                                                            <div>Refund</div>
                                                        </a>
                                                    </div>
                                                </x-slot>
                                            </x-dropdown>
                                        </td>
                                    </tr>
                                </template>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>

        {{-- Pay Modal --}}
        <div x-cloak x-show="showPayModal" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95" tabindex="-1"
            class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto overflow-x-hidden bg-gray-800 bg-opacity-50">
            <div class="relative max-h-full w-full max-w-lg p-4">
                <!-- Modal content -->
                <div class="relative rounded-lg bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between rounded-t border-b p-4 dark:border-gray-600 md:p-5">
                        <h3 class="flex items-center space-x-1 text-lg font-semibold text-gray-900 dark:text-white">
                            <svg class="h-7 w-7 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <title>cash-payment</title>
                                <path fill="currentColor"
                                    d="M15 15V17H18V20H20V17H23V15H20V12H18V15M14.97 11.61C14.85 10.28 13.59 8.97 12 9C10.3 9.03 9 10.3 9 12C9 13.7 10.3 14.94 12 15C12.38 15 12.77 14.92 13.14 14.77C13.41 13.67 13.86 12.63 14.97 11.61M13 16H7C7 14.9 6.11 14 5 14V10C6.11 10 7 9.11 7 8H17C17 9.11 17.9 10 19 10V10.06C19.67 10.06 20.34 10.18 21 10.4V6H3V18H13.32C13.1 17.33 13 16.66 13 16Z" />
                            </svg> <span>Pay</span>
                        </h3>
                        <button type="button" @click="showPayModal = !showPayModal;"
                            class="ms-auto inline-flex h-8 w-8 items-center justify-center rounded-lg bg-transparent text-sm text-gray-400 hover:bg-gray-200 hover:text-gray-900 dark:hover:bg-gray-600 dark:hover:text-white">
                            <svg class="h-3 w-3" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>

                    <!-- Modal body -->
                    <div class="p-4 md:p-5">
                        <div class="mb-4 grid grid-cols-2 gap-4">
                            <div class="col-span-2">
                                <template x-if="selectedEnrollee != null">
                                    <form @submit.prevent="makePayment(selectedEnrollee?.payments[0]?.balance)"
                                        action="{{ route('make_payment') }}" method="post">
                                        <div
                                            class="mb-2 block rounded-md bg-sky-700 px-2 py-1 text-sm font-medium text-white">
                                            Current
                                            balance: Php <span class="font-bold"
                                                x-text="selectedEnrollee?.payments[0]?.balance"></span></div>
                                        <div class="grid grid-cols-2 rounded-md bg-gray-900/50 p-2">
                                            <label for="lesson"
                                                class="mb-2 block text-sm font-medium text-white">Payment
                                                amount:</label>
                                            @csrf
                                            <input type="hidden" name="payment_id"
                                                :value="selectedEnrollee?.payments[0]?.id">
                                            <input type="hidden" name="enrollee_name"
                                                :value="`${selectedEnrollee?.user.fname} ${selectedEnrollee?.user.lname}`">
                                            <div class="col-span-2 mb-2">
                                                <input type="number" id="payment_amount" name="payment_amount"
                                                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                                                    placeholder="Philippine Peso" required />
                                            </div>
                                            <button
                                                @click.prevent="makePayment(selectedEnrollee?.payments[0]?.balance)"
                                                type="button"
                                                class="col-span-2 flex w-full items-center justify-center rounded-md bg-sky-700 p-2 px-3 text-white">Deduct
                                            </button>
                                        </div>
                                    </form>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Refund Modal --}}
        <div x-cloak x-show="showRefundModal" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95" tabindex="-1"
            class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto overflow-x-hidden bg-gray-800 bg-opacity-50">
            <div class="relative max-h-full w-full max-w-lg p-4">
                <!-- Modal content -->
                <div class="relative rounded-lg bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between rounded-t border-b p-4 dark:border-gray-600 md:p-5">
                        <h3 class="flex items-center space-x-1 text-lg font-semibold text-gray-900 dark:text-white">
                            <svg class="h-7 w-7 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <title>cash-refund</title>
                                <path fill="currentColor"
                                    d="M3 6V18H13.32C13.1 17.33 13 16.66 13 16H7C7 14.9 6.11 14 5 14V10C6.11 10 7 9.11 7 8H17C17 9.11 17.9 10 19 10V10.06C19.67 10.06 20.34 10.18 21 10.4V6H3M12 9C10.3 9.03 9 10.3 9 12S10.3 14.94 12 15C12.38 15 12.77 14.92 13.14 14.77C13.41 13.67 13.86 12.63 14.97 11.61C14.85 10.28 13.59 8.97 12 9M19 11L21.25 13.25L19 15.5V14C17.15 14 15.94 15.96 16.76 17.62L15.67 18.71C13.91 16.05 15.81 12.5 19 12.5V11M19 22L16.75 19.75L19 17.5V19C20.85 19 22.06 17.04 21.24 15.38L22.33 14.29C24.09 16.95 22.19 20.5 19 20.5V22" />
                            </svg> <span>Refund</span>
                        </h3>
                        <button type="button" @click="showRefundModal = !showRefundModal;"
                            class="ms-auto inline-flex h-8 w-8 items-center justify-center rounded-lg bg-transparent text-sm text-gray-400 hover:bg-gray-200 hover:text-gray-900 dark:hover:bg-gray-600 dark:hover:text-white">
                            <svg class="h-3 w-3" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>

                    <!-- Modal body -->
                    <div class="p-4 md:p-5">
                        <div class="mb-4 grid grid-cols-2 gap-4">
                            <div class="col-span-2">
                                <template x-if="selectedEnrollee != null">
                                    <form x-data="{ refundReason: '' }"
                                        @submit.prevent="makeRefund(selectedEnrollee?.payments[0]?.balance, refundReason)"
                                        action="{{ route('make_refund') }}" method="post">
                                        <div
                                            class="mb-2 block rounded-md bg-sky-700 px-2 py-1 text-sm font-medium text-white">
                                            Current
                                            balance: Php <span class="font-bold"
                                                x-text="selectedEnrollee?.payments[0]?.balance"></span></div>
                                        <div class="grid grid-cols-1 rounded-md bg-gray-900/50 p-2">
                                            <label for="lesson"
                                                class="mb-1 block text-sm font-medium text-white">Refund
                                                amount:</label>
                                            @csrf
                                            <input type="hidden" name="payment_id"
                                                :value="selectedEnrollee?.payments[0]?.id">
                                            <input type="hidden" name="enrollee_name"
                                                :value="`${selectedEnrollee?.user.fname} ${selectedEnrollee?.user.lname}`">
                                            <div class="col-span-1 mb-2">
                                                <input type="number" id="refund_amount" name="refund_amount"
                                                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                                                    placeholder="Philippine Peso" required />
                                            </div>
                                            <div class="col-span-1 mb-2">
                                                <select id="refund_reason" name="refund_reason"
                                                    x-model="refundReason" required
                                                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-sm text-gray-900 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400">
                                                    <option value="">Select a reason</option>
                                                    <option value="wrong input">Wrong Input</option>
                                                    <option value="bond deposit">Bond Deposit</option>
                                                    <option value="other">Other</option>
                                                </select>
                                            </div>
                                            <div x-show="refundReason === 'other'" class="col-span-1 mb-2">
                                                <label for="other_reason"
                                                    class="mb-1 block text-sm font-medium text-white">Please
                                                    specify</label>
                                                <input type="text" id="other_reason" name="other_reason"
                                                    :required="refundReason === 'other'"
                                                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                                                    placeholder="Enter your reason here">
                                            </div>
                                            <button
                                                @click.prevent="makeRefund(selectedEnrollee?.payments[0]?.balance, refundReason)"
                                                type="button"
                                                class="flex w-full items-center justify-center rounded-md bg-sky-700 p-2 px-3 text-white">
                                                Refund
                                            </button>
                                        </div>
                                    </form>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- History Modal --}}
        <div x-cloak x-show="showHistoryModal" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95" tabindex="-1"
            class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto overflow-x-hidden bg-gray-800 bg-opacity-50">
            <div class="relative max-h-full w-full max-w-xl p-4">
                <!-- Modal content -->
                <div class="relative rounded-lg bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between rounded-t border-b p-4 dark:border-gray-600 md:p-5">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            History
                        </h3>
                        <button type="button" @click="showHistoryModal = false;"
                            class="ms-auto inline-flex h-8 w-8 items-center justify-center rounded-lg bg-transparent text-sm text-gray-400 hover:bg-gray-200 hover:text-gray-900 dark:hover:bg-gray-600 dark:hover:text-white">
                            <svg class="h-3 w-3" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>

                    <!-- Modal body -->
                    <div class="p-4 md:p-5">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="col-span-2">

                                <div class="relative mt-4 rounded-md bg-gray-800/75 text-white">
                                    <div
                                        class="absolute -top-4 left-2 mb-2 flex w-1/3 items-center justify-center rounded-md bg-sky-700 py-2 text-white shadow-md">
                                        <svg class="h-7 w-7 pr-1.5" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 24 24">
                                            <title>clipboard-outline</title>
                                            <path fill="currentColor"
                                                d="M19,3H14.82C14.4,1.84 13.3,1 12,1C10.7,1 9.6,1.84 9.18,3H5A2,2 0 0,0 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5A2,2 0 0,0 19,3M12,3A1,1 0 0,1 13,4A1,1 0 0,1 12,5A1,1 0 0,1 11,4A1,1 0 0,1 12,3M7,7H17V5H19V19H5V5H7V7Z" />
                                        </svg>
                                        <div>
                                            Payment Log
                                        </div>
                                    </div>
                                    <template x-if="enrolleeHistory != null">
                                        <div class="px-2 pb-4 pt-10">
                                            <template x-if="enrolleeHistory.payment_logs.length < 1">
                                                <div class="p-2 text-center text-sm text-gray-400">No Records</div>
                                            </template>

                                            <template x-if="enrolleeHistory.payment_logs.length > 0">
                                                <ol
                                                    class="relative ms-5 border-s border-gray-700 p-2 text-sm text-gray-300">
                                                    <template x-for="log in enrolleeHistory.payment_logs"
                                                        :key="log.id">
                                                        <li class="mb-2 ms-4">
                                                            <div
                                                                class="mb-1 flex items-center justify-between rounded-md bg-gray-800 p-2 hover:bg-gray-800/75">
                                                                <span
                                                                    :class="log.refund_reason == null ? 'bg-sky-300' :
                                                                        'bg-sky-700'"
                                                                    class="absolute -start-2 flex h-4 w-4 items-center justify-center rounded-full">

                                                                </span>
                                                                <span class="font-medium"
                                                                    x-text="`Php${log.amount}`"></span>
                                                                <div class="flex items-center">
                                                                    <div class="flex items-center">
                                                                        <div :class="{
                                                                            'bg-red-900 text-red-300': log
                                                                                .refund_reason !=
                                                                                null,
                                                                            'bg-green-900 text-green-300': log
                                                                                .refund_reason ==
                                                                                null,
                                                                        }"
                                                                            class="rounded px-2 py-0.5 text-sm"
                                                                            x-text="log.refund_reason == null ? 'Payment' : 'Refund'">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="pe-2 text-right text-xs text-white/50">
                                                                <span class="normal-case"
                                                                    x-show="log.refund_reason != null"
                                                                    x-text="`Reason: ${log.refund_reason} | `"></span>
                                                                <span
                                                                    x-text="moment(log.created_at).format('lll')"></span>
                                                            </div>
                                                        </li>
                                                    </template>
                                                </ol>
                                            </template>

                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                        <div x-cloak x-show="dataLoading" role="status"
                            class="absolute left-1/2 top-2/4 -translate-x-1/2 -translate-y-1/2">
                            <svg aria-hidden="true"
                                class="h-8 w-8 animate-spin fill-white text-gray-200 dark:text-gray-600"
                                viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                    fill="currentColor" />
                                <path
                                    d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                    fill="currentFill" />
                            </svg>
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @section('script')
        <script>
            function managePayments() {
                return {
                    // Data Containers
                    course: @json($course),
                    all_courses: @json($all_courses),
                    all_batches: @json($all_batches),
                    selectedBatch: {{ $batch_id }},
                    selectedCourse: {{ $course_id }},
                    selectedEnrollee: null,
                    enrolleeHistory: null,

                    // Data Retrieval Containers
                    conroller: null,
                    xhr: null,
                    dataLoading: false,

                    // Modals
                    showPayModal: false,
                    showRefundModal: false,
                    showHistoryModal: false,
                    triggerModal(type, enrolleeId) {

                        this.selectedEnrollee = this.course.batches[0].enrollee.find(
                            (enrollee) => enrollee.id === enrolleeId
                        );

                        if (type == 'pay') {
                            this.showPayModal = true;
                        } else if (type == 'refund') {
                            this.showRefundModal = true;
                        } else {
                            this.showHistoryModal = true;
                            this.getHistory();
                        }
                    },

                    init() {
                        // console.log(this.selectedEnrollee.length);

                        const course_select = $('#course_select');
                        course_select.on('change', () => {
                            this.courseChanged(course_select.val());
                        });

                        @if (session('status'))
                            this.notification("{{ session('status') }}", "{{ session('message') }}",
                                "{{ session('title') ?? session('title') }}");
                            console.log('notif');
                        @endif
                    },

                    // Filtering
                    courseChanged(course) {
                        window.location.href = `/payments?course=${course}&batch=${this.selectedBatchId || ''}`;
                    },
                    batchChanged(event) {
                        var batch = event.target.value
                        window.location.href = `/payments?course=${this.selectedCourse}&batch=${batch}`;
                    },


                    // Pay Modal
                    makePayment(balance) {
                        var amount = parseFloat($('#payment_amount').val());
                        var form = event.target.closest('form');
                        if (!amount || amount < 1 || amount > balance) {
                            this.notification('error',
                                'Please enter valid amount. Payment should be Php 1.00 to ' +
                                balance, 'Payment')
                        } else {
                            if (form.checkValidity()) {
                                form.submit();
                            } else {
                                form.reportValidity();
                            }
                        }
                    },

                    // Refund Modal
                    makeRefund(balance, reason) {
                        var amount = parseFloat($('#refund_amount').val());
                        var form = event.target.closest('form');
                        if (!amount || amount < 1) {

                            this.notification('error',
                                'Please enter valid amount. Payment should greater than Php 1.00 but less than or equal to Php ' +
                                balance, 'Refund')
                        } else if (reason == 'bond deposit' && amount > this.course.bond_deposit) {
                            // 
                            this.notification('error', 'You can\'t refund more than set bond deposit for this course (Php ' +
                                this
                                .course
                                .bond_deposit + ')', 'Refund')
                        } else {
                            if (form.checkValidity()) {
                                form.submit();
                            } else {
                                form.reportValidity();
                            }
                        }
                    },

                    // History Modal
                    getHistory() {
                        this.abortFetch('ajax')
                        this.dataLoading = true
                        var t = this
                        this.xhr = $.ajax({
                            url: '{{ route('get_payment_details') }}',
                            method: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                enrollee_id: t.selectedEnrollee.id
                            },
                            success: function(response) {
                                t.enrolleeHistory = response.payment
                                console.log(t.enrolleeHistory);
                                t.dataLoading = false
                            },
                            error: function(xhr, status, error) {
                                console.error(xhr.responseText);
                            }
                        });
                    },

                    // Utility
                    notification(status, message, title) {
                        status === 'success' ? toastr.success(message, title ?? title) : toastr.error(message,
                            title ?? title);
                        toastr.options.closeButton = true;
                        toastr.options = {
                            "closeButton": true,
                            "progressBar": true,
                            "positionClass": "toast-bottom-right",
                            "showDuration": "300",
                            "hideDuration": "800",
                            "timeOut": "5000",
                            "extendedTimeOut": "1000",
                            "showEasing": "swing",
                            "hideEasing": "linear",
                            "showMethod": "fadeIn",
                            "hideMethod": "fadeOut"
                        }
                    },
                    abortFetch(type) {
                        // Abort the current fetch request if there's an ongoing one
                        if (type == 'fetch') {
                            if (this.controller) {
                                this.controller.abort();
                            }
                        }

                        if (type == 'ajax') {
                            if (this.xhr) {
                                this.xhr.abort();
                            }
                        }
                    },
                }
            }
        </script>
    @endsection
</x-app-layout>
