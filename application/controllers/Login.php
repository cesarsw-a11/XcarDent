<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Clase para realizar las acciones del login
 */
class Login extends CI_Controller
{
    //Funcion que se ejecuta al cargar el archivo
    function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->load->view('login');
    }

    /**
     * Funcion que recibe los datos del usuario para acceder al portal
     * 
     * @param array $datos
     * @return json
     * @date 15-06-2022
     */
    public function acceder()
    {
        #Armamos la respuesta
        $response = ["respuesta" => "0"];
        #Recibimos los datos por post
        $datos = $this->input->post();
        $usuario = $datos['usuario'];
        $pass = $datos['password'];

        if (!empty($usuario) && !empty($pass)) {
            $contraseñaEncriptada = hash("sha256", $pass);
            $tabla = "usuarios";
            $tipoRol = "ADM";
            $rol = 1;

            $obtenerDatos = "select * from " . $tabla . " where email = '" . $usuario . "' and password = '" . $contraseñaEncriptada . "' ";
            $obtenerDatos = $this->db->query($obtenerDatos)->row();
            if (isset($obtenerDatos)) {

                if ($obtenerDatos->password == $contraseñaEncriptada && $obtenerDatos->idRol == $rol) {
                    $datosSesion = [
                        "rol" => $obtenerDatos->idRol,
                        "logged" => true
                    ];
                    $this->session->set_userdata($datosSesion);

                    $response['respuesta'] = "1";

                    echo json_encode($response);
                    return;
                }
            }
        }
        echo json_encode($response);
    }

    /**
     * Funcion que funciona para cerrar la sesion del usuario
     * 
     * @param session rol
     * @return view
     * @date 15-06-2022
     */
    public function logout()
    {
        header("location:" . base_url("/"));

        $this->session->unset_userdata("rol");
    }
}
