<?php $this->load->view('head'); ?>
<link rel="stylesheet" href="<?= base_url("estilos/admin.css") ?>">
<!-- The Modal -->
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
                    <h4 style="text-align: center;">Datos de compra</h4><br>
                    <div>
                        <div class="row">
                            <div class="col">
                                <input autocomplete="off" type="text" class="form-control" id="proveedor" placeholder="Nombre del Proveedor" name="proveedor" required>
                            </div>
                            <div class="col">
                                <input autocomplete="off" type="date" class="form-control" placeholder="Fecha" name="fecha" id="fecha" required>
                            </div>
                        </div><br>
                        <div class="row">
                            <div class="col">
                                <input autocomplete="off" type="text" class="form-control" placeholder="RFC" name="rfc" id="rfc" required>
                            </div>
                            <div class="col">
                                <input autocomplete="off" type="text" class="form-control" placeholder="Folio del proveedor" name="folioProveedor" id="folioProveedor" required>
                            </div>
                        </div><br>
                        <div class="row">
                            <div class="col">
                                <input autocomplete="off" type="text" class="form-control" placeholder="Area Solicitante" name="area" id="area" required>
                            </div>
                            <div class="col">
                                <input autocomplete="off" class="form-control" id="claveArea" placeholder="Clave de Area" name="claveArea" required>
                            </div>
                        </div><br>
                        <div class="row">
                            <div class="col">
                                <input autocomplete="off" class="form-control" id="numeroOrden" placeholder="No. de orden" name="numeroOrden" required>
                            </div>
                            <div class="col">
                                <input class="form-control" autocomplete="off" id="unidadOrden" placeholder="UnidadOrden" name="unidadOrden" required>
                            </div>
                        </div><br>
                        <div class="row">
                            <div class="col">
                                <input autocomplete="off" class="form-control" id="numeroRequisicion" placeholder="No. de Requisicion" name="numeroRequisicion" required>
                            </div>
                            <div class="col">
                                <input autocomplete="off" class="form-control" id="nota" placeholder="Nota de la orden" name="nota">
                            </div>
                        </div>
                        <br>
                        <h4 style="text-align: center;">Datos del producto</h4><br>
                        <div>
                            <div class="row">
                                <div class="col">
                                    <input type="text" name="idOrden" id="idOrden" hidden>
                                    <input autocomplete="off" type="number" class="form-control" id="partida" placeholder="Partida" name="partida" required>
                                </div>
                                <div class="col">
                                    <input autocomplete="off" type="number" class="form-control" placeholder="Cantidad" name="cantidad" id="cantidad" required>
                                </div>
                            </div><br>
                            <div class="row">
                                <div class="col">
                                    <input autocomplete="off" type="text" class="form-control" placeholder="Unidad" name="unidad" id="unidad" required>
                                </div>
                                <div class="col">
                                    <input autocomplete="off" type="text" class="form-control" placeholder="Descripcion" name="descripcion" id="descripcion" required>
                                </div>
                            </div><br>
                            <div class="row">
                                <div class="col">
                                    <input autocomplete="off" type="number" class="form-control" placeholder="Precio Unitario" name="precioUnitario" id="precioUnitario" required>
                                </div>
                                <div class="col">
                                    <input autocomplete="off" class="form-control" id="rFederal" placeholder="R. Federal" name="rFederal" required>
                                </div>
                            </div><br>
                            <div class="row">
                                <div class="col">
                                    <input autocomplete="off" class="form-control" id="rEstatal" placeholder="R. Estatal" name="rEstatal" required>
                                </div>
                                <div class="col">
                                    <input class="form-control" autocomplete="off" id="rFiscal" placeholder="R. Fiscal" name="rFiscal" required>
                                </div>
                            </div><br>
                            <div class="row">
                                <div class="col">
                                    <input type="number" autocomplete="off" class="form-control" id="importe" placeholder="Importe" name="importe" required>
                                </div>
                                <div class="col">
                                    <input type="number" autocomplete="off" class="form-control" id="iva" placeholder="IVA" name="iva" required>
                                </div>
                            </div>
                        </div><br>
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
                        <th>Id. Compra</th>
                        <th>Partida</th>
                        <th>Descripción</th>
                        <th>Importe</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php $this->load->view('footer'); ?>
<script src="<?= base_url("assets/scripts/administrador.js") ?>"></script>