@props(['url'])
<tr>
    <td class="header">
        <a href="{{ $url }}" style="display: inline-block;">
            @if (trim($slot) === 'Laravel')
                <img src="https://laravel.com/img/notification-logo.png" class="logo" alt="Laravel Logo">
            @else
                {{-- {{ $slot }} --}}
                <img src="https://lsi-ekonek.online/images/elements/ekonek_logo.png" class="logo" alt="Laravel Logo"
                    style="display: block; max-width: 100%; height: auto;">
            @endif
        </a>
    </td>
</tr>
