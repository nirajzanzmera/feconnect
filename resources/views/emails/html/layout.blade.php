<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dataczar</title>
</head>
<body>
    <table cellpadding="10" cellspacing="0" class="head">
        <tr>
            <td>
                <img src="https://connect.dataczar.com/img/dataczar-logo.png" style="margin-left:10px; width: 200px; padding-top: 6px;"
                    alt="DATACZAR">
                <a href="https://connect.dataczar.com" style="margin-right:10px; float:right; padding:0;" class="button button-blue-small">Login</a>
            </td>
        </tr>
    </table>
    <div class=" wrapper">
       
        {{ Illuminate\Mail\Markdown::parse($slot) }}

    </div>

    <table cellpadding="10" cellspacing="0" class="footer">
        <tr>
            <td>
                <span class="copy">
                    &copy; {{ date('Y') }} DATACZAR, Inc. All rights reserved.
                </span>
            </td>
        </tr>
    </table>

</body>

</html>
