<x-mail::message>
    <h2>
        {{ $data['batch']['course']['code'] . '-' . $data['batch']['name'] }}
    </h2>
    <br>
    This is to notify you that {{ $data['trainee'] }} has submitted their assignment for the
    {{ $data['batch']['course']['name'] }}
    {{ !$data['is_late'] ? 'on time' : ', but it was submitted after the due date' }} .
    <br><br>
    📝 Assignment Title: {{ $data['assignment']['title'] }} <br>
    📅 Submitted On: {{ $data['turn_in']['turned_in_date'] }} <br>
    ⏰ Due Date:
    {{ $data['assignment']['due_date'] == null ? 'None' : $data['assignment']['due_date'] . ' ' . $data['assignment']['due_hour'] }}
    <br><br>
    You can review the submission and provide feedback when convenient.

    <x-mail::button :url="route('list_turn_ins', $data['assignment']['id'])">
        View Turn Ins
    </x-mail::button>

</x-mail::message>
