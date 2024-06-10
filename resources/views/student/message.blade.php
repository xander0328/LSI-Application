<x-app-layout>
    <div class="relative h-screen">
        <div class="absolute left-0 right-0 top-14 z-10">
            <div class="my-2 bg-gray-800 p-3">
                <div class="flex items-center gap-4">
                    <div
                        class="relative inline-flex h-10 w-10 items-center justify-center overflow-hidden rounded-full bg-gray-100 dark:bg-gray-600">
                        <span
                            class="font-medium text-gray-600 dark:text-gray-300">{{ substr($user[0]->fname, 0, 1) }}{{ substr($user[0]->lname, 0, 1) }}</span>
                    </div>
                    <div class="font-medium dark:text-white">
                        <div>{{ $user[0]->fname }} {{ $user[0]->lname }}</div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">
                            {{ $user[0]->role == 'superadmin' ? 'LSI Admin' : ucwords($user[0]->role) }}</div>
                    </div>
                </div>
                <div>
                    <button onclick="startFCM()" class="btn btn-danger btn-flat">Allow notification
                    </button>
                </div>
                {{-- @php
                    print_r($user[0]->id);
                @endphp --}}
            </div>
        </div>
        <div id="chatContainer" class="relative h-full content-end pb-14 pt-32">
            <div id="chatsHolder" class="flex h-full flex-col-reverse overflow-y-auto py-2">
                {{-- @if (isset($messages))
                    @php
                        $prev_time = Carbon\Carbon::parse(today());
                    @endphp
                    @foreach ($messages as $message)
                        @php
                            $date = Carbon\Carbon::parse($message->created_at);
                        @endphp
                        @if (auth()->user()->id != $message->sender_id)
                            <div class="mb-1 ms-2 mt-1 flex items-start gap-2.5">
                                <div
                                    class="leading-1.5 flex w-full max-w-[320px] flex-col rounded-e-xl rounded-es-xl border-gray-200 bg-gray-100 p-4 dark:bg-gray-700">
                                    <div class="flex items-center space-x-2 rtl:space-x-reverse">
                                        <span
                                            class="text-xs font-normal text-gray-500 dark:text-gray-400">{{ $date->isToday() ? $date->format('h:i A') : $date->format('m/d/Y h:i A') }}</span>
                                    </div>
                                    <p class="py-2.5 text-sm font-normal text-gray-900 dark:text-white">
                                        {{ $message->message_content }}</p>
                                </div>
                            </div>
                        @else
                            <div class="mb-1 me-2 mt-1 gap-2.5">
                                <div class="flex flex-row-reverse items-start">
                                    <div
                                        class="leading-1.5 flex max-w-[320px] flex-col rounded-bl-xl rounded-br-xl rounded-tl-xl border-gray-200 bg-gray-100 p-4 dark:bg-gray-700">
                                        <p class="text-sm font-normal text-gray-900 dark:text-white">
                                            {{ $message->message_content }}</p>
                                    </div>
                                </div>
                                @if ($prev_time != $date)
                                    <div class="flex flex-row-reverse items-center">
                                        <span
                                            class="text-xs font-normal text-gray-500 dark:text-gray-400">{{ $date->isToday() ? $date->format('h:i A') : $date->format('m/d/Y h:i A') }}</span>
                                    </div>
                                @endif
                                @php
                                    $prev_time = $date;
                                @endphp
                            </div>
                        @endif
                    @endforeach
                @endif --}}
            </div>

        </div>

        <form id="sendMessageForm" class="absolute bottom-0 left-0 right-0" method="POST"
            action="{{ route('send_message') }}">
            @csrf
            <input type="hidden" name="user1_id" value="{{ auth()->user()->id }}">
            <input type="hidden" name="user2_id" value="{{ $user[0]->id }}">
            <label for="chat" class="sr-only">Your message</label>
            <div class="flex items-center bg-gray-50 px-3 py-2 dark:bg-gray-700">
                <textarea @keyup.enter="send_message()" name="message_content" id="chat" rows="1"
                    class="scroll-hide min-h-10 mx-4 block max-h-16 w-full resize-y rounded-lg border border-gray-300 bg-white p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                    placeholder="Your message..."></textarea>
                <button type="button" onclick="send_message()"
                    class="inline-flex cursor-pointer justify-center rounded-full p-2 text-blue-600 hover:bg-blue-100 dark:text-blue-500 dark:hover:bg-gray-600">
                    <svg class="h-5 w-5 rotate-90 rtl:-rotate-90" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        fill="currentColor" viewBox="0 0 18 20">
                        <path
                            d="m17.914 18.594-8-18a1 1 0 0 0-1.828 0l-8 18a1 1 0 0 0 1.157 1.376L8 18.281V9a1 1 0 0 1 2 0v9.281l6.758 1.689a1 1 0 0 0 1.156-1.376Z" />
                    </svg>
                    <span class="sr-only">Send message</span>
                </button>
            </div>
        </form>
    </div>
    @section('script')
        <script src="https://www.gstatic.com/firebasejs/8.3.2/firebase.js"></script>
        <script>
            $(document).ready(function() {
                var scrollContainer = $('#chatsHolder');
                scrollContainer.scrollTop(scrollContainer.prop('scrollHeight'));
            });

            function send_message() {
                var formData = $('#sendMessageForm').serialize();
                $('#chat').val('');
                $.ajax({
                    url: $('#sendMessageForm').attr('action'),
                    type: 'POST',
                    data: formData,
                    success: function(data) {
                        // Handle success response
                        console.log('token:' + data.message);
                    },
                    error: function(xhr, status, error) {
                        // Handle errors
                        // console.log($('#sendMessageForm').attr('action'));
                        console.error('Error:', error);
                    }
                });
            }

            // $(document).ready(function() {
            //     $('#chat').keypress(function(event) {
            //         if (event.keyCode === 13 && !event.shiftKey) {
            //             // Prevent the default behavior of the Enter key (e.g., inserting a newline)
            //             event.preventDefault();

            //             // Call your custom function
            //             sendMessage();
            //         }
            //     });
            // });

            //GET ALL MESSAGE

            var messages_numbers;
            $(document).ready(function() {
                function getMessages() {
                    $.ajax({
                        url: "{{ route('get_messages', $user[0]->id) }}",
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            // Clear previous messages

                            var size = 0;
                            for (var i in data['message']) {
                                if (data['message'].hasOwnProperty(i)) {
                                    size++;
                                }
                            }

                            var user1_lastTime = '';
                            var user2_lastTime = '';

                            if (size !== messages_numbers) {
                                messages_numbers = size
                                $('#chatsHolder').empty();
                                for (var i = size - 1; i >= 0; i--) {
                                    var message = data['message'][i];
                                    var messageHtml = '';

                                    if (message.sender_id != {{ auth()->user()->id }}) {
                                        // Message sent by other user
                                        messageHtml += '<div class="mb-px me-2 mx-2 mt-1 gap-2.5">';
                                        messageHtml += '<div class="flex items-start">';
                                        messageHtml +=
                                            '<div class="leading-1.5 flex max-w-[320px] flex-col rounded-bl-xl rounded-br-xl rounded-tr-xl border-gray-200 bg-gray-100 p-2.5 dark:bg-gray-700">';
                                        messageHtml +=
                                            '<p class="text-sm font-normal text-gray-900 dark:text-white">' +
                                            message.message_content + '</p>';
                                        messageHtml += '</div>';
                                        messageHtml += '</div>';
                                        // Check if timestamp should be displayed
                                        if (i === size - 1 || moment(message.created_at).format(
                                                'MM/DD/YY h:mm A') !== moment(data['message'][i + 1]
                                                .created_at).format('MM/DD/YY h:mm A')) {
                                            messageHtml +=
                                                '<div class="flex items-center">'

                                            if (moment(message.created_at).format(
                                                    'MM/DD/YY') !== moment().format('MM/DD/YY')) {
                                                messageHtml +=
                                                    '<span class="text-xs mb-px font-normal text-gray-500 dark:text-gray-400">' +
                                                    moment(message.created_at).format('MM/DD/YY h:mm A') +
                                                    '</span>';
                                            } else {
                                                messageHtml +=
                                                    '<span class="text-xs mb-px font-normal text-gray-500 dark:text-gray-400">' +
                                                    moment(message.created_at).format('h:mm A') +
                                                    '</span>';
                                            }

                                            messageHtml += '</div>';
                                        } else if (message.sender_id != data['message'][i + 1].sender_id) {
                                            if (moment().format('MM/DD/YY') !== moment(message.created_at)
                                                .format(
                                                    'MM/DD/YY')) {
                                                messageHtml +=
                                                    '<span class="text-xs mb-px font-normal text-gray-500 dark:text-gray-400">' +
                                                    moment(message.created_at).format('MM/DD/YY h:mm A') +
                                                    '</span>';
                                            } else {
                                                messageHtml +=
                                                    '<span class="text-xs mb-px font-normal text-gray-500 dark:text-gray-400">' +
                                                    moment(message.created_at).format('h:mm A') +
                                                    '</span>';
                                            }
                                            messageHtml += '</div>';
                                        }
                                        messageHtml += '</div>';
                                    } else {
                                        // Message sent by current user
                                        messageHtml += '<div class="mb-px me-2 mt-1 gap-2.5">';
                                        messageHtml += '<div class="flex flex-row-reverse items-start">';
                                        messageHtml +=
                                            '<div class="leading-1.5 flex max-w-[320px] flex-col rounded-bl-xl rounded-br-xl rounded-tl-xl border-gray-200 bg-sky-700 p-2.5">';
                                        messageHtml +=
                                            '<p class="text-sm font-normal text-gray-900 dark:text-white">' +
                                            message.message_content + '</p>';
                                        messageHtml += '</div>';
                                        messageHtml += '</div>';
                                        // Check if timestamp should be displayed
                                        if (i === size - 1 || moment(message.created_at).format(
                                                'MM/DD/YY h:mm A') !== moment(data['message'][i + 1]
                                                .created_at).format('MM/DD/YY h:mm A')) {
                                            messageHtml +=
                                                '<div class="flex flex-row-reverse items-center">';
                                            if (moment().format('MM/DD/YY') !== moment(message.created_at)
                                                .format(
                                                    'MM/DD/YY')) {
                                                messageHtml +=
                                                    '<span class="text-xs mb-px font-normal text-gray-500 dark:text-gray-400">' +
                                                    moment(message.created_at).format('MM/DD/YY h:mm A') +
                                                    '</span>';
                                            } else {
                                                messageHtml +=
                                                    '<span class="text-xs mb-px font-normal text-gray-500 dark:text-gray-400">' +
                                                    moment(message.created_at).format('h:mm A') +
                                                    '</span>';
                                            }

                                        } else if (message.sender_id != data['message'][i + 1].sender_id) {
                                            messageHtml +=
                                                '<div class="flex flex-row-reverse items-center">';
                                            if (moment().format('MM/DD/YY') !== moment(message.created_at)
                                                .format(
                                                    'MM/DD/YY')) {
                                                messageHtml +=
                                                    '<span class="text-xs mb-px font-normal text-gray-500 dark:text-gray-400">' +
                                                    moment(message.created_at).format('MM/DD/YY h:mm A') +
                                                    '</span>';
                                            } else {
                                                messageHtml +=
                                                    '<span class="text-xs mb-px font-normal text-gray-500 dark:text-gray-400">' +
                                                    moment(message.created_at).format('h:mm A') +
                                                    '</span>';
                                            }
                                            messageHtml += '</div>';
                                        }
                                        messageHtml += '</div>';
                                    }

                                    if (i === size - 1 || moment(message.created_at).format(
                                            'MM/DD/YY') !== moment(
                                            data['message'][i + 1].created_at)
                                        .format('MM/DD/YY')) {

                                        // messageHtml +=
                                        //     '<div class="text-center text-white text-xs"> ' + moment(
                                        //         message.created_at).calendar() +
                                        //     ' </div>';
                                    }

                                    console.log(message.id + ' ' + message.message_content);

                                    $('#chatsHolder').append(messageHtml);
                                }
                            }

                        },
                        error: function(xhr, status, error) {
                            console.error('Error fetching messages: ' + error);
                        }
                    });
                }

                // Initial fetch
                getMessages();

                // Poll every 3 seconds
                setInterval(getMessages, 3000);
            });

            var firebaseConfig = {
                apiKey: "AIzaSyBi4oNVlyHAk6hdk42V7XugS_eR8_ianVw",
                authDomain: "lsi-app-541ad.firebaseapp.com",
                projectId: "lsi-app-541ad",
                storageBucket: "lsi-app-541ad.appspot.com",
                messagingSenderId: "740784195857",
                appId: "1:740784195857:web:01c322ecbcf6cc18bda4b0"
            };
            firebase.initializeApp(firebaseConfig);
            const messaging = firebase.messaging();

            function startFCM() {
                messaging
                    .requestPermission()
                    .then(function() {
                        return messaging.getToken()
                    })
                    .then(function(response) {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            url: '{{ route('store.token') }}',
                            type: 'POST',
                            data: {
                                token: response
                            },
                            dataType: 'JSON',
                            success: function(response) {
                                alert('Token stored.');
                            },
                            error: function(error) {
                                alert(error);
                            },
                        });
                    }).catch(function(error) {
                        alert(error);
                    });
            }
            messaging.onMessage(function(payload) {
                const title = payload.notification.title;
                const options = {
                    body: payload.notification.body,
                    icon: payload.notification.icon,
                };
                new Notification(title, options);
            });
        </script>
    @endsection

</x-app-layout>
