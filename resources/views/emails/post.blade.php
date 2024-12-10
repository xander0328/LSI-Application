<x-mail::message>

    Your trainer, {{ $data['trainer'] }}, has posted a new message in the course stream for
    {{ $data['batch']['course']['name'] }}.
    <br><br>
    💬 Post Message: <br>
    {!! $data['post']['description'] !!}
    🗓️ Posted On: {{ \Carbon\Carbon::parse($data['post']['created_at'])->format('Y-m-d H:i') }} <br>

    @if ($data['type'] == 'update')
        🗓️ Updated On: {{ \Carbon\Carbon::parse($data['post']['updated_at'])->format('Y-m-d H:i') }}<br><br>
    @endif

    Stay updated and check the details of this announcement.
    <br>
    <x-mail::button :url="route('student.comments', ['batch_id' => $data['batch']['id'], 'post_id' => $data['post']['id']])">
        View Post
    </x-mail::button>

</x-mail::message>
