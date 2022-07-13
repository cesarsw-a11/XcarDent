'use strict'
const botonGuardarNuevaOrden = `<button type="submit" class="btn btn-primary">Guardar</button>`
const botonGuardarCambios = `<button type="button" class="btn btn-primary" onclick="guardarCambiosEditar()">Guardar</button>`
const botonCerrarModal = `<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>`
const nombreFormulario = $("form").attr("id");
const btnIrAntecedentes = `<button id="botonAntecedentes" type="button" class="btn btn-info" onclick="ui_abrirModalAntecedentes();" disabled>Ir a Antecedentes</button>`
const btnRegresarDatosPaciente = `<button type="button" class="btn btn-info" onclick="ui_regresarDatosPaciente();">Regresar a datos del paciente</button>`
const btnIrEnfermedades = `<button id="siguiente" type="button" class="btn btn-info" onclick="ui_siguienteEnfermedades();" disabled >Siguiente</button>`
const btnRegresarAntecedentes = `<button id="botonAntecedentes" type="button" class="btn btn-info" onclick="ui_abrirModalAntecedentes();">Regresar a Antecedentes</button>`
const btnIrEnfermedadesGuardar = `<button id="siguiente" type="button" class="btn btn-info" onclick="ui_siguienteEnfermedadesGuardar();"  >Siguiente</button>`
const btnIrAntecedentesGuardar = `<button id="botonAntecedentes" type="button" class="btn btn-info" onclick="ui_abrirModalAntecedentesGuardar();" >Ir a Antecedentes</button>`

//Cargamos todo el javascript una vez que el DOM esta cargado
$(document).ready(() => {
    //Inicializamos el datatable
    listarOrdenes();

    $("#" + nombreFormulario).submit(function (e) {
        e.preventDefault();

        var formData = new FormData(this);
        var checkbox = $("#" + nombreFormulario).find("input[type=checkbox]");
        $.each(checkbox, function(key, val) {
            formData.append($(val).attr('name'), ($(this).is(':checked')) ? 1 : 0)
        });
        
        mandarFormulario(formData)

        return true;
    });
});

//Funcion para verificar que los inputs que esten con el atributo rquired lo cumplan
function verificar(divInput){
    let inputs = $(`#${divInput} :input`);
    
    for (let index = 0; index < inputs.length; index++) {
        var i = 0;
        if(inputs[index].value == "" && inputs[index].required){
            alertify.alert("El campo "+inputs[index].placeholder+" es requerido.")
            return false;
        }
    }
    $("#botonAntecedentes").attr("disabled",false)
    if(divInput == "antecedentes"){
        $("#siguiente").attr("disabled",false)
    }
}

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
    $(".modal-title").html("Agregar Nuevo Paciente")
    $(".modal-footer").html(btnIrAntecedentes)
    $("#pacientes").css('display','block')
    $("#enfermedades").css('display','none')
    $("#modalAgregarOrden").modal()

}
function ui_abrirModalAntecedentes() {
    $(".modal-title").html("Comenzar historial clinico.")
    $(".modal-footer").html(btnRegresarDatosPaciente + btnIrEnfermedades)
    $("#antecedentes").css('display','block')
    $("#pacientes").css('display','none')
    $("#enfermedades").css('display','none')

}

function ui_abrirModalAntecedentesGuardar(){
    $(".modal-title").html("Comenzar historial clinico.")
    $(".modal-footer").html(btnRegresarDatosPaciente + btnIrEnfermedadesGuardar)
    $("#antecedentes").css('display','block')
    $("#pacientes").css('display','none')
    $("#enfermedades").css('display','none') 
}

function ui_regresarDatosPaciente(){
    $(".modal-title").html("Agregar Nuevo Paciente")
    $("#antecedentes").css('display','none')
    $("#pacientes").css('display','block')
    $(".modal-footer").html(btnIrAntecedentes)
}

