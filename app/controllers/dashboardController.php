<?php 

class DashboardController extends Controller{
    public function __construct() {
        parent::__construct();
        // $_SESSION['perfil'] = 'vendedor';
        if(isset($_SESSION['perfil'])){
            if($_SESSION['perfil'] == 'vendedor' || $_SESSION['perfil'] == 'almacen' ){
                echo "<script> window.location.href = '".CARPETA_PROYECT."products' </script>";
            }
        }else{
            echo "<script> window.location.href = '".CARPETA_PROYECT."' </script>";
        }
    }
    public function index(){
        $users = UsersModel::countUsers();
        $produts = ProductModel::allproductsp('count');
        $cursomers = CustomersModel::countcustomers();
         // TRAENDO TOTAL DE FACTURA AND BOLETAS
  
        $tfactura = SaleReportModel::total_factura_boleta_anual(1);
        $tboleta = SaleReportModel::total_factura_boleta_anual(2);
        $totalpe = SaleReportModel::totaldeventanual();
        // var_dump($total); die();
        View::render('index',(object)compact('users','produts','cursomers','tfactura','tboleta','totalpe'));

        /*
        SELECT created_at FROM ventas WHERE created_at 
        BETWEEN DATE_SUB(NOW(), INTERVAL 12 MONTH) AND NOW() ORDER BY Id DESC
        */
    }

    public function ventasanual(){
        error_reporting(0);// Desabilitamos la notificacion: 
        $ventanual = SaleReportModel::getventasanual();
        $arrayFechas = array();
        $arrayVentas = array();
        $sumaPagosMes = array();
        foreach ($ventanual as $key => $value) { 
            #Capturamos sólo el año y el mes
            $fecha = substr($value["awomes"],0,7); 
            #Introducir las fechas en arrayFechas
            array_push($arrayFechas, $fecha); 
            #Capturamos las ventas
            $arrayVentas = array($fecha => $value["sale"]); 
            #Sumamos los pagos que ocurrieron el mismo mes
            foreach ($arrayVentas as $key => $value){
                $sumaPagosMes[$key] = round( $sumaPagosMes[$key] + $value,2)  ;
            }
        }
        $noRepetirFechas = array_unique($arrayFechas);
         // Esta parte agrega los CEROS para las feechas que no tiene ventas
         /// pero esto no se deve de hacer en produccion por que si se manda 5 datos para el array de 
         // 12 , solo se pintara lo que se manda, en otras palabras : los meses que se esta vendiendo,
         // ahora false, que desde la base de datos solo venda datos de ese año.   
        for ($i=0; $i < (12 - count($noRepetirFechas)) ; $i++) { 
            array_push($sumaPagosMes,0);
        }
 
        echo json_encode( $sumaPagosMes);
    }

    // public function totalventas(){
        
        
    // }
}