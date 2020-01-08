<?php 

class PdfModel extends Model{

    // Cargado Para el PDF BOLETA AND FACTURA
    public function pdfcomprobantedata($serie,$numero){
        $sql = "SELECT ventas.serie AS serie, ventas.numero AS numero, ventas.total_igv,ventas.grabada,
        ventas.productos_vendidos, ventas.descuento,ventas.total, ventas.total_en_letras, ventas.created_at AS fecha_emision,
        clientes.doc AS num_doc,clientes.direccion AS direccion_cliente ,clientes.razon_social AS dato_cliente,
        usuarios.nombre AS vendedor_nombre, usuarios.apellido AS vendedor_apellido,
        comprobantes.name AS comprobante, comprobantes.code AS code_sunat_comprobante,
        tipo_documentos.code_sunat AS tipo_doc_cliente
        FROM ventas 
        LEFT JOIN clientes LEFT JOIN tipo_documentos ON clientes.tipo_doc_id = tipo_documentos.id ON ventas.cliente_id = clientes.id
        LEFT JOIN usuarios ON ventas.usuario_id = usuarios.id 
        LEFT JOIN comprobantes ON ventas.comprobante_id = comprobantes.id
        WHERE serie = :serie AND numero = :numero";
        $stmt = Database::conectar()->prepare($sql);
        $stmt -> bindParam(':serie',$serie,PDO::PARAM_STR);
        $stmt -> bindParam(':numero',$numero,PDO::PARAM_STR);
        $stmt -> execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); 
        $stmt -> close();
        $stmt = null;

    }
    
    // DATO DE LA EMPRESA
    public function dataEmpresa(){
        $sql = "SELECT  ruc, razon_social, logo, email, direccion_fiscal, telefono from configuracion ";
        $stmt = Database::conectar()->prepare($sql); 
        $stmt -> execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); 
        $stmt -> close();
        $stmt = null;
    }
}