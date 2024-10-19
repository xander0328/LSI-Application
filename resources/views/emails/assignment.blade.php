<x-mail::message>
    # {{ $data['batch'] }}

    Hi! Assignment titled {{ $data['title'] }} has been assigned to you in Basic English Language Learning. Please
    complete and submit it by the due date.

    Thanks,<br>
    {{ config('app.name') }}
</x-mail::message>
