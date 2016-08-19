<!DOCTYPE html>
<html>
<head>
    <title>{{ Lang::get('strings.app_name') }}</title>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @include('sub_views/favicons')

    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Roboto+Mono' rel='stylesheet' type='text/css'>

    <link rel="stylesheet" href="{{ elixir('css/app.css') }}" />
    <link rel="stylesheet" href="{{ elixir('css/api-explorer.css') }}" />

    <meta name="api-token" content="{{ env('API_EXPLORER_TOKEN', '') }}" />

</head>
<body>
<nav class="material-nav"></nav>
<div class="container">
    <div id="main-card" class="card-panel purple lighten-5 z-depth-3 well">

        <!-- Header -->
        <div class="card-header">

            <h4>{{ Lang::get('strings.api_explorer_title') }}</h4>

            <form @submit.prevent="queryApi">

                    <div class="header-content">

                    <div class="form-group label-floating header-content-cell"
                         style="width: auto; padding-right: 16px; vertical-align: middle;">

                        <input id="api-endpoint"
                               v-model="apiEndpoint"
                               placeholder="{{ Lang::get('strings.api_explorer_placeholder') }}"
                               id="first_name" type="text" class="form-control">

                    </div>

                    <div class="header-content-cell" style="width: 80px;">
                        <button class="btn btn-raised btn-primary" type="submit" name="action">
                            Ver &nbsp;
                            <i style="font-size: 14px;" class="material-icons right">send</i>
                        </button>
                    </div>
                </div>

            </form>

        </div>

        <!-- Content -->
        <pre>@{{ jsonMessage | json }}</pre>

        <!-- Info Button -->
        <a id="info-button" data-toggle="modal" data-target="#instructions-modal" class="btn btn-primary btn-fab">
            <i class="material-icons">help</i>
        </a>

    </div>

</div>

<!-- Modal -->
@include('sub_views.instructions_modal')

<script src="{{ elixir('js/vendor.js') }}"></script>
<script src="{{ elixir('js/api-explorer.js') }}"></script>

</body>

</html>
