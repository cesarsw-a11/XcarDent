'use strict'
//Funcion para limpiar todos los inputs al abrir el formulario de crear nuevo
function limpiarCampos(nombreFormulario) {
    let tipoFormulario = $("#formulario").val()
    $("#genero").val("-1")
    $("#" + nombreFormulario).find($('input')).val('')
    $("#" + nombreFormulario).find($('textarea')).val('')
    $("#" + nombreFormulario).find($('input[type=checkbox]')).prop("checked",false)
    $("#formulario").val(tipoFormulario)
}

function mayus(e) {
    e.value = e.value.toUpperCase();
}