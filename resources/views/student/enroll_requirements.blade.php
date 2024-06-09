<x-guest-layout>
    @php
        $student = App\Models\Enrollee::where('id', decrypt($enrollee))->first();
    @endphp
    <form id="upload_files" class="p-4 md:p-5" enctype="multipart/form-data" method="POST"
        action="{{ route('enroll_requirements_save') }}">
        @csrf
        <input type="hidden" name="enrollee_id" value="{{ $enrollee }}">
        <div class="col-span-2 mb-4">
            <div class="col-span-2 flex justify-between font-bold text-white">
                <div class="content-center">Enrollment Requirements</div>
                <button class="underlined col-span-1 rounded-md bg-white p-1 text-sm text-black" type="button"
                    onclick="seeFormats()">See Formats</button>
            </div>
            <div class="text-xs text-white">Click "See Formats" before uploading files</div>
        </div>

        <div class="visible mb-4 grid grid-cols-2 gap-4 text-white">
            <div class="col-span-2">
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-900 dark:text-white" for="id_picture">ID
                        Picture</label>
                    <div class="flex justify-center">
                        <input
                            class="block h-3 w-1/2 cursor-pointer rounded-lg border border-gray-300 bg-gray-50 text-sm text-gray-900 focus:outline-none dark:border-gray-600 dark:bg-gray-700 dark:text-gray-400 dark:placeholder-gray-400"
                            name="id_picture" id="id_picture" type="file" accept="image/*">
                    </div>
                </div>

            </div>

            <div class="col-span-2">
                <label class="block text-sm font-medium text-white">Valid
                    ID</label>
                <div class="mt-1.5 text-xs">(Front)</div>
                <input
                    class="block w-full cursor-pointer rounded-lg border border-gray-300 bg-gray-50 text-sm text-gray-900 focus:outline-none dark:border-gray-600 dark:bg-gray-700 dark:text-gray-400 dark:placeholder-gray-400"
                    name="valid_id_front" id="valid_id_front" type="file" accept="image/*">
                <div class="mt-1.5 text-xs">(Back)</div>

                <input
                    class="block w-full cursor-pointer rounded-lg border border-gray-300 bg-gray-50 text-sm text-gray-900 focus:outline-none dark:border-gray-600 dark:bg-gray-700 dark:text-gray-400 dark:placeholder-gray-400"
                    name="valid_id_back" id="valid_id_back" type="file" accept="image/*">
            </div>

            <div class="col-span-2">
                <label class="block text-sm font-medium text-gray-900 dark:text-white" for="diploma_tor">Diploma or
                    Transcript of Records</label>
                <input
                    class="block w-full cursor-pointer rounded-lg border border-gray-300 bg-gray-50 text-sm text-gray-900 focus:outline-none dark:border-gray-600 dark:bg-gray-700 dark:text-gray-400 dark:placeholder-gray-400"
                    name="diploma_tor" id="diploma_tor" type="file" accept="image/*">
            </div>

            <div class="col-span-2">
                <label class="block text-sm font-medium text-gray-900 dark:text-white" for="birth_certificate">Birth
                    Certificate</label>
                <input
                    class="block w-full cursor-pointer rounded-lg border border-gray-300 bg-gray-50 text-sm text-gray-900 focus:outline-none dark:border-gray-600 dark:bg-gray-700 dark:text-gray-400 dark:placeholder-gray-400"
                    name="birth_certificate" id="birth_certificate" type="file" accept="image/*">
            </div>

            <div class="col-span-2 justify-self-end">
                <x-primary-button id="step1_next" onclick="submitForm()" class="col-span-1 col-end-3 w-full text-white"
                    type="button">Submit</x-primary-button>
            </div>

        </div>
    </form>
    @section('script')
        <script>
            FilePond.registerPlugin(FilePondPluginImagePreview,
                FilePondPluginImageCrop,
                FilePondPluginImageTransform,
                FilePondPluginImageResize,
                FilePondPluginImageEdit,
            );
            const valid_id_front = document.querySelector('#valid_id_front');
            const valid_id_back = document.querySelector('#valid_id_back');
            const diploma = document.querySelector('#diploma_tor');
            const birth_certificate = document.querySelector('#birth_certificate');
            const id_pic = document.querySelector('#id_picture');
            var valid_frontPond = FilePond.create(valid_id_front, {
                labelIdle: `Drag & Drop a photo or <span class="filepond--label-action">Browse</span>`,
                allowReorder: true,
                allowImagePreview: true,
                @if ($valid_id_front)
                    files: [{
                        source: {{ $valid_id_front->id }},
                        options: {
                            type: 'local',
                        },
                    }, ],
                @endif
                server: {
                    process: {
                        url: '{{ route('upload_requirement') }}',
                        ondata: (formData) => {
                            formData.append('enrollee_id', '{{ $enrollee }}');
                            formData.append('course_id', '{{ encrypt($student->course_id) }}');
                            formData.append('credential_type', 'valid_id_front');
                            return formData;
                        },
                    },
                    load: '/load_requirement/{{ encrypt($student->id) }}/valid_id_front/',
                    revert: {
                        url: '{{ route('revert_requirement') }}',
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                    },
                    remove: (source, load, error) => {
                        fetch(`/delete_requirement/{{ encrypt($student->id) }}/valid_id_front/${source}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        }).then(response => {
                            if (response.ok) {
                                load();
                            } else {
                                error('Could not delete file');
                            }
                        }).catch(() => {
                            error('Could not delete file');
                        });
                    },
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                },


            });
            var valid_backPond = FilePond.create(valid_id_back, {
                labelIdle: `Drag & Drop a photo or <span class="filepond--label-action">Browse</span>`,
                allowReorder: true,
                allowImagePreview: true,
                @if ($valid_id_back)
                    files: [{
                        source: {{ $valid_id_back->id }},
                        options: {
                            type: 'local',
                        },
                    }, ],
                @endif
                server: {
                    process: {
                        url: '{{ route('upload_requirement') }}',
                        ondata: (formData) => {
                            formData.append('enrollee_id', '{{ $enrollee }}');
                            formData.append('course_id', '{{ encrypt($student->course_id) }}');
                            formData.append('credential_type', 'valid_id_back');
                            return formData;
                        },
                    },
                    load: '/load_requirement/{{ encrypt($student->id) }}/valid_id_back/',
                    revert: {
                        url: '{{ route('revert_requirement') }}',
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                    },
                    remove: (source, load, error) => {
                        fetch(`/delete_requirement/{{ encrypt($student->id) }}/valid_id_back/${source}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        }).then(response => {
                            if (response.ok) {
                                load();
                            } else {
                                error('Could not delete file');
                            }
                        }).catch(() => {
                            error('Could not delete file');
                        });
                    },
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                },

            });
            var diploma_pond = FilePond.create(diploma, {
                labelIdle: `Drag & Drop a file (pdf/photo) or <span class="filepond--label-action">Browse</span>`,
                allowReorder: true,
                allowImagePreview: true,
                @if ($diploma_tor)
                    files: [{
                        source: {{ $diploma_tor->id }},
                        options: {
                            type: 'local',
                        },
                    }, ],
                @endif
                server: {
                    process: {
                        url: '{{ route('upload_requirement') }}',
                        ondata: (formData) => {
                            formData.append('enrollee_id', '{{ $enrollee }}');
                            formData.append('course_id', '{{ encrypt($student->course_id) }}');
                            formData.append('credential_type', 'diploma_tor');
                            return formData;
                        },
                    },
                    load: '/load_requirement/{{ encrypt($student->id) }}/diploma_tor/',
                    revert: {
                        url: '{{ route('revert_requirement') }}',
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                    },
                    remove: (source, load, error) => {
                        fetch(`/delete_requirement/{{ encrypt($student->id) }}/diploma_tor/${source}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        }).then(response => {
                            if (response.ok) {
                                load();
                            } else {
                                error('Could not delete file');
                            }
                        }).catch(() => {
                            error('Could not delete file');
                        });
                    },
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                },

            });
            var birth_pond = FilePond.create(birth_certificate, {
                labelIdle: `Drag & Drop a file (pdf/photo) or <span class="filepond--label-action">Browse</span>`,
                allowReorder: true,
                allowImagePreview: true,
                @if ($birth_certificate)
                    files: [{
                        source: {{ $birth_certificate->id }},
                        options: {
                            type: 'local',
                        },
                    }, ],
                @endif
                server: {
                    process: {
                        url: '{{ route('upload_requirement') }}',
                        ondata: (formData) => {
                            formData.append('enrollee_id', '{{ $enrollee }}');
                            formData.append('course_id', '{{ encrypt($student->course_id) }}');
                            formData.append('credential_type', 'birth_certificate');
                            return formData;
                        },
                    },
                    load: '/load_requirement/{{ encrypt($student->id) }}/birth_certificate/',
                    revert: {
                        url: '{{ route('revert_requirement') }}',
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                    },
                    remove: (source, load, error) => {
                        fetch(`/delete_requirement/{{ encrypt($student->id) }}/birth_certificate/${source}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        }).then(response => {
                            if (response.ok) {
                                load();
                            } else {
                                error('Could not delete file');
                            }
                        }).catch(() => {
                            error('Could not delete file');
                        });
                    },
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                },
            });
            var id_pond = FilePond.create(id_pic, {
                allowImagePreview: true,
                allowDownloadByUrl: true,
                stylePanelLayout: 'compact circle',
                imageCropAspectRatio: '1:1',
                styleLoadIndicatorPosition: 'center bottom',
                styleProgressIndicatorPosition: 'right bottom',
                styleButtonRemoveItemPosition: 'left bottom',
                styleButtonProcessItemPosition: 'right bottom',
                @if ($id_picture)
                    files: [{
                        source: {{ $id_picture->id }},
                        options: {
                            type: 'local',
                        },
                    }, ],
                @endif
                server: {
                    process: {
                        url: '{{ route('upload_requirement') }}',
                        ondata: (formData) => {
                            formData.append('enrollee_id', '{{ $enrollee }}');
                            formData.append('course_id', '{{ encrypt($student->course_id) }}');
                            formData.append('credential_type', 'id_picture');
                            return formData;
                        },
                    },
                    load: '/load_requirement/{{ encrypt($student->id) }}/id_picture/',
                    revert: {
                        url: '{{ route('revert_requirement') }}',
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                    },
                    remove: (source, load, error) => {
                        fetch(`/delete_requirement/{{ encrypt($student->id) }}/id_picture/${source}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        }).then(response => {
                            if (response.ok) {
                                load();
                            } else {
                                error('Could not delete file');
                            }
                        }).catch(() => {
                            error('Could not delete file');
                        });
                    },
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                },
            });

            function submitForm() {
                $.ajax({
                    url: '{{ route('check_user_requirements') }}',
                    type: 'POST',
                    data: {
                        enrollee_id: '{{ $enrollee }}'
                    },
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.completed) {
                            $('#upload_files').submit();
                        } else {
                            alert('Please upload all the credentials')
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                        $('#result').text('An error occurred while checking credentials.');
                    }
                });
            }
        </script>
    @endsection
</x-guest-layout>
