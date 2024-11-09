<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between text-white">
            <div class="text-2xl font-semibold text-sky-950 dark:text-white">
                {{ __('Attendance') }} <span class="text-slate-600">
            </div>
        </div>
        {{-- <x-course-nav :selected="'attendance'" :batch="$batch->id"></x-course-nav> --}}

    </x-slot>
    <div x-data="scanStudent()"
        class="mx-8 mt-2 grid h-full grid-rows-1 gap-3 pt-44 align-middle text-black dark:text-white md:grid-cols-1">
        <div id="qr-reader-container" class="mx-auto">
            <div class="text-gray-500">Scan Trainee's QR Code</div>
            <div class="p-4" id="qr-reader"></div>
        </div>
        <div class="p-4 ps-8">
            <template x-if="!student_data || Object.keys(student_data).length = 0">
                <div>Scan ID QR code</div>
            </template>
            <template x-if="Object.keys(student_data).length > 0">
                <div class="grid grid-cols-2 gap-3">
                    <div class="grid justify-items-center">
                        <template x-if="student_data.id_pic == null">
                            <img class="w-48 rounded-full border-sky-700"
                                src="{{ asset('images/temporary/profile.png') }}" alt="">
                        </template>
                        <template x-if="student_data.id_pic != null">
                            <img class="w-48 rounded-full border-sky-700" :src="student_data.id_pic" alt="">
                        </template>
                        <div class="text-lg font-bold" x-text="student_data.name"></div>
                        <div class="text-sm" x-text="student_data.course_code + '-' + student_data.batch_name"></div>
                        <div class="mt-2 w-full">
                            <div @click="handleButtonClick('present')" class="mb-1.5">
                                <button
                                    class="w-full rounded-md bg-sky-700 p-2 text-center text-sm text-white hover:bg-sky-800">Accept
                                    as
                                    On Time</button>
                            </div>
                            <div @click="handleButtonClick('late')" class="mb-1.5">
                                <button
                                    class="w-full rounded-md bg-yellow-700 p-2 text-center text-sm text-white hover:bg-yellow-800">Accept
                                    as
                                    Late</button>
                            </div>
                            <div @click="handleButtonClick('decline')" class="mb-1.5">
                                <button
                                    class="w-full rounded-md bg-orange-700 p-2 text-center text-sm text-white hover:bg-orange-800">Decline</button>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="mb-2 font-bold">Today's Record </div>
                        <div class="relative overflow-hidden rounded-md bg-white shadow-md dark:bg-gray-800">
                            <table class="w-full text-left text-sm text-gray-700 dark:text-white">
                                <thead
                                    class="bg-sky-300 text-xs uppercase text-black dark:bg-sky-800 dark:text-gray-300">
                                    <tr>
                                        <th scope="col" class="px-4 py-3">Time</th>
                                        <th scope="col" class="px-4 py-3">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template x-if="student_data.attendance.length > 0">
                                        <template x-for="data in student_data.attendance" :key="data.id">
                                            <tr class="border-b dark:border-gray-700">
                                                <td class="px-4 py-2" x-text="moment(data.created_at).format('LT')">
                                                </td>
                                                <td class="px-4 py-2 capitalize"
                                                    x-text="data.status == 'present' ? 'On Time' : data.status"></td>
                                            </tr>
                                        </template>
                                    </template>

                                    <template x-if="student_data.attendance.length == 0">
                                        <tr class="border-b dark:border-gray-700">
                                            <td class="px-4 py-2">No Record</td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </template>
        </div>
        <input x-model="qrCodeId" @keydown.enter="getUserData()" id="inputField" x-init="$nextTick(() => $refs.inputField.focus())"
            x-ref="inputField" @blur="$nextTick(() => $refs.inputField.focus())" class="text-xs opacity-0"
            type="text" id="qr-code-id">
    </div>
    @section('script')
        <script>
            function scanStudent() {
                return {
                    student_data: {},
                    qrCodeScanner: null,
                    qrCodeId: '',
                    isScanning: false,
                    init() {
                        this.qrCodeScanner = new Html5Qrcode("qr-reader");
                        this.startScanning();
                    },
                    async startScanning() {
                        if (this.isScanning) return; // Prevent multiple starts
                        this.isScanning = true;

                        try {
                            await this.qrCodeScanner.start({
                                    facingMode: "environment"
                                }, // Use rear camera
                                {
                                    fps: 5,
                                    qrbox: {
                                        width: 250,
                                        height: 250
                                    },
                                },
                                this.onScanSuccess.bind(this),
                                this.onScanError.bind(this)
                            );
                        } catch (err) {
                            console.error(err);
                        }
                    },
                    async pauseScanning() {
                        try {
                            this.qrCodeScanner.pause(true);
                            console.log("QR Code scanning paused.");
                        } catch (err) {
                            console.error("Unable to pause scanning:", err);
                        }
                    },
                    async resumeScanning() {
                        try {
                            await this.qrCodeScanner.resume();
                            console.log("QR Code scanning resumed.");
                            $('#qr-reader-container').toggle('hidden');

                        } catch (err) {
                            console.error("Unable to resume scanning:", err);
                        }
                    },

                    async handleButtonClick(status) {
                        try {

                            if (status != 'decline') {
                                const data = {
                                    student_id: this.student_data.id,
                                    status: status,
                                    batch_id: this.student_data.batch_id,
                                    _token: '{{ csrf_token() }}'
                                };


                                await $.ajax({
                                    url: "{{ route('submit_f2f_attendance') }}", // Update with your route
                                    method: 'POST',
                                    data: data,
                                    success: function(response) {
                                        console.log('Data submitted successfully:', response);
                                        this.notification(response.status, response.message, response.title)
                                    },
                                    error: function(xhr, status, error) {
                                        console.error('Error submitting data:', error);
                                    }
                                });
                            }

                            this.student_data = {};
                            await this.resumeScanning();

                        } catch (err) {
                            console.error('Error processing action:', err);
                        }
                    },
                    async onScanSuccess(decodedText, decodedResult) {
                        const component = this;
                        $('#qr-reader-container').toggle('hidden');

                        try {
                            const response = await $.ajax({
                                url: "{{ route('get_scan_data') }}",
                                method: 'POST',
                                data: {
                                    qr_code: decodedText,
                                    _token: '{{ csrf_token() }}'
                                }
                            });

                            if (response.status && response.status == "error") {
                                component.notification('error', response.message, 'Error Scanning ID')
                                throw new Error(response.message)
                            }

                            var student = component.student_data;
                            var id_pic = response.enrollee_files.find(file => file.credential_type === 'id_picture');

                            student.name = `${response.user.fname} ${response.user.lname}`;
                            student.batch_name = `${response.batch.name}`;
                            student.course_code = `${response.batch.course.code}`;
                            student.attendance = response.enrollee_attendances;
                            student.batch_id = response.batch.id;
                            student.id = response.id;
                            if (id_pic) {
                                student.id_pic =
                                    `{{ asset('storage/enrollee_files/') }}/${response.course_id}/${response.id}/id_picture/${id_pic.folder}/${id_pic.filename}`;
                            } else {
                                student.id_pic = null;
                            }


                            // Stop scanning after successful scan
                            await component.pauseScanning();
                            console.log("QR Code scanning stopped.");
                        } catch (err) {
                            console.error('Error generating ID card:', err);
                            return;
                            // alert('An error occurred while scanning the ID card.');
                        }
                    },
                    onScanError(errorMessage) {
                        // Handle scan error
                        // console.error(errorMessage);
                    },

                    async getUserData() {
                        const component = this;
                        $('#qr-reader-container').toggle('hidden');

                        try {
                            const response = await $.ajax({
                                url: "{{ route('get_scan_data') }}",
                                method: 'POST',
                                data: {
                                    qr_code: component.qrCodeId,
                                    _token: '{{ csrf_token() }}'
                                }
                            });

                            component.qrCodeId = ''

                            if (response.status && response.status == "error") {
                                component.notification('error', response.message, 'Error Scanning ID')
                                throw new Error(response.message)
                            }

                            var student = component.student_data;
                            var id_pic = response.enrollee_files.find(file => file.credential_type === 'id_picture');

                            student.name = `${response.user.fname} ${response.user.lname}`;
                            student.batch_name = `${response.batch.name}`;
                            student.course_code = `${response.batch.course.code}`;
                            student.attendance = response.enrollee_attendances;
                            console.log(student.attendance);

                            student.batch_id = response.batch.id;
                            student.id = response.id;
                            if (id_pic) {
                                student.id_pic =
                                    `{{ asset('storage/enrollee_files/') }}/${response.course_id}/${response.id}/id_picture/${id_pic.folder}/${id_pic.filename}`;
                            } else {
                                student.id_pic = null;
                            }


                            // Stop scanning after successful scan
                            await component.pauseScanning();
                            console.log("QR Code scanning stopped.");
                        } catch (err) {
                            console.error('Error generating ID card:', err);
                            return;
                            // alert('An error occurred while scanning the ID card.');
                        }
                    },

                    notification(status, message, title) {
                        status === 'success' ? toastr.success(message, title ?? title) : status == 'info' ? toastr.info(
                            message) : toastr.error(message, title ??
                            title);
                    },

                }
            }

            // $(document).ready(function() {
            //     function onScanSuccess(decodedText, decodedResult) {

            //         $.ajax({
            //             url: "{{ route('get_scan_data') }}",
            //             method: 'POST',
            //             data: {
            //                 qr_code: decodedText,
            //                 _token: '{{ csrf_token() }}'
            //             },
            //             success: function(response) {
            //                 scanStudent().student_data = {
            //                     name: `${response.user.fname} ${response.user.lname}`,
            //                 };

            //                 console.log(scanStudent().student_data);
            //             },
            //             error: function(xhr, status, error) {
            //                 console.error('Error generating ID card:', error
            // return;);
            //                 alert('An error occurred while scanning the ID card.');
            //             }
            //         });
            //     }

            //     function onScanError(errorMessage) {
            //         // Handle scan error
            //         // console.error(errorMessage);
            //     }

            //     const html5QrCode = new Html5Qrcode("qr-reader");

            //     // Start scanning with the default camera
            //     html5QrCode.start({
            //             facingMode: "environment"
            //         }, // Use rear camera
            //         {
            //             fps: 10, // Scans per second
            //             qrbox: 250 // QR scanning box size
            //         },
            //         onScanSuccess,
            //         onScanError
            //     ).catch(err => {
            //         // console.error(err);
            //     });
            // });
        </script>
    @endsection
</x-app-layout>
