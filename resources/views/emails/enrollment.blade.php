<x-mail::message>
    # Enrollment

    Dear {{ $data['name'] }},

    Thank you for submitting your enrollment for **{{ $data['course_name'] }}** at Language Skills Institute OrMin! We
    are
    excited to have you on board as you take the next step toward expanding your knowledge.

    ---

    ### What's Next?
    You will receive further instructions via email, phone, or Facebook message regarding the next steps in your
    enrollment process. Please keep an eye on your inbox and stay tuned for updates!

    ---

    ### Need Assistance?
    If you have any questions in the meantime, feel free to reach out to us through the following channels:

    **Phone**: [Contact Number]
    **Facebook**: [Facebook Account/Link]
    We’re happy to assist you with any inquiries you may have about your enrollment.

    Thank you again for choosing Language Skills Institute OrMin. We look forward to helping you achieve your learning
    goals!

    <x-mail::button :url="route('enrollment')">
        See Enrollment
    </x-mail::button>

    Best regards,
    {{ config('app.name') }}
</x-mail::message>
