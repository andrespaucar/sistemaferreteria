<?php 

class ApiSunatController extends Controller{

    // TIPOS DE DOCTUMENTOS DE IDENTIDAD
    public function tipodocitentidad(){
        header('Access-Control-Allow-Origin: *');
        header("Content-type: application/json; charset=utf-8");

        $data = [
            // ["id" => 1 , "tipodocidentidad" => "0", "nombre" => "DOC.TRIB.NO.DOM.SIN.RUC", "descripcion" => "DOC.TRIB.NO.DOM.SIN.RUC"],
            ["id" => 2 , "tipodocidentidad" => "1", "nombre" => "D.N.I", "descripcion" => "DOC. NACIONAL DE IDENTIDAD"],
            // ["id" => 3 , "tipodocidentidad" => "4", "nombre" => "CARNET DE EXTRANJERIA", "descripcion" => "CARNET DE EXTRANJERIA"],
            ["id" => 4 , "tipodocidentidad" => "6", "nombre" => "R.U.C", "descripcion" => "REG. UNICO DE CONTRIBUYENTES"],
            // ["id" => 5 , "tipodocidentidad" => "7", "nombre" => "PASAPORTE", "descripcion" => "PASAPORTE"],
            // ["id" => 6 , "tipodocidentidad" => "A", "nombre" => "CED. DIPLOMATICA DE IDENTIDAD", "descripcion" => "CED. DIPLOMATICA DE IDENTIDAD"],
            // ["id" => 7 , "tipodocidentidad" => "B", "nombre" => "DOC.IDENT.PAIS.RESIDENCIA-NO.D", "descripcion" => "DOC.IDENT.PAIS.RESIDENCIA-NO.D"],
            // ["id" => 8 , "tipodocidentidad" => "C", "nombre" => "TIN", "descripcion" => "Tax Identification Number - TIN – Doc Trib PP.NN"],
            // ["id" => 9 , "tipodocidentidad" => "D", "nombre" => "IN", "descripcion" => "Identification Number - IN – Doc Trib PP. JJ"],
        ]; 
        $all = ApiSunatModel::tipo_doc_sunat();
        echo json_encode($all);
    }

    // TIPO DE MONEDAS
    public function tipomonedas(){
        $data = [
            ['id' => 1, 'codigomoneda' => 'PEN', 'simbolo' => 'S/', 'nombre' => 'Soles'],
            ['id' => 2, 'codigomoneda' => 'USD', 'simbolo' => '$', 'nombre' => 'Dólares Americanos']
        ];
    }

    // TIPOS DE AFECTACION DE IGV
    public function tipoafectacionigv(){
        $data = [
            ["id" => 1 , "tipoafectacionigv" => "10", "descripcion" => "Gravado - Operación Onerosa"],
            ["id" => 2 , "tipoafectacionigv" => "11", "descripcion" => "[Gratuita] Gravado - Retiro por premio"],
            ["id" => 3 , "tipoafectacionigv" => "12", "descripcion" => "[Gratuita] Gravado - Retiro por donación"],
            ["id" => 4 , "tipoafectacionigv" => "13", "descripcion" => "[Gratuita] Gravado - Retiro"],
            ["id" => 5 , "tipoafectacionigv" => "14", "descripcion" => "[Gratuita] Gravado - Retiro por publicidad"],
            ["id" => 6 , "tipoafectacionigv" => "15", "descripcion" => "[Gratuita] Gravado - Bonificaciones"],
            ["id" => 7 , "tipoafectacionigv" => "16", "descripcion" => "[Gratuita] Gravado - Retiro por entrega a trabajadores"],
            ["id" => 8 , "tipoafectacionigv" => "20", "descripcion" => "Exonerado - Operación Onerosa"],
            ["id" => 9 , "tipoafectacionigv" => "30", "descripcion" => "Inafecto - Operación Onerosa"],
            ["id" => 10 , "tipoafectacionigv" => "31", "descripcion" => "[Gratuita] Inafecto - Retiro por Bonificación"],
            ["id" => 11 , "tipoafectacionigv" => "32", "descripcion" => "[Gratuita] Inafecto - Retiro"],
            ["id" => 12 , "tipoafectacionigv" => "33", "descripcion" => "[Gratuita] Inafecto - Retiro por Muestras Médicas"],
            ["id" => 13 , "tipoafectacionigv" => "34", "descripcion" => "[Gratuita] Inafecto - Retiro por Convenio Colectivo"],
            ["id" => 14 , "tipoafectacionigv" => "35", "descripcion" => "[Gratuita] Inafecto - Retiro por premio"],
            ["id" => 15 , "tipoafectacionigv" => "36", "descripcion" => "[Gratuita] Inafecto - Retiro por publicidad"],
            ["id" => 16 , "tipoafectacionigv" => "40", "descripcion" => "Exportación"],
            ["id" => 17 , "tipoafectacionigv" => "7152", "descripcion" => "Gravado - ICBPER"],
        ]; 
    }

    //TIPO DE CAMBIO : DOLARES A SOLES O SOLES A DOLARES
    public function tipocambio(){
        $data = [
            ["id" => 1 , "compra" => "3.342", "venta" => "3.345" ,"fecha" => "08/11/2019"]
        ];
    }
    // opteniendo todos los Ubigeos
    public function allubigeosunat(){
        $data = ApiSunatModel::getUbigeo();
        echo json_encode($data);
    }

    //----------------------------///
    



    /* get_sunat_tiponotacredito
        0: {id_tiponotacredito: "01", descripcion: "Anulación de la operación"}
        1: {id_tiponotacredito: "02", descripcion: "Anulación por error en el RUC"}
        2: {id_tiponotacredito: "03", descripcion: "Corrección por error en la descripción"}
        3: {id_tiponotacredito: "04", descripcion: "Descuento global"}
        4: {id_tiponotacredito: "05", descripcion: "Descuento por ítem"}
        5: {id_tiponotacredito: "06", descripcion: "Devolución total"}
        6: {id_tiponotacredito: "07", descripcion: "Devolución por ítem"}
        7: {id_tiponotacredito: "08", descripcion: "Bonificación"}
        8: {id_tiponotacredito: "09", descripcion: "Disminución en el valor"}
        9: {id_tiponotacredito: "10", descripcion: "Otros Conceptos"}



    */

    /* get_sunat_tiponotadebito
        0: {id_tiponotadebito: "01", descripcion: "Intereses por mora"}
        1: {id_tiponotadebito: "02", descripcion: "Aumento en el valor"}
        2: {id_tiponotadebito: "03", descripcion: "Penalidades/ otros conceptos"}
    */
}