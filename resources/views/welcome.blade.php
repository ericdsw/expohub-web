<!DOCTYPE html>
<html>
    <head>
        <title>{{ Lang::get('strings.app_name') }}</title>

        <link href='https://fonts.googleapis.com/css?family=Lato:100' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Roboto+Mono' rel='stylesheet' type='text/css'>

        <link rel="stylesheet" href="{{ elixir('css/front-page.css') }}" />

    </head>
    <body>
        <div class="container">
            <div class="content">
                <div class="title weak-text">{{ Lang::get('strings.app_name') }}</div>
                <div class="sub_title weak-text">{{ Lang::get('strings.app_subtitle') }}</div>

                <a style="font-family:'Roboto Mono', Monospace; margin-top: 32px;" href="{{ url('api-explorer') }}" role="button" class="btn btn-primary btn-raised">
                    Api Explorer
                </a>

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