function ui_siguienteEnfermedades(){
    $(".modal-title").html("Seguimiento historial clinico")
    $("#antecedentes").css('display','none')
    $("#enfermedades").css('display','block')
    $(".modal-footer").html(btnRegresarAntecedentes + botonGuardarNuevaOrden)
}
function ui_siguienteEnfermedadesGuardar(){
    $(".modal-title").html("Seguimiento historial clinico")
    $("#antecedentes").css('display','none')
    $("#enfermedades").css('display','block')
    $(".modal-footer").html(btnRegresarAntecedentes + botonGuardarCambios)
}

function ui_modalEditarOrden(id_orden) {
    //$(".modal-footer").html(botonGuardarCambios + botonCerrarModal)
    $(".modal-footer").html(btnIrAntecedentesGuardar)
    $(".modal-title").html("Editar Paciente")
    $("#pacientes").css('display','block')
    $("#enfermedades").css('display','none')
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
            $("#nombre").val(data.nombre)
            $("#edad").val(data.edad)
            $("#sexo").val(data.sexo)
            $("#procedencia").val(data.procedencia)
            $("#domicilio").val(data.domicilio)
            $("#telefono").val(data.telefono)
            $("#ocupacion").val(data.ocupacion)
            $("#telefonoEmergencia").val(data.telefonoEmergencia)
            $("#contactoEmergencia").val(data.contactoEmergencia)
            $("#motivoConsulta").val(data.motivoConsulta)
            $("#enfermedadesActuales").val(data.enfermedadesActuales)
            $("#consumeMedicamento").val(data.consumeMedicamento)
            $("#medicamentosConsume").val(data.medicamentosConsume)
            $("#alergias").val(data.alergias)
            $("#idPaciente").val(data.idPaciente)
            $("#idHistoria").val(data.idHistoria)
            //checkbox
            var result = [];

            for(var i in data){
                result.push([i, data[i]])
            }
            var enfermedades = result.slice(19,57)
            enfermedades.map((enfermedad)=>{
                if(enfermedad[1] == 1 && enfermedad[1] !== null){
                    $("#"+enfermedad[0]).prop("checked",true)
                }else{
                    $("#"+enfermedad[0]).prop("checked",false)
                }
            })

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

    window.location.href = base_url + "administrador/odontograma/" + id_orden

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
    var checkbox = $($("#" + nombreFormulario)[0]).find("input[type=checkbox]");
        $.each(checkbox, function(key, val) {
            formData.append($(val).attr('name'), ($(this).is(':checked')) ? 1 : 0)
        });
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
    columnas.push({ "data": "idPaciente" });
    columnas.push({ "data": "nombre" });
    columnas.push({ "data": "domicilio" });
    columnas.push({ "data": "telefono" });
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
                    json[i]['acciones'] = `<button class="btn btn-info" data-toggle="tooltip" title="Editar" onclick="ui_modalEditarOrden(${json[i].idPaciente})"><i class="fa fa-pencil" ></i></button>
                <button class="btn btn-danger" data-toggle="tooltip" title="Eliminar" onclick="ui_modalEliminarOrden(${json[i].idPaciente})"><i class="fa fa-trash" aria-hidden="true"></i></button>
                <button class="btn btn-success" data-toggle="tooltip" title="Odontograma" onclick="descargarPDF(${json[i].idPaciente})"><i class="fa fa-medkit" aria-hidden="true"></i></button>`
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
        boton_editar = `<button class="btn btn-info" data-toggle="tooltip" title="Editar" onclick="ui_modalEditarOrden(${data.idPaciente})"><i class="fa fa-pencil" ></i></button>
        <button class="btn btn-danger" data-toggle="tooltip" title="Eliminar" onclick="ui_modalEliminarOrden(${data.idPaciente})"><i class="fa fa-trash" aria-hidden="true"></i></button>
        <button class="btn btn-success" data-toggle="tooltip" title="Odontograma" onclick="descargarPDF(${data.idPaciente})"><i class="fa fa-medkit" aria-hidden="true"></i></button>`,
        rowNode;
    //Agregamos la fila a la tabla
    rowNode = table.row.add({
        "idPaciente": data.idPaciente,
        "nombre": data.nombre,
        "domicilio": data.domicilio,
        "telefono": data.telefono,
        "acciones": boton_editar
    }).draw()

}