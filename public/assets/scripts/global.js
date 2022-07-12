'use strict'
//Funcion para limpiar todos los inputs al abrir el formulario de crear nuevo
function limpiarCampos(nombreFormulario) {
    let tipoFormulario = $("#formulario").val()
    $("#genero").val("-1")
    $("#" + nombreFormulario).find($('input')).val('')
    $("#formulario").val(tipoFormulario)
}

function mayus(e) {
    e.value = e.value.toUpperCase();
}