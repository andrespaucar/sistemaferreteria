<?php 

use Peru\Http\ContextClient;
// use Peru\Jne\{Dni, DniParser};
use Peru\Sunat\{HtmlParser, Ruc, RucParser};


class SettingCompanyController extends Controller{
    public function __construct() {
        parent::__construct();
    }
    public function index(){
        if(isset($_SESSION['perfil'])){
            if($_SESSION['perfil'] == 'almacen' ){
                echo "<script> window.location.href = '".CARPETA_PROYECT."products' </script>";
            }else if($_SESSION['perfil'] == 'vendedor'){
                echo "<script> window.location.href = '".CARPETA_PROYECT."sale' </script>";
            }
        }else{
            echo "<script> window.location.href = '".CARPETA_PROYECT."' </script>";
        }
        View::render('index');
    }
    // API RUC
    public function consultaruc(){
        $post = json_decode(file_get_contents("php://input"), true);
        $ruc = $post['ruc']; 
         
        $cs = new Ruc(new ContextClient(), new RucParser(new HtmlParser())); 
        $company = $cs->get($ruc);
        if (!$company) {
            echo json_encode('Not found');
            exit();
        } 
        echo json_encode($company);
    
    }

    // ACTUALIZANDO DATO LA EMPRESA
    public function updatecompany(){
        $ruc = $_POST['ruc'];
        $razon_social = $_POST['razon_social'];
        $nombre_comercial = $_POST['nombre_comercial'];
        $telefono = $_POST['telefono'];
        $email = $_POST['email'];
        $ubigeo_id = $_POST['ubigeoselected'];
        $direccion_fiscal = $_POST['direccion_fiscal'];
        $anteriorfoto = $_POST['anteriorfoto'];
        $newimage= isset($_FILES['image']['name']);
        // echo json_encode($anteriorfoto); die();
        $nameImg = '';
        if(isset($_FILES['image'])){
            if($_FILES['image']['size'] < 2048000){ //2048000 = 2M
                if($_FILES['image']['type'] == 'image/png'){
                    $nameImg = date('his').'.png';
                }
                if($_FILES['image']['type'] == 'image/jpeg' || $_FILES['image']['type'] == 'image/jpg'){
                    $nameImg = date('his').'.png';
                }
                // Eliminamos la IMG anterior
               if(file_exists(UP_COMPANY.($_FILES['image']['name']))){
                   unlink(UP_COMPANY.($_FILES['image']['name'])); 
               }
                
            }else{
                echo json_encode('Imagen pesa mucho');
                return;
            } 
        }else{
            if($anteriorfoto == 'default_logo.png'){
                $nameImg = 'default_logo.png';
            }else{
                $nameImg = $anteriorfoto;
            }
        }
      
        $up_company = SettingCompanyModel::update_company($ruc,$razon_social,$nombre_comercial,$nameImg,$telefono,$email,$ubigeo_id,$direccion_fiscal);
        if($up_company == 'ok' ){
            if($nameImg !== 'default_logo.png' && $newimage ){
                move_uploaded_file($_FILES['image']['tmp_name'], UP_COMPANY.$nameImg );
                // return;
            }
            echo json_encode('ok');
        }else{
            echo json_encode("error");
        }
        // echo json_encode(var_dump($image));
    }

    // OPTENER EMPRESA
    public function getcompany(){
        $get = SettingCompanyModel:: getcompanype();
        echo json_encode($get);
    }

}