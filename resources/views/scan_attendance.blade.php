<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between text-white">
            <div class="text-2xl font-semibold text-white">
                {{ __('Attendance') }} <span class="text-slate-600">
            </div>
        </div>
        {{-- <x-course-nav :selected="'attendance'" :batch="$batch->id"></x-course-nav> --}}

    </x-slot>
    <div x-data="scanStudent()" class="mx-8 mt-2 grid h-full grid-cols-2 gap-3 pt-44 align-middle text-white">
        <div class="p-4" id="qr-reader"></div>
        <div class="p-4 ps-8">
            <template x-if="Object.keys(student_data).length = 0">
                <div>Scan ID QR code</div>
            </template>
            <template x-if="Object.keys(student_data).length > 0">
                <div class="grid justify-items-center">
                    <img class="w-48 rounded-full border-sky-700" :src="student_data.id_pic" alt="">
                    <div class="text-lg font-bold" x-text="student_data.name"></div>
                    <div class="text-sm" x-text="student_data.batch_name"></div>
                    <div class="mt-2 w-full">
                        <div @click="handleButtonClick('present')" class="mb-1.5">
                            <button class="w-full rounded-md bg-sky-700 p-2 text-center text-sm hover:bg-sky-800">Accept
                                as
                                Present</button>
                        </div>
                        <div @click="handleButtonClick('late')" class="mb-1.5">
                            <button
                                class="w-full rounded-md bg-yellow-700 p-2 text-center text-sm hover:bg-yellow-800">Accept
                                as
                                Late</button>
                        </div>
                        <div @click="handleButtonClick('decline')" class="mb-1.5">
                            <button
                                class="w-full rounded-md bg-orange-700 p-2 text-center text-sm hover:bg-orange-800">Decline</button>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>
    @section('script')
        <script>
            function scanStudent() {
                return {
                    student_data: {},
                    qrCodeScanner: null,
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
                                    fps: 10,
                                    qrbox: {
                                        width: 250,
                                        height: 250
                                    },
                                }, // QR scanning box size
                                this.onScanSuccess.bind(this),
                                this.onScanError.bind(this)
                            );
                        } catch (err) {
                            console.error(err);
                        }
                    },
                    async pauseScanning() {
                        try {
                            this.qrCodeScanner.pause();
                            console.log("QR Code scanning paused.");
                        } catch (err) {
                            console.error("Unable to pause scanning:", err);
                        }
                    },
                    async resumeScanning() {
                        try {
                            await this.qrCodeScanner.resume();
                            console.log("QR Code scanning resumed.");
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
                                        alert(response.status);
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

                        try {
                            const response = await $.ajax({
                                url: "{{ route('get_scan_data') }}",
                                method: 'POST',
                                data: {
                                    qr_code: decodedText,
                                    _token: '{{ csrf_token() }}'
                                }
                            });

                            var student = component.student_data;
                            var id_pic = response.enrollee_files.find(file => file.credential_type === 'id_picture');
                            student.name = `${response.user.fname} ${response.user.lname}`;
                            student.batch_name = `${response.batch.name}`;
                            student.batch_id = response.batch.id;
                            student.id = response.id;
                            student.id_pic =
                                `{{ asset('storage/enrollee_files/') }}/${response.course_id}/${response.id}/id_picture/${id_pic.folder}/${id_pic.filename}`;

                            console.log(component.student_data);
                            console.log(response);

                            // Stop scanning after successful scan
                            await component.pauseScanning();
                            console.log("QR Code scanning stopped.");
                        } catch (err) {
                            console.error('Error generating ID card:', err);
                            // alert('An error occurred while scanning the ID card.');
                        }
                    },
                    onScanError(errorMessage) {
                        // Handle scan error
                        // console.error(errorMessage);
                    }
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
            //                 console.error('Error generating ID card:', error);
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
