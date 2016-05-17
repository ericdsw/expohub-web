<!DOCTYPE html>
<html>
    <head>
        <title>Expo Hub</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                display: table;
                font-weight: 100;
                font-family: 'Lato';
                background: #673AB7;
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 96px;
                color: white;
            }
            .sub_title {
                font-size: 18px;
                color: #eee;
                margin-top: 8px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <div class="title">Expo Hub</div>
                <div class="sub_title">Plataforma de eventos</div>

                {{-- This section will display the MySQL database credentials --}}
                {{--<h2 style="color: white; text-align: center;">MySQL Database credentials</h2>--}}
                {{--<div style="text-align: left; width: 500px; display: inline-block; font-family: Helvetica; color: white;">--}}
                    {{--Host: {{ parse_url(getenv('CLEARDB_DATABASE_URL'))['host'] }} <br />--}}
                    {{--User: {{ parse_url(getenv('CLEARDB_DATABASE_URL'))['user'] }} <br />--}}
                    {{--Password: {{ parse_url(getenv('CLEARDB_DATABASE_URL'))['pass'] }} <br />--}}
                    {{--Database: {{ substr(parse_url(getenv('CLEARDB_DATABASE_URL'))['path'], 1) }} <br />--}}
                {{--</div>--}}

                {{-- This section will display the Postgress database credentials --}}
                {{--<h2 style="color: white; text-align: center;">Postgress Database credentials</h2>--}}
                {{--<div style="text-align: left; width: 500px; display: inline-block; font-family: Helvetica; color: white;">--}}
                    {{--Host: {{ parse_url(getenv('DATABASE_URL'))['host'] }} <br />--}}
                    {{--User: {{ parse_url(getenv('DATABASE_URL'))['user'] }} <br />--}}
                    {{--Password: {{ parse_url(getenv('DATABASE_URL'))['pass'] }} <br />--}}
                    {{--Database: {{ substr(parse_url(getenv('DATABASE_URL'))['path'], 1) }} <br />--}}
                {{--</div>--}}

            </div>
        </div>
    </body>

</html>
