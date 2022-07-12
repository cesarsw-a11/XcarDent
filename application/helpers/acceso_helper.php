<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if(!function_exists('validarAcceso')){
    /**
     * Función para validar el acceso a los modulos del administrador
     */
    function validarAcceso($rol)
    {
        if ($rol == "1") {
            #Dejara entrar al panel del admin
        } else {
            echo "<h2>No tienes acceso a esta vista</h2><a href=" . base_url("/") . ">Volver a la pagina principal</a>";
            die;
        }
    }
}
