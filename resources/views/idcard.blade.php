<!DOCTYPE html>
<html>

<head>
    <title>ID Card</title>
    <style>
        body {
            font-family: Montserrat, sans-serif;
            margin: 0;
            padding: 0;
        }
    </style>
</head>

<body>
    <table style="width: 100%; height: 100%;">
        <tr>
            <td align="center" style="width: 50%; vertical-align: middle; padding: 5px;">
                <img src="{{ public_path('images/icons/lsi-main-logo.png') }}" alt="LSI" width="30px">
            </td>
            <td align="start" style="width: 50%; vertical-align: middle; padding: 5px;">
                <img src="{{ public_path('images/icons/lsi-logo.png') }} " alt="Ekonek" width="110px">
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center;padding-top: 500px;">
                <img style="border-radius: 100%;"
                    src="{{ asset('storage/enrollee_files/16/14/id_picture/ass6651a3640812f8.15701964/1716626276_4.png', 'public') }}"
                    alt="Student Picture" width="100">
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center; padding: 5px; font-weight: bold;">
                {{ auth()->user()->fname . ' ' . auth()->user()->lname }}
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center; padding: 5px;">
                Batch Name: COMP-0001
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center; padding: 10px;">
                <img src="data:image/png;base64, {!! $qr_code->qr_code !!}" alt="QR Code" width="150" height="150">
            </td>
        </tr>
    </table>
</body>

</html>
