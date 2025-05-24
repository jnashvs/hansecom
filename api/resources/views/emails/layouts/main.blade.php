<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? config('app.name') }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            max-width: 640px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 64px 87px;
            margin-top: 40px;
            margin-bottom: 40px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            padding: 10px 0;
        }

        h1 {
            font-size: 24px;
            margin: 0;
            color: #333;
        }

        p {
            font-size: 14px;
            font-style: normal;
            font-weight: 400;
            line-height: 160%;
            margin-bottom: 24px;
        }

        .content {
            padding: 20px 0;
        }

        .footer {
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid #dddddd;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            @include('emails.partials.header')
        </div>
        <div class="content">
            @yield('content')
        </div>
        <div class="footer">
            @include('emails.partials.footer')
        </div>
    </div>
</body>

</html>
