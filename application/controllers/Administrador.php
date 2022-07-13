<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Dompdf\Dompdf;

/**
 * Clase para realizar el CRUD del administrador
 */
class Administrador extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();
        #Validamos que el usuario este logueado como admin
        validarAcceso($this->session->userdata("rol"));
    }

    #Mostramos el menu principal del administrador
    public function index()
    {
        $this->load->view("administrador/menuPrincipal");
    }

    public function obtenerProductos()
    {
        $obtenerProductos = "select * from pacientes";
        $data['productos'] = [];
        if ($this->db->query($obtenerProductos)) {
            $obtenerProductos = $this->db->query($obtenerProductos)->result_array();
            $data['productos'] = $obtenerProductos;
        }
        echo json_encode($obtenerProductos);
    }

    public function guardarOrden()
    {
        $datos = $this->input->post();

        $respuesta['insertado'] = 0;

        if ($datos) {
            unset($datos['idOrden']);
            $datosCompra = array(
                "nombre" => $datos['nombre'],
                "edad" => $datos['edad'],
                "sexo" => $datos['sexo'],
                "procedencia" => $datos['procedencia'],
                "domicilio" => $datos['domicilio'],
                "telefono" => $datos['telefono'],
                "ocupacion" => $datos['ocupacion'],
                "telefonoEmergencia" => $datos['telefonoEmergencia'],
                "contactoEmergencia" => $datos['contactoEmergencia']
            );
            if ($this->db->insert('pacientes', $datosCompra)) {
                $idPaciente = $this->db->insert_id();
                foreach ($datosCompra as $key => $value) {
                    unset($datos[$key]);
                }

                $datosHistorialClinico = array(
                    "idPaciente" => $idPaciente,
                    "motivoConsulta" => $datos['motivoConsulta'],
                    "enfermedadesActuales" => $datos['enfermedadesActuales'],
                    "consumeMedicamento" => $datos['consumeMedicamento'],
                    "medicamentosConsume" => $datos['medicamentosConsume'],
                    "alergias" => $datos['alergias']
                );
                if ($this->db->insert('historialClinico', $datosHistorialClinico)) {
                    $idHistoriaClinica = $this->db->insert_id();
                    foreach ($datosHistorialClinico as $key => $value) {
                        unset($datos[$key]);
                    }
                    unset($datos['idHistoria']);
                    /* foreach ($datos as $key => $value) {
                        if (empty($value)) {
                            unset($datos[$key]);
                        }
                    } */

                    $datos['idHistoriaClinica'] = $idHistoriaClinica;
                    if ($this->db->insert('antecedentesPaciente', $datos)) {
                        $caraDiente = 1;
                        $contador = 1;
                        while ($contador < 6) {

                            for ($i = 18; $i < 49; $i++) {
                                if ($caraDiente == 6) {
                                    $caraDiente = 1;
                                }
                                $datosOdontograma = array(
                                    "idPaciente" => $idPaciente,
                                    "idHistoria" => $idHistoriaClinica,
                                    "diente" => $i,
                                    "caraDiente" => $caraDiente
                                );
                                $caraDiente++;
                                $this->db->insert('odontograma', $datosOdontograma);
                            }
                            $contador++;
                        }
                        if ($this->db->insert('odontograma', $datosOdontograma)) {
                            $respuesta['insertado'] = 1;
                            $respuesta['mensaje'] = "La orden se ha guardado correctamente.";
                            $respuesta['data'] = $datosCompra;
                            $respuesta['data']['idPaciente'] = $idPaciente;
                        }
                    }
                }
            }
        }
        echo json_encode($respuesta);
    }

    public function obtenerDientes(){
        $query = "select * from odontograma where idPaciente = '".$_POST['paciente']."' ";
        $query = $this->db->query($query)->result_array();
       
        echo json_encode($query);
    }

    public function guardarDiente(){
         $datos = $this->input->post();
         $idPaciente = $datos['paciente'];
         $historiaClinica = "select idHistoria from historialClinico where idPaciente = '".$idPaciente."' ";
         $historiaClinica = $this->db->query($historiaClinica)->row();

         $respuesta['insertado'] = 0;

         $dataDiente = array(
             "idHistoria" => $historiaClinica->idHistoria,
             "idPaciente" => $idPaciente,
             "numeroDente" => $datos['diente'],
             "faceDente" => $datos['caraDiente'],
             "nome" => $datos['nombre'],
             "cor" => $datos['color'],
             "informacoesAdicionais" => $datos['info']
         );
         if ($this->db->insert('odontograma', $dataDiente)) {
            $respuesta['insertado'] = 1;
            $respuesta['mensaje'] = "El registro se ha guardado correctamente.";
         }

         echo json_encode($respuesta);
    }

    public function eliminarDiente(){
        $paciente = $_POST['paciente'];
        $numeroDiente = $_POST['numeroDiente'];
        $caraDiente = $_POST['caraDiente'];

        $this->db->where('idPaciente', $paciente);
        $this->db->where('numeroDente', $numeroDiente);
        $this->db->where('faceDente', $caraDiente);

        $this->db->delete('odontograma');
        if ($this->db->trans_status() === false) {
            $return = array(
                'error' => true,
                'mensaje' => 'No se pudo eliminar este registro',
            );
        } else {
            $return = array(
                'error' => false,
                'mensaje' => 'Registro eliminado correctamente',
            );
    }
    echo json_encode($return);
}

