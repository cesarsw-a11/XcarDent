'use strict'
const botonGuardarNuevaOrden = `<button type="submit" class="btn btn-primary">Guardar</button>`
const botonGuardarCambios = `<button type="button" class="btn btn-primary" onclick="guardarCambiosEditar()">Guardar</button>`
const botonCerrarModal = `<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>`
const nombreFormulario = $("form").attr("id");
//Cargamos todo el javascript una vez que el DOM esta cargado
$(document).ready(() => {
    //Inicializamos el datatable
    listarOrdenes();

    $("#" + nombreFormulario).submit(function (e) {
        e.preventDefault();

        var formData = new FormData(this);
        mandarFormulario(formData)

        return true;
    });
});

function mandarFormulario(formData) {
    //En caso de que los datos sean llenados y esten correctos del lado del cliente se mandaran al backend para validarlos
    $.ajax({
        url: base_url + 'administrador/guardarOrden',
        type: 'POST',
        data: formData,
        success: function (data) {
            data = JSON.parse(data)

            if (data.insertado) {
                llenarTabla(data)
                limpiarCampos(nombreFormulario);

                Swal.fire(
                    "Exito",
                    data.mensaje,
                    "success"
                );
                $("#modalAgregarOrden").modal("hide");
            } else {
                Swal.fire(
                    "Error",
                    data.mensaje,
                    "error"
                );
            }
        },
        error: function (error, xhr, status) {

            Swal.fire(
                "Error",
                "No fue posible guardar sus datos, revise su conexión.",
                "error"
            );
        },
        cache: false,
        contentType: false,
        processData: false
    });
}

function ui_modalNuevaOrden() {
    limpiarCampos(nombreFormulario);
    $(".modal-title").html("Agregar nueva Orden de Compra")
    $(".modal-footer").html(botonGuardarNuevaOrden + botonCerrarModal)
    $("#modalAgregarOrden").modal()

}

function ui_modalEditarOrden(id_orden) {
    $(".modal-footer").html(botonGuardarCambios + botonCerrarModal)
    $(".modal-title").html("Editar Orden de Compra")
    $("#modalAgregarOrden").modal()
    ui_obtenerOrden(id_orden)

}

function ui_obtenerOrden(id_orden) {
    $.ajax({
        url: base_url + 'administrador/obtenerOrdenPorId',
        type: 'POST',
        data: { "id": id_orden },
        success: function (response) {
            var data = JSON.parse(response)
            data = data.datos
            $("#partida").val(data.partida)
            $("#cantidad").val(data.cantidad)
            $("#unidad").val(data.unidad)
            $("#descripcion").val(data.descripcion)
            $("#precioUnitario").val(data.precioUnitario)
            $("#rFederal").val(data.rFederal)
            $("#rEstatal").val(data.rEstatal)
            $("#rFiscal").val(data.rFiscal)
            $("#importe").val(data.importe)
            $("#iva").val(data.iva)
            $("#proveedor").val(data.proveedor)
            $("#fecha").val(data.fecha)
            $("#rfc").val(data.rfc)
            $("#folioProveedor").val(data.folioProveedor)
            $("#area").val(data.area)
            $("#claveArea").val(data.claveArea)
            $("#numeroOrden").val(data.numeroOrden)
            $("#unidadOrden").val(data.unidadOrden)
            $("#numeroRequisicion").val(data.numeroRequisicion)
            $("#idOrden").val(data.idOrden)
            $("#nota").val(data.nota)

        },
        error: function (error, xhr, status) {

            Swal.fire(
                "Error",
                "No fue posible guardar sus datos, revise su conexión.",
                "error"
            );
        }
    });

}

function descargarPDF(id_orden) {

    window.location.href = base_url + "administrador/pdf/" + id_orden

}


