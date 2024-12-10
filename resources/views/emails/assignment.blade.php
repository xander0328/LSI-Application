<x-mail::message>

    <div style="font: bold">
        {{ $data['batch'] }}
    </div>
    <br>
    @if ($data['type'] == 'new')
        Your instructor has posted a new assignment.
    @else
        We wanted to inform you that your instructor has made updates to an assignment
    @endif
    <br><br>
    📝 Assignment Title: {{ $data['title'] }} <br>
    📅 Due Date:
    {{ $data['assignment_details']['due_date'] == null ? 'None' : $data['assignment_details']['due_date'] }}
    <br><br>
    @if ($data['type'] == 'new')
        Please review and complete the assignment before the due date.
    @else
        Please review the updated assignment details to ensure you stay on track.
    @endif
    <br><br>
    To view the assignment, click the button below:

    <div>
        <x-mail::button :url="$data['link']">
            View Assignment
        </x-mail::button>
    </div>

    If you have any questions or need assistance, feel free to reach out to your instructor.
    Thank you, and best of luck with your work!
</x-mail::message>
