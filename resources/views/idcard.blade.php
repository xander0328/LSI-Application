<!DOCTYPE html>
<html>

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ID Card</title>
    <style>
        @font-face {
            font-family: 'Poppins';
            src: url('{{ public_path('fonts/Poppins-Regular.ttf') }}') format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        @font-face {
            font-family: 'Poppins';
            src: url('{{ public_path('fonts/Poppins-Medium.ttf') }}') format('truetype');
            font-weight: 500;
            font-style: normal;
        }

        @font-face {
            font-family: 'Poppins';
            src: url('{{ public_path('fonts/Poppins-Light.ttf') }}') format('truetype');
            font-weight: 100;
            font-style: normal;
        }

        html {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
        }

        body {
            background-image: url('{{ public_path('storage/website/course_id/id_1.png') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
    </style>
</head>

<body>
    <div style="padding-left:101px;">
        <table style="border-collapse:collapse ;width: 100%">
            <tr>
                <td colspan="2" style="text-align: center;padding-top: 99px;">
                    <img style="border-radius: 100%;"
                        src="{{ public_path('storage/enrollee_files/16/14/id_picture/ass6651a3640812f8.15701964/1716626276_4.png') }}"
                        alt="Student Picture" width="200">
                </td>
            </tr>
            <tr style="text-transform: uppercase">
                <td colspan="2" style="text-align: center;padding-top: 15px;line-height: 0.6; ">
                    <div style="font-size: 50px; padding: 0px;margin:0px;font-weight: 500;">
                        {{ auth()->user()->lname }}
                    </div>
                    <div style="font-size:30px; padding: 0px;margin:0px;font-weight: 100; color: rgb(31 41 55);">
                        {{ auth()->user()->fname }}
                    </div>

                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center; padding: 0px;">
                    <span style="background-color: rgba(0, 0, 0, 0.1); padding: 0 3px 5px 5px; border-radius: 5px ">
                        Batch:
                    </span>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center; padding-top: 30px;">
                    <img style="border-radius: 30px" src="data:image/png;base64, {!! $qr_code->qr_code !!}" alt="QR Code"
                        width="300" height="300">
                </td>
            </tr>
        </table>
    </div>
</body>

</html>
