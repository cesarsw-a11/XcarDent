<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Odontograma</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <link rel="stylesheet" href="<?= base_url("estilos/odontograma.css") ?>" />
    <?php $this->load->view("head") ?>
    <script src="<?= base_url("assets/scripts/pincel.js") ?>"></script>
    <script src="<?= base_url("assets/scripts/odontograma.js") ?>"></script>
</head>

<body class="dark-mode">
    <div id="control" class="container">
        <h1 style="text-align: center;align-items: center;">ODONTOGRAMA : <?= $nombre ?></h1>
        <input type="text" id="paciente" value="<?= $idPaciente ?>" hidden>
        <!-- <div class="row">
            <div class="col-sm">
                <div class="col-md-12 mb-3">
                    <label for="">Nombre del Paciente:</label>
                    <input type="text" class="form-control" id="" placeholder="" value="<?= $nombre  ?>" disabled>
                </div>
                <div class="col-md-12 mb-3">
                    <label for="lastName">Edad</label>
                    <input type="text" class="form-control" id="lastName" placeholder="" value="<?= $edad ?>" disabled>
                </div>
            </div>
            <div class="col-sm">
                <div class="col-md-12 mb-3">
                    <label for="">Sexo:</label>
                    <input type="text" class="form-control" id="" placeholder="" value="<?= $sexo  ?>" disabled>
                </div>
                <div class="col-md-12 mb-3">
                    <label for="lastName">Procedencia</label>
                    <input type="text" class="form-control" id="lastName" placeholder="" value="<?= $procedencia ?>" disabled>
                </div>
            </div>
            <div class="col-sm">
                <div class="col-md-12 mb-3">
                    <label for="">Domicilio:</label>
                    <input type="text" class="form-control" id="" placeholder="" value="<?= $domicilio  ?>" disabled>
                </div>
                <div class="col-md-12 mb-3">
                    <label for="lastName">Telefono</label>
                    <input type="text" class="form-control" id="lastName" placeholder="" value="<?= $telefono ?>" disabled>
                </div>
            </div>
        </div> -->
        <div class="row">
            <div class="col-12 mt-2">
                <div class="btn-group" role="group">
                    <input type="radio" class="btn-check" name="ferramenta" id="mouse" autocomplete="off" checked>
                    <label class="btn btn-secondary" for="mouse"><i class="fas fa-mouse-pointer"></i></label>

                    <input class="btn-check" type="radio" name="ferramenta" id="pincel" value="option1">
                    <label class="btn btn-secondary" for="pincel"><i class="fas fa-pencil-alt"></i></label>

                    <input class="btn-check" type="radio" name="ferramenta" id="borracha" value="option2">
                    <label class="btn btn-secondary" for="borracha"><i class="fas fa-eraser"></i></label>

                </div>
                <div class="btn-group" role="group">
                    <button id="configBtn" type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-cog"></i>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                        <li style="margin: 5px;">
                            <label for="customRange2" class="form-label">Tamaño</label>
                            <input type="range" class="form-range" min="1" max="5" id="tamanhoPincel">
                        </li>
                        <li style="margin: 5px;">
                            <label for="customRange2" class="form-label">Color</label>
                            <input type="color" id="corPincel" class="form-control form-control-color" value="#563d7c" title="Choose your color">
                        </li>
                        <li style="margin: 5px;">
                            <button id="limparDesenho" type="button" class="btn btn-secondary">
                                Limpiar diseño
                            </button>
                        </li>
                    </ul>
                </div>
                <button type="button" class="btn btn-secondary" id="saveBtn"><i class="fas fa-save"></i></button>
            </div>
        </div>
    </div>
    <div id="canva-group">
        <canvas id="camada1Odontograma"></canvas>
        <canvas id="camada2Odontograma"></canvas>
        <canvas id="camada3Odontograma"></canvas>
        <canvas id="camada4Odontograma"></canvas>

        <canvas id="camadaPincel"></canvas>
    </div>
    <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Agregar procedimiento.</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <input type="hidden" id="procedimentosRemovidos" th:field="*{procedimentosRemovidos}">
                        <div id="procedimentosDiv"></div>
                        <div class="form-group col-md-12">
                            <label for="nomeProcedimento">Nombre</label>
                            <i data-type="info" class="fas fa-info-circle fa-1x text-info" onclick="toast_message('.','info')" style="margin-left: 5px; cursor: pointer;"></i>
                            <select class="form-control" id="nomeProcedimento">
                                <option selected value="-1">-- Seleccione una opcion --</option>
                                <!-- <option th:value="${null}" th:text="${'NÃO INFORMADO'}"></option> -->
                                <!-- <option th:each="model : ${modelEnums}" th:value="${model}" th:text="${model.denominacao}"></option> -->
                            </select>
                        </div>
                        <div class="form-group col-12" id="colOutroProcedimento">
                            <label for="outroProcedimento">Otro procedimiento</label>
                            <i style="margin-left:5px;cursor: pointer;" class="alerta fas fa-info-circle fa-1x text-info" data-type="info" onclick="mensagens('.','info')"></i>
                            <input id="outroProcedimento" class="form-control" type="text">
                        </div>
                        <div class="form-group col-12">
                            <label for="exampleColorInput" class="form-label">Color</label>
                            <i style="margin-left:5px;cursor: pointer;" class="alerta fas fa-info-circle fa-1x text-info" data-type="info" onclick="mensagens('.','info')"></i>
                            <input type="color" id="cor" disabled class="form-control form-control-color" value="#563d7c" title="Choose your color">
                        </div>
                        <div class="form-group col-12">
                            <label for="informacoesAdicionais">Información adicional</label>
                            <i style="margin-left:5px;cursor: pointer;" class="alerta fas fa-info-circle fa-1x text-info" data-type="info" onclick="mensagens('.','info')"></i>
                            <textarea rows="5" id="informacoesAdicionais" maxlength="5000" class="form-control"></textarea>
                        </div>
                        <div class="form-group col-md-1 d-inline mt-2" style="text-align: center; margin: auto;">
                            <a id="botaoAdicionar" class="form-control btn-sigsaude btnCorNovo">
                                <i class="fas fa-plus"></i>
                            </a>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <div class="panel panel-default">
                                <div class="table-responsive">
                                    <table class="table display dataTable table-bordered table-striped" id="tabelaTestesEspecificosForm">
                                        <thead>
                                            <tr>
                                                <th>NOMBRE</th>
                                                <th>COLOR</th>
                                                <th>INFORMACION ADICIONAL</th>
                                                <th class="text-center">ACCIONES</th>
                                            </tr>
                                        </thead>
                                        <tbody id="bodyProcedimentos">
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="configuracoesFerramenta" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>