function ui_modalEliminarOrden(id_orden) {
    var table = $('#tabla_ordenes').DataTable();
    Swal.fire({
        title: "Estas seguro?",
        text: "Aun puedes eliminar esta acción.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Si, estoy seguro",
        cancelButtonText: "No, cancelar",

    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: base_url + 'administrador/eliminarOrden',
                type: 'POST',
                data: { "idOrden": id_orden },
                success: function (response) {
                    var data = JSON.parse(response)
                    if (data.error == false) {
                        Swal.fire(
                            "Exito",
                            data.mensaje,
                            "success"
                        );
                        table.ajax.reload();
                    } else {
                        Swal.fire(
                            "Error",
                            "No fue posible eliminar sus datos, revise su conexión.",
                            "error"
                        );
                    }

                },
                error: function (error, xhr, status) {

                    Swal.fire(
                        "Error",
                        "No fue posible guardar sus datos, revise su conexión.",
                        "error"
                    );
                }
            });
        } else {
            Swal.fire("Cancelado", "Acción cancelada :)", "error");
        }
    })
}

function guardarCambiosEditar() {
    var table = $('#tabla_ordenes').DataTable();
    var formData = new FormData($("#" + nombreFormulario)[0])
    //En caso de que los datos sean llenados y esten correctos del lado del cliente se mandaran al backend para validarlos
    $.ajax({
        url: base_url + 'administrador/editarOrden',
        type: 'POST',
        data: formData,
        success: function (response) {
            var data = JSON.parse(response)
            if (data.error == false) {
                Swal.fire(
                    "Exito",
                    data.mensaje,
                    "success"
                );
                $("#modalAgregarOrden").modal("hide")
                $('#file').val("");
                table.ajax.reload();
            } else {
                Swal.fire(
                    "Error",
                    data.mensaje,
                    "error"
                );
            }

        },
        error: function (error, xhr, status) {

            Swal.fire(
                "Error",
                "No fue posible guardar sus datos, revise su conexión.",
                "error"
            );
        },
        cache: false,
        contentType: false,
        processData: false
    });

}

function listarOrdenes() {
    var columnas = [];
    columnas.push({ "data": "idProducto" });
    columnas.push({ "data": "partida" });
    columnas.push({ "data": "descripcion" });
    columnas.push({ "data": "importe" });
    columnas.push({ "data": "acciones" });

    var table = $('#tabla_ordenes').DataTable({
        'processing': true,
        // 'serverSide': true,
        'scrollY': "400px",
        'paging': true,
        drawCallback: function () {
            $('.paginate_button').addClass('btn btn-info')
            $('.paginate_button').css('margin','1px')
            $('.paginate_button.current').css('background-color','#91F1ED')},
        'ajax': {
            "url": base_url + "administrador/obtenerProductos",
            "type": "POST",
            "dataSrc": function (json) {
                for (var i = 0, ien = json.length; i < ien; i++) {
                    json[i]['acciones'] = `<button class="btn btn-info" data-toggle="tooltip" title="Editar" onclick="ui_modalEditarOrden(${json[i].idProducto})"><i class="fa fa-pencil" ></i></button>
                <button class="btn btn-danger" data-toggle="tooltip" title="Eliminar" onclick="ui_modalEliminarOrden(${json[i].idProducto})"><i class="fa fa-trash" aria-hidden="true"></i></button>
                <button class="btn btn-success" data-toggle="tooltip" title="Descargar PDF" onclick="descargarPDF(${json[i].idProducto})"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></button>`
                }
                return json;
            }
        },
        "columns": JSON.parse(JSON.stringify(columnas))

    });

}

function llenarTabla(response, tipoFormulario) {
    let data = response.data,
        table = $('#tabla_ordenes').DataTable(),
        boton_editar = `<button class="btn btn-info" data-toggle="tooltip" title="Editar" onclick="ui_modalEditarOrden(${data.idProducto})"><i class="fa fa-pencil" ></i></button>
        <button class="btn btn-danger" data-toggle="tooltip" title="Eliminar" onclick="ui_modalEliminarOrden(${data.idProducto})"><i class="fa fa-trash" aria-hidden="true"></i></button>
        <button class="btn btn-success" data-toggle="tooltip" title="Descargar PDF" onclick="descargarPDF(${data.idProducto})"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></button>`,
        rowNode;
    //Agregamos la fila a la tabla
    rowNode = table.row.add({
        "idProducto": data.idProducto,
        "partida": data.partida,
        "descripcion": data.descripcion,
        "importe": data.importe,
        "acciones": boton_editar
    }).draw()

}