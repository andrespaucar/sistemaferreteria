<?php 

class saleallController extends controller{
    
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

    // Traemos los registros
    public function allsalesvouchers(){
        $all = SaleModel::allsalespe();
        // header('Content-Type: application/json; charset=utf-8'); 
        echo json_encode($all); 
    }
}