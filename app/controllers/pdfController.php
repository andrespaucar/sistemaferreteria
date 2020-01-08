<?php 
use Dompdf\Dompdf;
use Dompdf\Options;

class pdfController extends Controller{

    public function index(){
        // VIEW::render();
        $html = "<h1> y as</h1>";
        $pdf = new Dompdf();
        $pdf->set_paper("A4","portrait");
        $pdf -> loadHtml(utf8_decode($html));

        $pdf -> render();
        $pdf -> stream('dompdf.pdf',array("Attachment" => 0));
        exit(0);
    }
    // IMPRIMIR CODE BARRA PDF
    public function imcodeproduct($code = null,$cantidad = null,$rcolor = null){ 
        $r;$g;$b;
        switch ($rcolor) {
            case '000000':
                $r = 0; $g = 0 ; $b  = 0;
                break; 
            case '007bff':
                $r = 0; $g = 69; $b  = 255;
                break; 
            case 'dc3545':
                $r = 220 ; $g = 53  ; $b  = 69;
                break; 
            default: 
                break;
        }
        $linksrc = "http://localhost/pos_pe/app/libs/barcode/barcode.php?text={$code}&size=40&print=true&sizefactor=1&r={$r}&g={$g}&b={$b}";
        // $linksrc = "";
        
        $html = '<html> <title>Codigo de Barra</title> <head> '.
        '</head><body>  <div style="text-align:center;margin-top:10px;margin-botton:10px;">';
        for ($i=0; $i < $cantidad; $i++) { 
            $html .= '<img  src='."'$linksrc'".'  />'; 
            // $html .= '<h1> '.$rcolor.'</h1>';
        }
        $html .= '</div>  '.
                '</body></html>';
         
        $options = new Options();
        $options->set('enable_remote', true);
        $options->set('isJavascriptEnabled', true);
        $options->set('javascript-delay', 3000);
        $options->set('enable-smart-shrinking', true);
        $options->set('no-stop-slow-scripts', true);
        $pdf = new Dompdf($options);
        // $pdf -> loadHtml(($html));
        
        $pdf->load_html($html);
        $pdf -> set_paper(array(0,0,250,800));
        // $pdf->set_paper("A4","portrait");

        $pdf -> render();
        $pdf -> stream('dom.pdf',array("Attachment" => 0,'isJavascriptEnabled', true));
   
    }

