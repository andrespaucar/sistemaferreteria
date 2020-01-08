<?php 
use Peru\Http\ContextClient;
use Peru\Jne\{Dni, DniParser};
use Peru\Sunat\{HtmlParser, Ruc, RucParser};

class CustomersController extends Controller{

    public function __construct() {
        parent::__construct();
    }
    public function index(){
        if(isset($_SESSION['perfil'])){
            if($_SESSION['perfil'] == 'almacen' ){
                echo "<script> window.location.href = '".CARPETA_PROYECT."products' </script>";
            }
        }else{
            echo "<script> window.location.href = '".CARPETA_PROYECT."' </script>";
        }
        View::render('index');
    }

    public function all(){
        $all = CustomersModel::allcustomers();
        echo json_encode($all);
    }

    public function updatestate(){
        $post = json_decode(file_get_contents("php://input"), true);
        $id = $post['id'];
        // echo json_encode($id);
        // return;
        $up = CustomersModel::updateStateCustomer($id);
        if($up == 'ok'){
            echo json_encode('ok');
        }else{
            echo json_encode('Error al Cambiar Estado');
        }
    }
    //Cambiado Deleted_At Customer
    public function delecustomer(){
        $post = json_decode(file_get_contents("php://input"), true);
        $id = $post['id'];
        $delc = CustomersModel::delcustomer($id);
        if($delc == 'ok'){
            echo json_encode('ok');
        }else{
            echo json_encode('error');
        }
    }

    public function addcustomer(){
        $post = json_decode(file_get_contents("php://input"), true);
        $select_tipo_doc    = $post['select_tipo_doc'];
        $num_doc            = $post['num_doc'];
        $razon_social_nombre= ucwords($post['razon_social_nombre']);
        $telefono_cli       = $post['telefono_cli'];
        $email_cli          = $post['email_cli'];
        $direccion_cli        = $post['direccion_cli'];
        $ubigeo_cli        = $post['ubigeo_cli']; 
        $add = CustomersModel::addcustomer_mod($select_tipo_doc,$num_doc,$razon_social_nombre,$telefono_cli,$email_cli,$direccion_cli,$ubigeo_cli);
        if($add == 'ok'){
            echo json_encode('ok');
        }else{
            echo json_encode('error');
        } 

    }
    // Verificando si existe el RUC o DNI en la DB
    public function verifydoc(){
        $post = json_decode(file_get_contents("php://input"), true);
        $doc = $post['num_doc'];
        $searchdoc = CustomersModel::verifydocdb($doc);
        echo json_encode($searchdoc);
    }
    // CONSULTADO API PERU CONSULT *- DNI y RUC
    public function peruconsult(){ 
        $post = json_decode(file_get_contents("php://input"), true);
        $tipodoc = $post['tipodoc'];
        $numdoc = $post['numdoc'];
        switch ($tipodoc) {
            case '1':
                $doc = 'DNI';
                $cs = new Dni(new ContextClient(), new DniParser()); 
                $person = $cs->get($numdoc);
                if (!$person) {
                    echo json_encode('Not found');
                    exit();
                }
                echo json_encode(compact('person','doc'));
                break;
            case '2':
                $doc = 'RUC';
                $cs = new Ruc(new ContextClient(), new RucParser(new HtmlParser())); 
                $company = $cs->get($numdoc);
                if (!$company) {
                    echo json_encode('Not found');
                    exit();
                } 
                echo json_encode(compact('company','doc'));
                break;
            default:
                echo json_encode('Error API');
                break;
        }


        

    }
}