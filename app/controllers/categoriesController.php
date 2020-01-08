<?php
  
class CategoriesController extends Controller{

    public function __construct() {
        parent::__construct();
    }
    public function index(){
        if(isset($_SESSION['perfil'])){
            if($_SESSION['perfil'] == 'vendedor' ){
                echo "<script> window.location.href = '".CARPETA_PROYECT."sale' </script>";
            }
        }else{
            echo "<script> window.location.href = '".CARPETA_PROYECT."' </script>";
        }
        View::render('index');
    }

    public function all(){
        $data = CategoryModel::allcategories();
        echo json_encode($data);
    }
    public function allreal(){
        $data = CategoryModel::allcategories(true);
        echo json_encode($data);
    }
    public function deletecategory(){
        $post = json_decode(file_get_contents("php://input"), true);
        $id = $post['id'];
        $del = CategoryModel::delupCategory($id);
         
        if($del == 'ok'){
            echo json_encode('ok');
        }elseif($del == 'cat_con_product'){
            echo json_encode($del);
        }
        else{
            echo json_encode('error');
        }
    }

    public function updatecategory(){
        $post = json_decode(file_get_contents("php://input"), true);
        $id = $post['id'];
        $name = $post['name'];
        $description = $post['description'];
        $up = CategoryModel::upCategory($id,$name,$description);
        if($up == 'ok'){
            echo json_encode('ok');
        }else{
            echo json_encode('error');
        }
    }

    public function upstate(){
        $post = json_decode(file_get_contents("php://input"), true);
        $id = $post['id'];
        $upstate = CategoryModel::delupCategory($id,true);
        if($upstate == 'ok'){
            echo json_encode('ok');
        }else{
            echo json_encode('Error al Cambiar el Estado');
        }
    }

    public function addcategory(){
        $post = json_decode(file_get_contents("php://input"), true);
        $newname = $post['newname'];
        $newdescription = $post['newdescription'];
        $state = 1;
        $add = CategoryModel::addCategory($newname,$newdescription,$state);
        if($add == 'ok'){
            echo json_encode('ok');
        }else{
            echo json_encode('error');
        } 
    }
}