    // Factura y Boleta PDF_A4 AND Tikect| Tipo_Pdf = a4 or ticket
    public function comprobante($serie =null,$numero = null,$tipo_pdf= null){
        include_once "app/libs/phpqrcode/qrlib.php";
        // error_reporting(0);// Desabilitamos la notificacion: 
        $data_empresa = PdfModel::dataEmpresa();
        $data_comprobante = PdfModel::pdfcomprobantedata(ucwords($serie),$numero);
        // var_dump(($data_comprobante)); die();
        
        if(!$data_empresa  || !$data_empresa){echo "<h2>No se Encontro Documento: ".ucwords($serie)."-$numero </h2>"; return;};
        $options = new Options();
        // $options->set('isRemoteEnabled',true); 
        $options->set('enable_remote',true); 
        $dompdf = new Dompdf($options);
        // Si el PDF es A4
        if($tipo_pdf == 'a4'){
            $dompdf -> loadHtml($this->cargandohtmlpdf($data_empresa,$data_comprobante));
            // $dompdf->setPaper('A4', 'landscape');
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();
            $dompdf->stream("deaf.pdf", array("Attachment" => false));
        }
        elseif($tipo_pdf == 'ticket'){
            $dompdf -> loadHtml($this->cargandoticket($data_empresa,$data_comprobante)); 
            $dompdf->setPaper(array(0,0,260,1000));
            $dompdf->render();
            $dompdf->stream("deaf.pdf", array("Attachment" => false));
        }
    }
    // PDF A4
    public function cargandohtmlpdf($dataEmpresa, $dataComprobante){
        /* QR */
        $dir = 'public/images/tempQR/';
        $filename = $dir.'test.png';
        $tamaño = 3; //Tamaño de Pixel
        $level = 'M'; //Precisión Baja
        $framSize = 3; //Tamaño en blanco
        $total_en_igv  = "1521";
        // Para nuestro Caso nos falta enviar un ultimo Parametro que es "VALOR_RESUMEN" encontrado en : <ds:DigestValue></ds:DigestValue>
        $contenido =    "{$dataEmpresa['ruc']}|".
                        "{$dataComprobante['code_sunat_comprobante']}|".
                        "{$dataComprobante['serie']}|".
                        intval($dataComprobante['numero']). 
                        "|{$dataComprobante['total_igv']}|".
                        "{$dataComprobante['total']}|".
                        substr($dataComprobante['fecha_emision'],0,10). 
                        "|{$dataComprobante['tipo_doc_cliente']}|".
                        "{$dataComprobante['num_doc']}";
        //Texto
        QRcode::png($contenido, $filename, $level, $tamaño, $framSize); 
        /* */ 

        $html = file_get_contents(URL_L."/resources/views/pdf/index.html");
        $html = str_replace('{{tipo_doc}}', $dataComprobante['comprobante'], $html); // Title
        // Data Empresa
        $html = str_replace('{{logo}}',URL_L."/public/uploads/company/{$dataEmpresa['logo']}", $html); 
        $html = str_replace('{{ruc}}',$dataEmpresa['ruc'], $html); 
        $html = str_replace('{{razon_social}}',$dataEmpresa['razon_social'], $html);  
        $html = str_replace('{{direccion}}',$dataEmpresa['direccion_fiscal'], $html); 
        $html = str_replace('{{telefono}}',$dataEmpresa['telefono'], $html); 
 
        // DATA VENTA
        $html = str_replace('{{serie_numero}}',"{$dataComprobante['serie']}-{$dataComprobante['numero']}", $html); 
        $html = str_replace('{{cliente}}',$dataComprobante['dato_cliente'], $html); 
        $html = str_replace('{{num_doc_cliente}}',$dataComprobante['num_doc'], $html); 
        $html = str_replace('{{fecha_emision}}',$dataComprobante['fecha_emision'], $html); 
        $html = str_replace('{{direccion_cliente}}',$dataComprobante['direccion_cliente'], $html); 
        $html = str_replace('{{moneda}}',"SOLES", $html); 

        // PRODUCTOS
        $str_productos ='';
        $productospe =  json_decode($dataComprobante['productos_vendidos']);
        foreach( $productospe as $key => $value){
            $str_item = file_get_contents(URL_L."/resources/views/pdf/productos.html");
            $str_item = str_replace("{{cantidad}}",$value->cantidad,$str_item);
            $str_item = str_replace("{{code_cantidad}}",$value->simbolo,$str_item); //code or simbolo
            $str_item = str_replace("{{codigo_producto}}",$value->codigo,$str_item);
            $str_item = str_replace("{{valor_unitario}}",$value->p_venta_sin,$str_item);
            $str_item = str_replace("{{descripcion}}",$value->name,$str_item);
            $str_item = str_replace("{{valor_total}}",$value->p_venta_sin * $value->cantidad,$str_item);
            $str_productos = $str_productos.$str_item;
        } 

        $html = str_replace('{{productos}}',$str_productos,$html);

        $html = str_replace('{{texto_total}}',$dataComprobante['total_en_letras'], $html); 
        $html = str_replace('{{pago}}',"Efectivo", $html); 
        
        $html = str_replace('{{vendedor}}',"{$dataComprobante['vendedor_nombre']} {$dataComprobante['vendedor_apellido']}", $html); 
        
        $html = str_replace('{{gravada}}',"S/. ".$dataComprobante['grabada'], $html); 
        $html = str_replace('{{igv}}',"S/. ".$dataComprobante['total_igv'], $html); 
        
        $html = str_replace('{{descuento}}',"S/. ".$dataComprobante['descuento'], $html);
      
        $html = str_replace('{{total_pagar}}',"S/. " . $dataComprobante['total'], $html); 
        $html = str_replace('{{code_hash}}',"qqnr2dN4p/HmaEA/CJuVGo7dv5g=", $html); 
        $html = str_replace('{{code_qr}}',$dir.basename($filename), $html);  

        return $html;
    }

