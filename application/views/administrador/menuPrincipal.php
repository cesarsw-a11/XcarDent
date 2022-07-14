<?php $this->load->view('head'); ?>
<?php $this->load->view('header'); ?>
<link rel="stylesheet" href="<?= base_url("estilos/admin.css") ?>">
<!-- Modal Datos Paciente -->
<div class="modal fade" id="modalAgregarOrden" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title"></h4>
                <button type="button" class="btn-close" data-dismiss="modal"></button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <form action="#" id="guardarOrdenForm">

                    <div>
                        <div id="pacientes">
                            <h4 style="text-align: center;">Datos del Paciente</h4><br>
                            <div class="row">
                                <div class="col">
                                    <input autocomplete="off" type="text" class="form-control" id="nombre" placeholder="Nombre del paciente" name="nombre" required>
                                </div>
                                <div class="col">
                                    <input autocomplete="off" type="number" class="form-control" placeholder="Edad" name="edad" id="edad" required>
                                </div>
                            </div><br>
                            <div class="row">
                                <div class="col">
                                    <select class="form-control" name="sexo" id="sexo">
                                        <option value="femenino">FEMENINO</option>
                                        <option value="masculino">MASCULINO</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <input autocomplete="off" type="text" class="form-control" placeholder="Procedencia" name="procedencia" id="procedencia" required>
                                </div>
                            </div><br>
                            <div class="row">
                                <div class="col">
                                    <input autocomplete="off" type="text" class="form-control" placeholder="Domicilio" name="domicilio" id="domicilio" required>
                                </div>
                                <div class="col">
                                    <input autocomplete="off" class="form-control" id="telefono" placeholder="Telefono" name="telefono" required>
                                </div>
                            </div><br>
                            <div class="row">
                                <div class="col">
                                    <input autocomplete="off" class="form-control" id="ocupacion" placeholder="Ocupacion" name="ocupacion" required>
                                </div>
                                <div class="col">
                                    <input class="form-control" autocomplete="off" id="contactoEmergencia" placeholder="Contacto de Emergencia" name="contactoEmergencia">
                                </div>
                            </div><br>
                            <div class="row">
                                <div class="col">
                                    <input autocomplete="off" class="form-control" id="telefonoEmergencia" placeholder="Telefono de emergencia" name="telefonoEmergencia" required>
                                </div>
                            </div><br><br>
                            <button type="button" class="btn btn-warning" onclick="verificar('pacientes')">Verificar campos</button>
                            <br>
                        </div>
                        <div id="antecedentes" style="display: none;">
                            <h4 style="text-align: center;">Antecedentes Personales</h4><br>
                            <div>
                                <div class="row">
                                    <div class="col">
                                        <input type="text" name="idPaciente" id="idPaciente" hidden>
                                        <input type="hidden" name="idHistoria" id="idHistoria">
                                        <textarea autocomplete="off" type="text" class="form-control" id="motivoConsulta" placeholder="Motivo de la Consulta" name="motivoConsulta" rows="3" required></textarea>
                                    </div>
                                    <div class="col">
                                        <textarea autocomplete="off" type="text" class="form-control" placeholder="Enfermedades Actuales" name="enfermedadesActuales" id="enfermedadesActuales" rows="3"></textarea>
                                    </div>
                                </div><br>
                                <div class="row">
                                    <div class="col">
                                        <input autocomplete="off" type="text" class="form-control" placeholder="Consume Medicamentos" name="consumeMedicamento" id="consumeMedicamento" required>
                                    </div>
                                    <div class="col">
                                        <input autocomplete="off" type="text" class="form-control" placeholder="Medicamentos que consume" name="medicamentosConsume" id="medicamentosConsume" >
                                    </div>
                                </div><br>
                                <div class="row">
                                    <div class="col">
                                        <input autocomplete="off" type="text" class="form-control" placeholder="Alergias" name="alergias" id="alergias" >
                                    </div>
                                </div><br>
                            </div><br>
                            <button type="button" class="btn btn-warning" onclick="verificar('antecedentes')">Verificar campos</button>

                        </div>
                        <div id="enfermedades" style="display: none;">
                            <h4 style="text-align: center;">Antecedentes Personales / Enfermedades / Padecimientos</h4><br>
                            <!-- <div class="col">
                                <div class="row">
                                    <div class="col">
                                        
                                        <label style="margin-right: 15px;" for="">Si </label><label for="">No</label><label for="" style="visibility: hidden;">Diabetes</label> </div>
                                        <div class="col">
                                        
                                        <label style="margin-right: 15px;" for="">Si </label><label for="">No</label><label for="" style="visibility: hidden;">Diabetes</label> </div>
                                </div><br>

                            </div> -->
                            <div class="col">
                                <div class="row">
                                    <div class="col">
                                        
                                        <input type="checkbox" id="diabetes" name="diabetes" value="1"> <label for="diabetes">Diabetes</label></div>
                                    <div class="col">
                                       
                                        <input type="checkbox" id="hipertension" name="hipertension" value="1"> <label for="">Hipertension</label> </div>
                                </div><br>

                            </div>
                            <div class="col">
                                <div class="row">
                                    <div class="col">
                                        <input type="checkbox" id="hipotension" name="hipotension" value="1"><label for="">Hipotension</label> </div>
                                    <div class="col">
                                        <input type="checkbox" id="sobrepeso" name="sobrepeso" value="1"><label for="">Sobrepeso</label> </div>
                                </div><br>
                            </div>
                            <div class="col">
                                <div class="row">
                                    <div class="col">
                                        <input type="checkbox" id="dislipidemia" name="dislipidemia" value="1"><label for="">Dislipidemia</label> </div>
                                    <div class="col">
                                        <input type="checkbox" id="infarto" name="infarto" value="1"><label for="">Infarto</label> </div>
                                </div><br>
                            </div>
                            <div class="col">
                                <div class="row">
                                    <div class="col">
                                        <input type="checkbox" id="ets" name="ets" value="1"><label for="">ETS</label> </div>
                                    <div class="col">
                                        <input type="checkbox" id="vih" name="vih" value="1"><label for="">VIH</label> </div>
                                </div><br>
                            </div>
                            <div class="col">
                                <div class="row">
                                    <div class="col">
                                        <input type="checkbox" id="hepatitis" name="hepatitis" value="1"><label for="">Hepatitis</label> </div>
                                    <div class="col">
                                        <input type="checkbox" id="renal" name="renal" value="1"><label for="">Enfermedad Renal</label> </div>
                                </div><br>
                            </div>
                            <div class="col">
                                <div class="row">
                                    <div class="col">
                                        <input type="checkbox" id="glaucoma" name="glaucoma" value="1"><label for="">Glaucoma</label> </div>
                                    <div class="col">
                                        <input type="checkbox" id="convulsiones" name="convulsiones" value="1"><label for="">Convulsiones</label> </div>
                                </div><br>
                            </div>
                            <div class="col">
                                <div class="row">
                                    <div class="col">
                                        <input type="checkbox" id="depresion" name="depresion" value="1"><label for="">Depresion</label> </div>
                                    <div class="col">
                                        <input type="checkbox" id="ansiedad" name="ansiedad" value="1"><label for="">Ansiedad</label> </div>
                                </div><br>
                            </div>
                            <div class="col">
                                <div class="row">
                                    <div class="col">
                                        <input type="checkbox" id="estres" name="estres" value="1"><label for="">Estres</label> </div>
                                    <div class="col">
                                        <input type="checkbox" id="esquizofrenia" name="esquizofrenia" value="1"><label for="">Esquizofrenia</label> </div>
                                </div><br>
                            </div>
                            <div class="col">
                                <div class="row">
                                    <div class="col">
                                        <input type="checkbox" id="cancer" name="cancer" value="1"><label for="">Cancer</label> </div>
                                    <div class="col">
                                        <input type="checkbox" id="asma" name="asma" value="1"><label for="">Asma</label> </div>
                                </div><br>
                            </div>
                            <div class="col">
                                <div class="row">
                                    <div class="col">
                                        <input type="checkbox" id="dificultadRespiratoria" name="dificultadRespiratoria" value="1"><label for="">Dificultad Respiratoria</label> </div>
                                    <div class="col">
                                        <input type="checkbox" id="bronquitis" name="bronquitis" value="1"><label for="">Bronquitis</label> </div>
                                </div><br>
                            </div>
                            <div class="col">
                                <div class="row">
                                    <div class="col">
                                        <input type="checkbox" id="neumonia" name="neumonia" value="1"><label for="">Neumonia</label> </div>
                                    <div class="col">
                                        <input type="checkbox" id="sinusitis" name="sinusitis" value="1"><label for="">Sinusitis</label> </div>
                                </div><br>
                            </div>
                            <div class="col">
                                <div class="row">
                                    <div class="col">
                                        <input type="checkbox" id="cirrosis" name="cirrosis" value="1"><label for="">Cirrosis</label> </div>
                                    <div class="col">
                                        <input type="checkbox" id="anemia" name="anemia" value="1"><label for="">Anemia</label> </div>
                                </div><br>
                            </div>
                            <div class="col">
                                <div class="row">
                                    <div class="col">
                                        <input type="checkbox" id="leucemia" name="leucemia" value="1"><label for="">Leucemia</label> </div>
                                    <div class="col">
                                        <input type="checkbox" id="gastritis" name="gastritis" value="1"><label for="">Gastritis</label> </div>
                                </div><br>
                            </div>
                            <div class="col">
                                <div class="row">
                                    <div class="col">
                                        <input type="checkbox" id="colitis" name="colitis" value="1"><label for="">Colitis</label> </div>
                                    <div class="col">
                                        <input type="checkbox" id="epilepsia" name="epilepsia" value="1"><label for="">Epilepsia</label> </div>
                                </div><br>
                            </div>
                            <div class="col">
                                <div class="row">
                                    <div class="col">
                                        <input type="checkbox" id="hospitalizaciones" name="hospitalizaciones" value="1"><label for="">Hospitalizaciones</label> </div>
                                    <div class="col">
                                        <input type="checkbox" id="intervenciones" name="intervenciones" value="1"><label for="">Intervenciones</label> </div>
                                </div><br>
                            </div>
                            <div class="col">
                                <div class="row">
                                    <div class="col">
                                        <input type="checkbox" id="transfusiones" name="transfusiones" value="1"><label for="">Transfusiones</label> </div>
                                    <div class="col">
                                        <input type="checkbox" id="donadores" name="donadores" value="1"><label for="">Donadores</label> </div>
                                </div><br>
                            </div>
                            <div class="col">
                                <div class="row">
                                    <div class="col">
                                        <input type="checkbox" id="discapacidad" name="discapacidad" value="1"><label for="">Discapacidad</label> </div>
                                    <div class="col">
                                        <input type="checkbox" id="tabaco" name="tabaco" value="1"><label for="">Tabaco</label> </div>
                                </div><br>
                            </div>
                            <div class="col">
                                <div class="row">
                                    <div class="col">
                                        <input type="checkbox" id="alcohol" name="alcohol" value="1"><label for="">Alcohol</label> </div>
                                    <div class="col">
                                        <input type="checkbox" id="sustancias" name="sustancias" value="1"><label for="">Sustancias</label> </div>
                                </div><br>
                            </div>
                            <div class="col">
                                <div class="row">
                                    <div class="col">
                                        <input type="checkbox" id="ejercicio" name="ejercicio" value="1"><label for="">Ejercicio</label> </div>
                                    <div class="col">
                                        <input type="checkbox" id="alimentacionBalanceada" name="alimentacionBalanceada" value="1"><label for="">Alimentacion Balanceada</label> </div>
                                </div><br>
                            </div>
                        </div>
                        <!-- Modal footer -->
                        <div class="modal-footer">
                        </div>
                </form>
            </div>
        </div>
    </div>
