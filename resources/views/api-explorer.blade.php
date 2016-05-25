<!DOCTYPE html>
<html>
<head>
    <title>{{ Lang::get('strings.app_name') }}</title>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

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
        <div class="card-header">

            <h4>{{ Lang::get('strings.api_explorer_title') }}</h4>

            <form @submit.prevent="queryApi">

                <div style="display: table; width: 100%; margin-top: 0px; vertical-align: middle;">

                    <div class="form-group label-floating"
                         style="display: table-cell !important; width: auto; padding-right: 16px; vertical-align: middle;">

                        <input id="api-endpoint"
                               v-model="apiEndpoint"
                               placeholder="{{ Lang::get('strings.api_explorer_placeholder') }}"
                               id="first_name" type="text" class="form-control">

                    </div>

                    <div style="display: table-cell !important; width: 80px;">
                        <button class="btn btn-raised btn-primary" type="submit" name="action">
                            Ver &nbsp;
                            <i style="font-size: 14px;" class="material-icons right">send</i>
                        </button>
                    </div>
                </div>

            </form>

        </div>
        <pre>@{{ jsonMessage | json }}</pre>
        <a id="info-button" data-toggle="modal" data-target="#instructions-modal" class="btn btn-primary btn-fab">
            <i class="material-icons">help</i>
        </a>
    </div>

</div>

<!-- Modal -->
@include('sub_views.instructions_modal')

<script src="{{ elixir('js/vendor.js') }}"></script>

<script>

    // Initialize bootstrap material
    $.material.init()

    // Main Vue element
    new Vue({

        el : '#main-card',

        data : {
            apiEndpoint : '',
            jsonMessage : "Por favor especifique un endpoint para mostrar su contenido",
            apiToken    : '',
        },

        ready : function() {
            this.apiToken = $('meta[name="api-token"]').attr('content');
        },

        methods : {

            queryApi : function() {

                $.ajax({
                    url         : 'api/v1/' + this.apiEndpoint,
                    type        : 'GET',
                    dataType    : 'json',

                    success     : function(data) {
                        this.jsonMessage = data;
                    }.bind(this),

                    error       : function(response, textStatus, errorThrown) {
                        this.jsonMessage = JSON.parse(response.responseText);
                    }.bind(this),

                    beforeSend  : function(request) {
                        request.setRequestHeader('x-api-authorization', this.apiToken);
                    }.bind(this)

                })

            }
        }

    });

</script>

</body>

</html>
