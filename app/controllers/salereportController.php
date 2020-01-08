<?php 

class SalereportController extends controller{
    
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

    public function reportdate(){
        error_reporting(0);// Desabilitamos la notificacion: 
        //Notice: Undefined index: 2019-07 in C:\xampp\htdocs\pos_pe\app\controllers\salereportController.php on line 29
        $post = json_decode(file_get_contents("php://input"), true);
        $fechaincial = $post['fechaIni'];
        $fechaFinal = $post['fechaFin'];
       
            $data_report = SaleReportModel::getreport($fechaincial,$fechaFinal);
            $arrayFechas = array();
            $arrayVentas = array();
            $sumaPagosMes = array();
            foreach ($data_report as $key => $value) { 
                #Capturamos sólo el año y el mes
                $fecha = substr($value["awomes"],0,7); 
                #Introducir las fechas en arrayFechas
                array_push($arrayFechas, $fecha); 
                #Capturamos las ventas
                $arrayVentas = array($fecha => $value["sale"]); 
                #Sumamos los pagos que ocurrieron el mismo mes
                foreach ($arrayVentas as $key => $value){
                    $sumaPagosMes[$key] += $value;
                }
            }
            $noRepetirFechas = array_unique($arrayFechas);
             
            $data = [];$e =0;
            foreach($noRepetirFechas as $key){
                $data[$e] = array();
                $data[$e] = array_merge($data[$e],array('awomes' =>$key));
                $data[$e] = array_merge($data[$e],array('sale' => round($sumaPagosMes[$key]) ));
                $e++;
            } 
            // header('Content-Type: application/json'); 
            echo json_encode(compact('data','fechaincial','fechaFinal'));
    }

    public function descargareporte($formato,$feinit = null,$fefin = null){
        if($feinit !== null && $fefin !== null){
            $feinit = str_replace('t','-',$feinit);
            $fefin = str_replace('t','-',$fefin);
        }
        $data_report = SaleReportModel::excelandpfgreport($feinit,$fefin); 
        // var_dump($feinit,$fefin); die();
        if($formato == 'excel'){
            header('Expires: 0');
            header('Cache-control: private');
            header("Cache-Control: cache, must-revalidate"); 
			header('Content-Description: File Transfer');
            header('Last-Modified: '.date('D, d M Y H:i:s'));
            header("Pragma: public");
            header('Content-Type: application/xls');
            header('Content-Disposition: attachment; filename=reporteVentas.xls');
            header("Content-Transfer-Encoding: binary");
            $html ="<style> .center{text-align:center} .left{text-align:left} .right{text-align:right} .thtable{font-weight:bold; border:1px solid #eee;} .trbody{border:1px solid #eee;}</style>
                <table>
                    <tr>
                        <th class = 'thtable'>SERIE - NUMERO</th> 
                        <th class = 'thtable'>CLIENTE</th> 
                        <th class = 'thtable'>VENDEDOR</th> 
                        <th class = 'thtable'>CANTIDAD</th> 
                        <th class = 'thtable'>PRODUCTOS</th> 
                        <th class = 'thtable'>GRABADA</th> 
                        <th class = 'thtable'>DESCUENTO</th> 
                        <th class = 'thtable'>TOTAL_IGV</th> 
                        <th class = 'thtable'>TOTAL</th> 
                        <th class = 'thtable'>FECHA</th> 
                    </tr>";
            foreach($data_report  as $key => $value):
                $html .= "<tr>
                            <td class='trbody' >{$value['serie']} - {$value['numero']}</td> 
                            <td class='trbody' >{$value['cliente']}</td> 
                            <td class='trbody' >{$value['vendedor_nombre']} {$value['vendedor_apellido']}</td> ";
                $html .= "<td class='trbody' >";
                    foreach(json_decode($value['productos_vendidos'],true) as $key => $valuecantidad){
                        $html .= "{$valuecantidad['cantidad']} <br>";  
                    }
                    $html .= "</td> <td class='trbody' >";
                    foreach(json_decode($value['productos_vendidos'],true) as $key => $valueproducto){
                        $html .= "{$valueproducto['name']} <br>";  
                    }
                $html .= "</td>";
                $html .= "          
                            <td class='trbody' style='text-align:center' >{$value['grabada']}</td> 
                            <td class='trbody' style='text-align:center' >{$value['descuento']}</td> 
                            <td class='trbody' style='text-align:center' >{$value['total_igv']}</td> 
                            <td class='trbody' style='text-align:center' >".$value['total']."</td> 
                            <td class='trbody' >".substr($value['created_at'],0,11)."</td> 
                        </tr>";                
            endforeach;

            $html .= "</table>"; 
            echo utf8_decode($html);
        }else{
            echo 'gogo';
        }
        
        // if($fechaI == '' && $fechaF == '' ){
        //     $ventas = SaleReportModel::getreport($fechaI, $fechaF);
        // } else{
        //     $ventas = "No son datos nullos";
        // }
        // echo json_encode($ventas);
    }
    // Productos más vendidos
    public function reportProduct(){
        $prod_sale = SaleReportModel::maxventaproduct();
        echo json_encode($prod_sale);
    }

    public function reportclient(){
        error_reporting(0);// Desabilitamos la notificacion: 
        $client_report = SaleReportModel::maxventaclients();
        $arrayClientes = array();
        $arraylistaClientes = array(); $sumaTotalClientes = array();
        foreach($client_report as $key => $value){
            array_push($arrayClientes,$value['clientepe']); 
            $arraylistaClientes = array($value['clientepe'] => $value['cantidad'] * $value['totalporventa']);
            foreach($arraylistaClientes as $key => $value){
                $sumaTotalClientes[$key] += $value;
            }
        }
        $noRepetirCliente = array_unique($arrayClientes);
        $data = [];$e =0;  
        foreach($noRepetirCliente as $key){
            $data[$e] = array(); 
            $data[$e] = array_merge($data[$e],array('clientepe' => ucwords($key)));
            $data[$e] = array_merge($data[$e],array('total_compras' => round($sumaTotalClientes[$key],2) ));
            $e++;
        } 
        echo json_encode($data);



    }

    
    // Ventas del dia 
    public function salesoftoday(){
        // AQUI FALTA TRAER LOS DATOS DE SOLO ESE DIA!!!
        $tfactura = SaleReportModel::total_factura_boleta_dia(1);
        $tboleta = SaleReportModel::total_factura_boleta_dia(2);
        $totalpe = SaleReportModel::totaldeventadia();
        $data  = [
            "tfactura" => round($tfactura['total'],2),
            "tboleta" => round($tboleta['total'],2),
            "totalpe" => round($totalpe['total'],2)
        ];
        echo json_encode($data);
    }

    
}