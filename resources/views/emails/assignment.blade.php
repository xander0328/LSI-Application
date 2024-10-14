<x-mail::message>
    # Introduction

    Hi! Your instructor just posted a new assignment.

    <h2>{{}}</h2>
    <p></p>

    <x-mail::button :url="{{ $data['link'] }}">
        View Assignment
    </x-mail::button>

    {{ config('app.name') }}
</x-mail::message>
