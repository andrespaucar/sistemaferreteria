<?php

 
// header('Access-Control-Allow-Origin: http://localhost/pos_pe/');
// header('Access-Control-Allow-Origin: *');
// header("Content-type: application/json; charset=utf-8");
class ProductsController extends Controller{
    
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
        VIEW::render();
    } 

    public function allunitymed(){ 
        $data = ProductModel::allUnityMedidas();
        echo json_encode($data);
    }

    // AGREMAMOS UN NUEVO PRODUCTO
    public function addproduct(){ 
        // $post = json_decode(file_get_contents("php://input"), true);
        $nameproduct = $_POST['nameproduct'];
        $codebarra = $_POST['codebarra'];
        $category_id = $_POST['category'];
        $unity_id = $_POST['unity'];
        $p_venta_sin = $_POST['precio_venta_sin'];
        $p_venta_in = $_POST['precio_venta_in'];
        $p_compra = $_POST['precio_compra'];
        $state = $_POST['state'];
        $stockinit = $_POST['stockinit'];
        $stockmin = $_POST['stockmin'];
        $data_u = now();
        // $image = $_FILES['image'];
        $nameImg = '';
        if(isset($_FILES['image'])){
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
            $nameImg = 'default.jpg';
        }
        $addData= ProductModel::addproduct($nameproduct,$codebarra,$nameImg,$stockinit,$stockmin,$p_venta_sin,$p_venta_in,$p_compra,$state,$unity_id,$category_id,$data_u);
        if($addData == 'ok'){
            if($nameImg != 'default.jpg'){
                move_uploaded_file($_FILES['image']['tmp_name'], UP_PRODUTS.$nameImg );
                // return;
            }
            echo json_encode('ok');
        }else{

            echo json_encode("error");
        }
    }

    // OBTENEMOS TODOS LOS PRODUCTOS PARA LA TABLA
    public function allproducts(){
        $data = ProductModel::allproductsp();
        echo json_encode($data);
    }

    // ELIMINANDO UN PRODUCTO
    public function deleteproduct(){
        $post = json_decode(file_get_contents("php://input"), true);
        $id = $post['id'];
        $image = $post['image']; 
        $del = ProductModel::delproduct($id);
        if($del == 'ok'){
            if($image != 'default.jpg'){
                unlink(UP_PRODUTS.$image);
            }
            echo json_encode('ok');
        }else{
            echo json_encode('Error al Eliminar');
        }
    }

    // ACTUALIZANDO EL STOCK | Tmabien se actualizara el STOCK INICIAL junto al Stock_Actual
    public function updatestocksum(){
        $post = json_decode(file_get_contents("php://input"), true);
        $id = $post['id'];
        $newStockSum = $post['stocksum'];
        $datup = ProductModel::updateStock($id, $newStockSum);
        if($datup){
            echo json_encode('ok');
        }else{
            echo json_encode('error');
        }
    }

    // Mostrar Producto Actualizado
    public function product($id){
        $getpro = ProductModel::getProduct($id);
        echo json_encode($getpro);

    }

    public function changeState(){
        $post = json_decode(file_get_contents("php://input"), true);
        $id = $post['id'];
        $state = $post['state'];
        $upd = ProductModel::updatestateproduct($id,$state);
        if($upd == 'ok'){
            echo json_encode('ok');
        }else{
            echo json_encode('error');
        }
    }

    
}