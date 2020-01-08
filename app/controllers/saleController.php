<?php 
use Peru\Http\ContextClient;
use Peru\Jne\{Dni, DniParser};
use Peru\Sunat\{HtmlParser, Ruc, RucParser};

class SaleController extends Controller{
    
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

    public function buscarproduct(){
        $post = json_decode(file_get_contents("php://input"), true);
        $code = $post['code'];
        $cantidad = $post['cantidad'];
        $product = SaleModel::searchproduct($code);
        if($product){
            $datanew =[];
            $datanew = array_merge($product,array('cantidad' => $cantidad),array('enable' => 0));
            // $datanew = array_merge($product,array('enable' => 0)); 
            echo json_encode($datanew);
        }else{

            echo json_encode($product);
        }
    }

    public function allproductslist(){
        
        $all = SaleModel::allproductslistpe();
        $newdat =[];
        for ($i=0; $i < count($all) ; $i++) { 
            $newdat[$i] = $all[$i]; 
            $newdat[$i] = array_merge($newdat[$i],array('cantidad' => 1));
            $newdat[$i] = array_merge($newdat[$i],array('enable' => 1));
            // array_push($newdat[$i],'cantidad'); 
        }
        header('Content-Type: application/json; charset=utf-8'); 
        // header('Access-Control-Allow-Origin: *');

        echo json_encode($newdat); 
    }
    // Buscando a cliente por Tipo Doc y Doc
    public function searchclient(){
        $post = json_decode(file_get_contents("php://input"), true);
        $tipoDoc = $post['tipoDoc'];
        $numDoc = $post['numDoc'];
        $getclient = SaleModel::getClient($tipoDoc,$numDoc);
        if($getclient){
            echo json_encode($getclient);
        }else{
            switch ($tipoDoc) {
                case '1':
                    $doc = 'DNI';
                    $cs = new Dni(new ContextClient(), new DniParser()); 
                    $person = $cs->get($numDoc);
                    if (!$person) {
                        echo json_encode('Not found');
                        exit();
                    } 
                    echo json_encode(compact('person','doc'));
                    break;
                case '2':
                    // if(strlen($numDoc) != 11) {echo json_encode('NO tiene la longitud correcta'); return;}
                    $doc = 'RUC';
                    $cs = new Ruc(new ContextClient(), new RucParser(new HtmlParser())); 
                    $company = $cs->get($numDoc);
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

    

    public function guardarventa(){//Falta hacer que registre
        $post = json_decode(file_get_contents("php://input"), true);
        // CLIENTE ------------------------------------------------------
        $tipo_doc_select = $post['tipo_doc_select'];
        $num_doc = $post['num_doc'];
        $razon_social_nom = $post['razon_social_nom'];
        $direccion = $post['direccion'];
        $ubigeoselected = $post['ubigeoselected'];
        $idcliente = $post['idcliente']; 
        // Si no esta registrado el cliente aqui lo registramos automaticamente
        if($idcliente == ''){ 
            $insertNewClient = SaleModel::addcustomer_mod($tipo_doc_select,$num_doc, ucwords(strtolower($razon_social_nom)),
            $direccion,$ubigeoselected);
            $idcliente = $insertNewClient;
        }
        // echo json_encode(compact('ubigeoselected')); die();
        // USUARIO O VENDEDOR
        $usuario_id = 30;
        //----------------------------------------------------------------
        // DATO - VENTA --------------------------------------------------
        $listCompras =$post['listCompras'];
        $num_serie = $post['num_serie'];
        $grabada = $post['grabada'];
        $descuent_total = $post['descuent_total'];
        $imp_igv = $post['imp_igv'];
        $imp_total = $post['imp_total'];
        $letra_numero = $post['letra_numero'];
        $tipocomprobante = $post['tipocomprobante']; // 1 = Factra, 2 = Boleta
        //-----------------------------------------------------------------
        $tipo_save = $post['tipo_save']; 
        //-----------------------------------------------------------------
        //OBTENEMOS EL ULTIMO SERIE-NUMERO---------------------------------
        $ultimoserienumero = SaleModel::getnumberserie($tipocomprobante);
        $serieReal=''; // Para B001 o F001 
        $numSerieReal = ''; // Aqui esta el 0000002 irá aumentando segun se genere el documento
        if($ultimoserienumero){
            // $venta_id = $ultimoserienumero['id'];
            $serieN = (int) ($ultimoserienumero['numero']) + 1;
            $serieS = $ultimoserienumero['serie'];
            $ceros ='';
            if((8 - strlen($serieN)) > 0){
                for ($i=0; $i < (8 - strlen($serieN)) ; $i++) { 
                    $ceros .=0;
                }
                $serieReal = $serieS;
                $numSerieReal =$ceros.$serieN; 
            }else{
                $newserie = (int) substr($serieS,1,3) + 1;
                // Para B001 o F001 eso ira aumentando x999 maximo
                for ($i=0; $i < (3 - strlen($newserie)) ; $i++) {  
                    $ceros .=0;
                }
                $serieReal =substr($ultimoserienumero['serie'],0,1).$ceros.$newserie;
                $numSerieReal = "00000001";
            }
        }else{
            // $venta_id = 1;
            $serieReal = $num_serie;
            $numSerieReal ="00000001"; 
        }
        // Probando la parte de F001-00000001 or B001-00000001 | F999-999999999 or B999-999999999
        // echo json_encode(compact('numSerieReal','serieReal','descuent_total','idcliente'));
        // die();
        //------------------------------------------------------------------------------
        // PARA LA FACTURACION ELECTRONICA
        $codigo_hash = "ALFMKefmakfmalmkf=";
        $xml = 'None';
        $cdr = 'None';
        $sunat = 'None'; 
        $pdf_A4 = "None_url"; 
        $pdf_ticket = "None_url"; 
        $estado = "Aceptado";
        //--------------------------------------------------------------------------------
        // OBTENIENDO LOS PRODUCTOS EL ID Y LA CANTIDAD, PARA PODER RESTAR AL STOCK DE LA TABLA PRODUCTOS
        $prod_cant =[] ;
        for ($i=0; $i < count($listCompras) ; $i++) {
        //     $prod_cant[$i]=  array();
            $upstockprod = SaleModel::stockproduct($listCompras[$i]['cantidad'],$listCompras[$i]['id']); 
        } 
        // echo json_encode(($listCompras)); die();
        //-----------------------------------------------------------------------------------------
        // INSERTANDO LOS DATOS DE LA VENTA Y PRODUCTOS
        $setventa = SaleModel::setventa($serieReal,$numSerieReal,$codigo_hash,$xml,$cdr,$sunat,
                    json_encode($listCompras,true),$grabada,$descuent_total,$imp_igv,$imp_total,$letra_numero,
                    $pdf_A4,$pdf_ticket,$usuario_id,$tipocomprobante,$idcliente,$estado); 
        $set_c_venta = SaleModel::ncompraclient($idcliente);
        //-----------------------------------------------------------------------------------------
        $ok = 'ok'; $error = 'error';
        if($setventa == 'error' || $set_c_venta == 'error'){ echo json_encode(compact('error')); }
        $path_doc = URL_L."pdf/comprobante/${serieReal}/${numSerieReal}";
        switch ($tipo_save) {
            case 'firmarImprimir': 
                $estado_envio = "Proceso Completado";
                $estado_guardado ="El Documento N°: <b><b> {$serieReal}-{$numSerieReal} </b></b>, se firmó correctamente.
                Sin embargo recuerda que aún no ha sido enviado a sunat.";
                $pdf = "<div class='row justify-content-center'> <a href='${path_doc}/a4' target='_blank' class='col-md-3'> <img src='".IMAGES."pdf.svg"."' class='img-fluid' width='50px' ><p><small> A4 - PDF </small></p> </a>";
                $ticket = "<a href='${path_doc}/ticket' target='_blank' class='col-md-3' > <img src='".IMAGES."ticket.svg"."' class='img-fluid' width='50px'> <p><small> Ticket - PDF </small></p> </a> </div>";
                $message = "Hash CPE: xLJLsU/0RNDZtip80b0atVisWZQ=";
                
                echo json_encode(compact('estado_envio','estado_guardado','message','pdf','ticket','ok'));
                break;
            case 'enviarSunat':
                $estado_envio = "Envio Correcto!";
                $estado_guardado = "El Resumen diario RC-20191125-1, ha sido aceptado";
                $pdf = "<div class='row justify-content-center'> <a href='${path_doc}/a4' target='_blank' class='col-md-3'> <img src='".IMAGES."pdf.svg"."' class='img-fluid' width='50px' ><p><small> A4 - PDF </small></p> </a>";
                $ticket = "<a href='${path_doc}/ticket' target='_blank' class='col-md-3' > <img src='".IMAGES."ticket.svg"."' class='img-fluid' width='50px'> <p><small> Ticket - PDF </small></p> </a> </div>";
                $message = "";
                echo json_encode(compact('estado_envio','estado_guardado','message','pdf','ticket','ok'));
                break;
            case 'soloGuardar': 
                $estado_envio = "Proceso Completo";
                $estado_guardado = "Se guardó correctamente el documento: <b><b>{$serieReal}-{$numSerieReal}</b></b>";
                $pdf = "<div class='row justify-content-center'> <a href='${path_doc}/a4' target='_blank' class='col-md-3'> <img src='".IMAGES."pdf.svg"."' class='img-fluid' width='50px' ><p><small> A4 - PDF </small></p> </a>";
                $ticket = "<a href='${path_doc}/ticket' target='_blank' class='col-md-3' > <img src='".IMAGES."ticket.svg"."' class='img-fluid' width='50px'> <p><small> Ticket - PDF </small></p> </a> </div>";
                $message = "<b><b>RECUERDA:</b></b> El documento no ha sido enviado a SUNAT, por tanto usted debe enviarlo utilizando la pantalla de reporte de documentos!";
                echo json_encode(compact('estado_envio','estado_guardado','message','pdf','ticket','ok'));
                break;
            
            default:
                # code...
                break;
        }

        

    }

    
}