</div>

</div>

<div class="container-xl" style="margin-bottom:10%;">
    <div class="table-responsive">
        <div class="table-wrapper">

            <div class="table-title">
                <div class="row">
                    <div class="col-sm-6">
                        <h2>Administrar <b>Consultas</b></h2>
                    </div>
                    <div class="col-sm-6">
                        <a onclick="ui_modalNuevaOrden()" class="btn btn-success boton-agregar"><i class="material-icons">&#xE147;</i> <span>Agregar nuevo paciente</span></a>
                        <a href="#deleteEmployeeModal" class="btn btn-danger" data-toggle="modal" hidden><i class="material-icons">&#xE15C;</i> <span>Delete</span></a>
                    </div>
                </div>
            </div>


            <table id="tabla_ordenes" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>Id. Paciente</th>
                        <th>Nombre</th>
                        <th>Domicilio</th>
                        <th>Telefono</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div id="editEmployeeModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content-odontograma">
			
		</div>
	</div>
</div>

<?php $this->load->view('footer'); ?>
<script src="<?= base_url("assets/scripts/administrador.js") ?>"></script>
<script>
    $(() => {


       /*  $("input:checkbox").click(function() {
            var group = "input:checkbox[name='" + $(this).attr("name") + "']";
            $(group).prop("checked", false);
            $(this).prop("checked", true);
        }) */
    });
</script>