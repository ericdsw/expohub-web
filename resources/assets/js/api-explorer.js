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

                success : function(data) {
                    this.jsonMessage = data;
                }.bind(this),

                error : function(response, textStatus, errorThrown) {
                    this.jsonMessage = JSON.parse(response.responseText);
                }.bind(this),

                beforeSend : function(request) {
                    request.setRequestHeader('x-api-authorization', this.apiToken);
                }.bind(this)

            })

        }
    }

});
