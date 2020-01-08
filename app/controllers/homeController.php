<?php 

class HomeController extends Controller{

    public function __construct() {
        parent::__construct();
        
        
    }
    public function index(){
        
        if(isset($_SESSION['perfil'])){
            if($_SESSION['perfil'] != ''){
                // header('Location: dashboard');
            }
        }
        
        VIEW::render('login');
    }
    public function loginusuario(){
        // session_start();
        $post = json_decode(file_get_contents("php://input"), true);
        $usuario = $post['user'];
        $contraseña = $post['pass'];
        //PROCESO DE COMPARACION DE LA CONTRASEÑA ENCRIPTADA

        // END
        $loginpe = UsersModel::loginuser( $usuario, $contraseña);
        if($loginpe){
            $_SESSION['perfil'] = $loginpe['perfil'];
            $_SESSION['dato_user'] = $loginpe['nombre']." ".$loginpe['apellido'];
            $_SESSION['usuario'] = $loginpe['usuario'];
            $_SESSION['foto'] = $loginpe['foto'];
            $_SESSION['fecha_creado'] = $loginpe['fecha_creado'];
            echo json_encode($_SESSION['perfil']);
            // echo json_encode($loginpe['perfil']);
        }else{
            // echo "<script>toastr.error('usuario o contraseña incorrectos')</script>";
            echo json_encode('error');
        }
       
    }

    public function salir(){
        session_destroy(); 
        session_unset();
        echo "<script>window.location.href = '".CARPETA_PROYECT."'</script>";
        // echo 'estas saliendope';
        
    }

     
}