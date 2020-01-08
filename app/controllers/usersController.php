<?php 

class UsersController extends Controller{

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
        
        View::render();
    } 

    public function showUsers(){
        // $data = UsersModel::getusers();
        $datUsers = UsersModel::getusers();
        // ESTO ES PARA JQUERY DATATABEL
        /*$dataJson = '[';
       
        for ($i=0; $i < count($datUsers); $i++) { 
            $acciones = "<button class='btn btn-danger btn-sm btndeluser' idusuario =".$datUsers[$i]['id']."> DEL</button>".
                        "<button class='btn btn-warning btn-sm' > EDIT</button>";

             $dataJson .='[
            "'.($i+1).'",
            "'.$datUsers[$i]['nombre'].'",
            "'.$datUsers[$i]['usuario'].'",
            "'.$datUsers[$i]['password'].'",
            "'.$datUsers[$i]['rol_id'].'",
            "'.$datUsers[$i]['foto'].'",
            "'.$datUsers[$i]['ultimo_login'].'",
            "'.$acciones.'"
        ],';
        }
        
        $dataJson = substr($dataJson, 0, -1);
        $dataJson .=']';
        echo $dataJson;*/
        // echo json_encode($data);
        echo json_encode($datUsers) ;
    }

    public function show($parm = null,$sci=null){
        
        View::render('show');
        
    }
    public function delete(){
        $id = $_POST['id'];
        $foto = $_POST['foto'];
        // echo json_encode( $id);
        $del = UsersModel::deleteUser($id);
        if($del == 'ok'){
            if($foto != 'default.jpg'){
                unlink(UP_USERS.$foto); // Eliminado la imagen
            }
            echo json_encode('Usuairo Eliminado');
        }else{
            echo json_encode('Error Al eliminar');
        }
            
        // echo json_encode($id) ;
    }

    public function add(){
        $usuario = $_POST['user'];
        $name = $_POST['name'];
        $surname = $_POST['surname'];
        $pass = $_POST['pass'];
        // $foto = $_FILES['image']['name']; // Por que tendra otro nombre
        $mobile = $_POST['mobile'];
        $rol_id = $_POST['selected'];
        $estado = 1;
        $nameImg ='';
        if(isset($_FILES['image']['name'])){
            if($_FILES['image']['size'] < 2048000){ //2048000 = 2M
                if($_FILES['image']['type'] == 'image/png'){
                    $nameImg = date('his').'.png';
                }
                if($_FILES['image']['type'] == 'image/jpeg' || $_FILES['image']['type'] == 'image/jpg'){
                    $nameImg = date('his').'.png';
                }
                
            }else{
                echo json_encode('Imagen pesa mucho');
                return;
            } 
        }else{
            $nameImg = "default.jpg";
        }
        // Agragando al Usuario 
        $addu = UsersModel::addUser($usuario,$name,$surname,$pass,$nameImg,$mobile,$estado,$rol_id);
        //Subiendo la img
        if($addu == 'ok'){
            // UP_USERS = public/uploads/users/
            if($nameImg != "default.jpg"){
                move_uploaded_file($_FILES['image']['tmp_name'], UP_USERS.$nameImg );
            }
            echo json_encode('ok');
        }else{
            echo json_encode('error');
        }
        // echo json_encode('ok');
    }

    public function updatestate(){
        $id = $_POST['id'];
        $state = $_POST['state'];
        $upState= UsersModel::updatestate($id, $state);
        if($upState == 'ok'){
            echo json_encode('Estado Actualizado'); 
        }else{
            echo json_encode('Error al Acualizar estado');
        }
    }

    public function updateuser(){
        $id = $_POST['iduser'];
        $newuser = $_POST['newuser'];
        $newname = $_POST['newname'];
        $newsurname = $_POST['newsurname'];
        $newpassword = $_POST['newpassword']; 
        $newmobile = $_POST['newmobile'];
        $newrolid = $_POST['selectedu'];
        $newstate = $_POST['newstate'];
        $anteriorfoto = $_POST['anteriorfoto'];
        $newfoto =''; 
        // $img = $_FILES['newimg']['name'];
        if(isset($_FILES['newimg']['name'])){
            // echo json_encode($_FILES['newimg']['name']);
            if($_FILES['newimg']['size'] < 2048000){ //2048000 = 2M
                if($_FILES['newimg']['type'] == 'image/png'){
                    $newfoto = date('his').'.png';
                }
                if($_FILES['newimg']['type'] == 'image/jpeg' || $_FILES['newimg']['type'] == 'image/jpg'){
                    $newfoto = date('his').'.png';
                }
                // Eliminamos la IMG anterior
                unlink(UP_USERS.$anteriorfoto);
                
            }else{
                echo json_encode('Imagen pesa mucho');
                return;
            }
            
        }else{
            $newfoto = $anteriorfoto;
            // echo json_encode($anteriorfoto);
        } 
        $upuser = UsersModel::updateUser($id,$newuser,$newname,$newsurname,$newpassword,$newfoto,$newmobile,$newstate,$newrolid);
        if($upuser == 'ok'){
            if(isset($_FILES['newimg']['name'])){
                move_uploaded_file($_FILES['newimg']['tmp_name'], UP_USERS.$newfoto );
            }
            echo json_encode('ok');
        }else{
            echo json_encode('error');
        }
    }

    public function allrols(){
        $dat = UsersModel::rols();
        echo json_encode($dat);
    }
 

    
}