public function guardarDiseno(){
    $this->db->where('idPaciente', $_POST['paciente']);

        $this->db->delete('disenos');

    $dataImagen = array(
        "idPaciente" => $_POST['paciente'],
        "imagen" => $_POST['diseno']
    );
    $this->db->insert('disenos', $dataImagen);
    
}

public function obtenerDiseno(){
    $query = "select imagen from disenos where idPaciente = '".$_POST['paciente']."' ";
    $query = $this->db->query($query)->row();

    echo json_encode($query);
}

    /**
     * Funcion que elimina una orden con sus productos.
     * El orden de eliminacion es importante para no causar conflico con las llaves foraneas
     *
     * @return json
     */
    public function eliminarOrden()
    {
        $idOrden = $_POST['idOrden'];
        $queryObtenerOrdenCompra = "select idHistoria from historialClinico where idPaciente = '" . $idOrden . "' ";
        $queryObtenerOrdenCompra = $this->db->query($queryObtenerOrdenCompra)->row();
        $queryObtenerOrdenCompra = $queryObtenerOrdenCompra->idHistoria;

        $this->db->where('idHistoriaClinica', $queryObtenerOrdenCompra);
        $this->db->delete('antecedentesPaciente');
        if ($this->db->trans_status() === false) {
            $return = array(
                'error' => true,
                'mensaje' => 'No se pudo eliminar este registro',
            );
        } else {

            $this->db->where('idHistoria', $queryObtenerOrdenCompra);
            $this->db->delete('historialClinico');
            if ($this->db->trans_status() === false) {
                $return = array(
                    'error' => true,
                    'mensaje' => 'No se pudo eliminar este registro',
                );
            } else {
                $this->db->where('idPaciente', $idOrden);
                $this->db->delete('pacientes');
                if ($this->db->trans_status() === false) {
                    $return = array(
                        'error' => true,
                        'mensaje' => 'No se pudo eliminar este registro',
                    );
                } else {
                    $return = array(
                        'error' => false,
                        'mensaje' => 'Registro eliminado correctamente',
                    );
                }
            }
        }
        echo json_encode($return);
    }

    public function obtenerOrdenPorId()
    {
        $orden = $_POST['id'];
        $query = "select * from pacientes left join historialClinico on pacientes.idPaciente = historialClinico.idPaciente
        left join antecedentesPaciente on antecedentesPaciente.idHistoriaClinica = historialClinico.idHistoria
         where pacientes.idPaciente = '" . $orden . "' ";
        $query = $this->db->query($query)->row();
        echo json_encode(array("datos" => $query));
    }

    public function editarOrden()
    {
        $idOrden = $_POST['idPaciente'];
        $datos = $this->input->post();
        $tablasActualizada = 0;
        $return = array(
            'error' => true,
            'mensaje' => 'No se pudo editar este registro',
        );
        $datosCompra = array(
            "nombre" => $datos['nombre'],
            "edad" => $datos['edad'],
            "sexo" => $datos['sexo'],
            "procedencia" => $datos['procedencia'],
            "domicilio" => $datos['domicilio'],
            "telefono" => $datos['telefono'],
            "ocupacion" => $datos['ocupacion'],
            "telefonoEmergencia" => $datos['telefonoEmergencia'],
            "contactoEmergencia" => $datos['contactoEmergencia']
        );

        $this->db->db_debug = false;
        $this->db->where('idPaciente', $idOrden);
        $this->db->set($datosCompra);
        if (!$this->db->update('pacientes')) {

            $error = $this->db->error();
            if (isset($error)) {
                $return = array(
                    'error' => true,
                    'mensaje' => 'No se pudo editar este registro',
                );
            }
        } else {

            $tablasActualizada++;
            foreach ($datosCompra as $key => $value) {
                unset($datos[$key]);
            }
        }
        $datosHistorialClinico = array(
            "motivoConsulta" => $datos['motivoConsulta'],
            "enfermedadesActuales" => $datos['enfermedadesActuales'],
            "consumeMedicamento" => $datos['consumeMedicamento'],
            "medicamentosConsume" => $datos['medicamentosConsume'],
            "alergias" => $datos['alergias']
        );
        $this->db->db_debug = false;
        $this->db->where('idHistoria', $datos['idHistoria']);
        $this->db->set($datosHistorialClinico);
        if (!$this->db->update('historialClinico')) {
            $error = $this->db->error();
            if (isset($error)) {
                $return = array(
                    'error' => true,
                    'mensaje' => 'No se pudo editar este registro',
                );
            }
        } else {
            foreach ($datosHistorialClinico as $key => $value) {
                unset($datos[$key]);
            }
            /*  foreach($datos as $key => $value){
                if(empty($value)){
                    unset($datos[$key]);
                }
            } */
            $idHistoriaClinica = $datos['idHistoria'];
            unset($datos['idHistoria']);
            unset($datos['idPaciente']);

            $tablasActualizada++;
        }
        $this->db->db_debug = false;
        $this->db->where('idHistoriaClinica', $idHistoriaClinica);
        $this->db->set($datos);
        if (!$this->db->update('antecedentesPaciente')) {

            $error = $this->db->error();
            if (isset($error)) {
                $return = array(
                    'error' => true,
                    'mensaje' => 'No se pudo editar este registro',
                );
            }
        } else {

            $tablasActualizada++;
        }
        if ($tablasActualizada == 3) {
            $return = array(
                'error' => false,
                'mensaje' => 'Registro editado correctamente',
            );
        }
        echo json_encode($return);
    }

    public function pdf($numeroOrden)
    {
        $pathPDF = base_url();
        $obtenerData = "select * from productos left join ordenesCompra on productos.idOrden = ordenesCompra.idOrden
         where idProducto = '" . $numeroOrden . "' ";
        $obtenerData = $this->db->query($obtenerData)->row();

        $cuerpoHTML = str_replace('{{BASE_URL}}', $pathPDF, $this->load->view("administrador/pdfOrden", $obtenerData, TRUE));
        $cuerpoHTML .= '<link rel="stylesheet" href="assets/bootstrap4/css/bootstrap.min.css" />';
        $rutaPDF = "temp/orden" . $numeroOrden . ".pdf";

        // Crear PDF con DOMPDF
        $this->load->helper('file');
        $this->load->library('MY_Dompdf');
        $dompdf = new Dompdf();
        $dompdf->setPaper("A3", "portrait");

        $dompdf->loadHtml($cuerpoHTML);
        // Renderiza documento PDF
        $dompdf->render();
        $salida['status'] = 1;
        //Guardar el documento renderizado en una variable
        $output = $dompdf->output();
        if (!$output) {
            $salida['status'] = 0;
        }
        //Guardar archivo en temporales
        file_put_contents($rutaPDF, $output);

        $this->descargarPDF($rutaPDF, $numeroOrden);
    }

    public function descargarPDF($nombrePDF, $numeroOrden)
    {

        if (!file_exists($nombrePDF)) {
            $this->output->set_status_header('404');
        }
        //$nombrePDF = str_replace("temp/","",$nombrePDF);

        header("Content-type:application/pdf");
        header("Content-Disposition:attachment;filename=orden$numeroOrden.pdf");
        readfile($nombrePDF);
    }

    public function verPDF()
    {
        $obtenerData = "select * from productos left join ordenesCompra on productos.idOrden = ordenesCompra.idOrden
         where idProducto = '38' ";
        $obtenerData = $this->db->query($obtenerData)->row();
        $this->load->view("administrador/pdfOrden", $obtenerData);
    }

    public function odontograma($idPaciente)
    {
        $query = "select * from pacientes where idPaciente = '".$idPaciente."' ";
        $query = $this->db->query($query)->row_array();
        $query['idPaciente'] = $idPaciente;
        $this->load->view("administrador/odontograma", $query);
    }
}
