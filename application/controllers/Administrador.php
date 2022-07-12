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
        $obtenerProductos = "select * from productos";
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
                "numeroOrden" => $datos['numeroOrden'],
                "numeroRequisicion" => $datos['numeroRequisicion'],
                "unidadOrden" => $datos['unidad'],
                "claveArea" => $datos['claveArea'],
                "area" => $datos['area'],
                "folioProveedor" => $datos['folioProveedor'],
                "rfc" => $datos['rfc'],
                "fecha" => $datos['fecha'],
                "proveedor" => $datos['proveedor'],
                "nota" => $datos['nota']
            );
            if ($this->db->insert('ordenesCompra', $datosCompra)) {
                $idOrden = $this->db->insert_id();
                foreach ($datosCompra as $key => $value) {
                    unset($datos[$key]);
                }
                $datos['idOrden'] = $idOrden;
                if ($this->db->insert('productos', $datos)) {
                    $respuesta['insertado'] = 1;
                    $respuesta['mensaje'] = "La orden se ha guardado correctamente.";
                    $respuesta['data'] = $datos;
                    $respuesta['data']['idProducto'] = $this->db->insert_id();
                }
            }
        }
        echo json_encode($respuesta);
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
        $queryObtenerOrdenCompra = "select idOrden from productos where idProducto = '" . $idOrden . "' ";
        $queryObtenerOrdenCompra = $this->db->query($queryObtenerOrdenCompra)->row();
        $queryObtenerOrdenCompra = $queryObtenerOrdenCompra->idOrden;

        $this->db->where('idProducto', $idOrden);
        $this->db->delete('productos');
        if ($this->db->trans_status() === false) {
            $return = array(
                'error' => true,
                'mensaje' => 'No se pudo eliminar este registro',
            );
        } else {

            $this->db->where('idOrden', $queryObtenerOrdenCompra);
            $this->db->delete('ordenesCompra');
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
        echo json_encode($return);
    }

    public function obtenerOrdenPorId()
    {
        $orden = $_POST['id'];
        $query = "select * from productos left join ordenesCompra on productos.idOrden = ordenesCompra.idOrden
         where idProducto = '" . $orden . "' ";
        $query = $this->db->query($query)->row();
        echo json_encode(array("datos" => $query));
    }

    public function editarOrden()
    {
        $idOrden = $_POST['idOrden'];
        $datos = $this->input->post();
        $tablasActualizada = 0;
        $return = array(
            'error' => true,
            'mensaje' => 'No se pudo editar este registro',
        );
        unset($_POST['idOrden']);
        $datosCompra = array(
            "numeroOrden" => $datos['numeroOrden'],
            "numeroRequisicion" => $datos['numeroRequisicion'],
            "unidadOrden" => $datos['unidad'],
            "claveArea" => $datos['claveArea'],
            "area" => $datos['area'],
            "folioProveedor" => $datos['folioProveedor'],
            "rfc" => $datos['rfc'],
            "fecha" => $datos['fecha'],
            "proveedor" => $datos['proveedor'],
            "nota" => $datos['nota']
        );

        $this->db->db_debug = false;
        $this->db->where('idOrden', $idOrden);
        $this->db->set($datosCompra);
        if (!$this->db->update('ordenesCompra')) {

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
                unset($_POST[$key]);
            }
        }

        $this->db->db_debug = false;
        $this->db->where('idOrden', $idOrden);
        $this->db->set($_POST);
        if (!$this->db->update('productos')) {

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
        if ($tablasActualizada == 2) {
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
         where idProducto = '".$numeroOrden."' ";
        $obtenerData = $this->db->query($obtenerData)->row();

        $cuerpoHTML = str_replace('{{BASE_URL}}', $pathPDF, $this->load->view("administrador/pdfOrden", $obtenerData , TRUE));
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
        $this->load->view("administrador/pdfOrden",$obtenerData);
    }
}