    // Tiket
    public function cargandoticket($dataEmpresa, $dataComprobante){
        /* QR */
        $dir = 'public/images/tempQR/';
        $filename = $dir.'test.png';
        $tamaño = 3; //Tamaño de Pixel
        $level = 'M'; //Precisión Baja
        $framSize = 2; //Tamaño en blanco
        $total_en_igv  = "1521";
        // Para nuestro Caso nos falta enviar un ultimo Parametro que es "VALOR_RESUMEN" encontrado en : <ds:DigestValue></ds:DigestValue>
        $contenido =    "{$dataEmpresa['ruc']}|".
                        "{$dataComprobante['code_sunat_comprobante']}|".
                        "{$dataComprobante['serie']}|".
                        intval($dataComprobante['numero']). 
                        "|{$dataComprobante['total_igv']}|".
                        "{$dataComprobante['total']}|".
                        substr($dataComprobante['fecha_emision'],0,10). 
                        "|{$dataComprobante['tipo_doc_cliente']}|".
                        "{$dataComprobante['num_doc']}";
        //Texto
        QRcode::png($contenido, $filename, $level, $tamaño, $framSize); 
        // $svg = QRcode::svg("efafaef"); 
        /* */ 
        $html = file_get_contents(URL_L."/resources/views/pdf/index_ticket.html");

        // Data Empresa
        $html = str_replace('{{logo}}',URL_L."/public/uploads/company/{$dataEmpresa['logo']}", $html);
        $html = str_replace('{{ruc}}',$dataEmpresa['ruc'], $html); 
        // $html = str_replace('{{razon_social}}',$dataEmpresa['razon_social'], $html);  
        $html = str_replace('{{direccion}}',$dataEmpresa['direccion_fiscal'], $html); 
        $html = str_replace('{{telefono}}',$dataEmpresa['telefono'], $html); 
        $html = str_replace('{{email}}',$dataEmpresa['email'], $html); 

        // DATA VENTA
        $html = str_replace('{{tipo_doc}}', $dataComprobante['comprobante'], $html); // Title
        $html = str_replace('{{serie_numero}}',"{$dataComprobante['serie']}-{$dataComprobante['numero']}", $html); 
        $html = str_replace('{{cliente}}',$dataComprobante['dato_cliente'], $html); 
        $html = str_replace('{{num_doc_cliente}}',$dataComprobante['num_doc'], $html); 
        $html = str_replace('{{fecha_emision}}',$dataComprobante['fecha_emision'], $html); 
        $html = str_replace('{{direccion_cliente}}',$dataComprobante['direccion_cliente'], $html); 
        $html = str_replace('{{moneda}}',"SOLES", $html); 

        // PRODUCTOS
        $str_productos ='';
        $productospe =  json_decode($dataComprobante['productos_vendidos']);
        foreach( $productospe as $key => $value){
            $str_item = file_get_contents(URL_L."/resources/views/pdf/productos_ticket.html");
            $str_item = str_replace("{{cantidad}}",$value->cantidad,$str_item);
            $str_item = str_replace("{{code_cantidad}}",$value->simbolo,$str_item); //code or simbolo
            $str_item = str_replace("{{codigo_producto}}",$value->codigo,$str_item);
            $str_item = str_replace("{{valor_unitario}}",$value->p_venta_sin,$str_item);
            $str_item = str_replace("{{descripcion}}",$value->name,$str_item);
            $str_item = str_replace("{{valor_total}}",$value->p_venta_sin * $value->cantidad,$str_item);
            $str_productos = $str_productos.$str_item;
        } 
        $html = str_replace('{{productos}}',$str_productos,$html);

        $html = str_replace('{{gravada}}',"S/. ".$dataComprobante['grabada'], $html);
        $html = str_replace('{{descuento}}',"S/. ".$dataComprobante['descuento'], $html);
        $html = str_replace('{{igv}}',"S/. ". $dataComprobante['total_igv'], $html); 
        $html = str_replace('{{total_pagar}}',"S/. " . $dataComprobante['total'], $html); 

        $html = str_replace('{{texto_total}}',$dataComprobante['total_en_letras'], $html); 
        $html = str_replace('{{pago}}',"Efectivo", $html); 
        
        $html = str_replace('{{vendedor}}',"{$dataComprobante['vendedor_nombre']} {$dataComprobante['vendedor_apellido']}", $html); 
    

        $html = str_replace('{{code_qr}}',$dir.basename($filename), $html);
        $html = str_replace('{{comprobante}}',"Factura", $html);
        $html = str_replace('{{code_hash}}',"ASdafasfafaskm=", $html); 
        return $html;
    }
}