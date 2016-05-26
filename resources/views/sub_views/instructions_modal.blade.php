<div id="instructions-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <p style="font-size: 18px;" class="modal-title">Guía de uso del API</p>
            </div>
            <div class="modal-body">

                <ul class="nav nav-pills nav-justified">
                    <li class="active"><a data-toggle="tab" href="#general">General</a></li>
                    <li><a data-toggle="tab" href="#parameters">Parámetros</a></li>
                    <li><a data-toggle="tab" href="#relations">Relaciones</a></li>
                </ul>

                <div class="tab-content" style="margin-top: 16px;">

                    <div class="tab-pane fade in active" id="general">
                        <p>Los siguientes recursos están expuestos por endpoints con su mismo nombre:</p>
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Endpoint</th>
                                <th>Recurso</th>
                            </tr>
                            </thead>
                            <tbody>

                            <tr>
                                <td><code>fairs</code></td>
                                <td>Ferias registradas en el sistema</td>
                            </tr>
                            <tr>
                                <td><code>fairEvents</code></td>
                                <td>Eventos registrados en las ferias del sistema</td>
                            </tr>
                            <tr>
                                <td><code>categories</code></td>
                                <td>Categorías registradas en el sistema</td>
                            </tr>
                            <tr>
                                <td><code>maps</code></td>
                                <td>Mapas de ferias registrados en el sistema</td>
                            </tr>
                            <tr>
                                <td><code>stands</code></td>
                                <td>Stands participantes en las ferias del sistema</td>
                            </tr>
                            <tr>
                                <td><code>news</code></td>
                                <td>Noticias registradas en las ferias del sistema</td>
                            </tr>
                            <tr>
                                <td><code>sponsors</code></td>
                                <td>Patrocinadores de las ferias del sistema</td>
                            </tr>
                            <tr>
                                <td><code>speakers</code></td>
                                <td>Expositores registrados a los eventos del sistema</td>
                            </tr>
                            <tr>
                                <td><code>comments</code></td>
                                <td>Comentarios registrados a las noticias del sistema</td>
                            </tr>
                            </tbody>
                        </table>
                        <p>
                            Cada endpoint permite ser consultado directamente, o permite consultar un recurso en
                            específico proporcionando un id al url (ejemplo: <code>fairs/1</code> regresará solo la feria con id de 1).
                        </p>

                    </div>

                    <div class="tab-pane fade in" id="parameters">
                        <p>
                            Toda consulta realizada mediante el verbo HTTP <code>GET</code> puede llevar los siguientes
                            parámetros mediante un URL query, los cuales modificaran el resultado mostrado:
                        </p>
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Parámetro</th>
                                <th>Descripción</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td><code>include=<i>resource,resource2...</i></code></td>
                                <td>
                                    Incluirá información de los recursos especificados que estén relacionados
                                    con el recurso original consultado.
                                </td>
                            </tr>
                            <tr>
                                <td><code>sort=<i>field1,field2...</i></code></td>
                                <td>
                                    Ordenará los resultados de acuerdo a los campos especificados de manera ascendente.
                                    <br>
                                    El orden tomará prioridad de izquierda a derecha para los campos proporcionados, y
                                    para ordenar de manera descendiente, especifique el símbolo <code>-</code> antes del parámetro.
                                </td>
                            </tr>
                            <tr>
                                <td><code>page[limit]=<i>pl</i>&page[cursor]=<i>pc</i></code></td>
                                <td>
                                    Mostrará solo un set de los resultados obtenidos, empezando desde el elemento
                                    en la posición <code><i>pl</i></code> de la lista hasta <code><i>pc</i></code>
                                    elementos más adelante (offset). La respuesta incluirá información del offset y límite actual.
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade in" id="relations">
                        <p>
                            Cuando un recurso está relacionado con múltiples instancias de otros recursos, estos pueden ser
                            consultados agregando el nombre del recurso relacionado al url de la consulta por id.
                            <br /> <br />
                            <b>Ejemplo:</b> Una feria está relacionada a múltiples eventos, por lo cual se puede realizar una consulta a
                            <code>fairs/1/fairEvents</code> para obtener todos los eventos correspondientes a la feria con id de 1.
                            <br><br>
                            Las relaciones disponibles (en formato <code>recurso/{id}/sub-recurso</code>) son:
                        </p>
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Recurso</th>
                                <th>Sub-Recursos</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td><code>fairs</code></td>
                                <td>
                                    <code>sponsors</code>
                                    <code>maps</code>
                                    <code>categories</code>
                                    <code>fairEvents</code>
                                    <code>news</code>
                                    <code>stands</code>
                                </td>
                            </tr>
                            <tr>
                                <td><code>fairEvents</code></td>
                                <td>
                                    <code>speakers</code>
                                    <code>attendingUsers</code>
                                    <code>categories</code>
                                </td>
                            </tr>
                            <tr>
                                <td><code>categories</code></td>
                                <td>
                                    <code>fairEvents</code>
                                </td>
                            </tr>
                            <tr>
                                <td><code>news</code></td>
                                <td><code>comments</code></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>

    </div>
</div>