<?php 

class SaleModel extends Model{

    public function allproductslistpe(){
        $sql = "SELECT productos.id, productos.name, codigo, stock_actual, p_venta_sin, p_venta_in, unidad_id,
        unidades_medida.simbolo AS simbolo, unidades_medida.code AS code
        FROM productos
        LEFT JOIN unidades_medida ON productos.unidad_id = unidades_medida.id
        WHERE productos.deleted_at = 0 AND productos.estado = 1";
        $stmt = Database::conectar()->prepare($sql);
        $stmt -> execute();
        return $stmt -> fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtenemos los registros de las ventas
    public static function allsalespe(){
        $sql = "SELECT ventas.created_at, ventas.serie,ventas.numero,
        ventas.pdf_A4 AS pdf, ventas.pdf_ticket AS ticket, ventas.xml, ventas.cdr, ventas.sunat,ventas.total, 
        clientes.razon_social,clientes.doc,comprobantes.name
        FROM ventas  
        LEFT JOIN clientes ON   ventas.cliente_id = clientes.id  
        LEFT JOIN comprobantes ON ventas.comprobante_id = comprobantes.id
        WHERE ventas.deleted_at = 0 ORDER BY ventas.id DESC";
        $stmt = Database::conectar()->prepare($sql); 
        $stmt -> execute();
        return $stmt -> fetchAll(PDO::FETCH_ASSOC);
    }

    // Buscar Producto por codigo
    public function searchproduct($codigo){
        $sql = "SELECT productos.id, productos.name, codigo, stock_actual, p_venta_sin, p_venta_in, unidad_id,
        unidades_medida.simbolo AS simbolo, unidades_medida.code AS code
        FROM productos
        LEFT JOIN unidades_medida ON productos.unidad_id = unidades_medida.id
        WHERE productos.deleted_at = 0 AND productos.estado = 1 AND codigo = :codigo";
        $stmt = Database::conectar()->prepare($sql);
        $stmt ->bindParam(':codigo',$codigo, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->close();
        $stmt = null;
    }

    // Buscando Cliente por Doc  y NumDoc
    public function getClient($tipodoc,$numdoc){
        $sql = "SELECT clientes.id AS idcliente,doc, razon_social,ubigeo_id,
        ubigeo.codigo_ubigeo, clientes.direccion
        FROM clientes 
        LEFT JOIN ubigeo ON clientes.ubigeo_id = ubigeo.id
        WHERE clientes.tipo_doc_id = :tipodoc AND clientes.doc= :numdoc";
        $stmt = Database::conectar()->prepare($sql);
        $stmt ->bindParam(':tipodoc',$tipodoc,PDO::PARAM_INT);
        $stmt ->bindParam(':numdoc',$numdoc, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->close();
        $stmt = null;
    }
    // Obtener el ultimo numero serie del comprobante : boleta, factura
    public function getnumberserie($idcomprobante){
        $sql = "SELECT id,serie,numero  FROM ventas WHERE ventas.comprobante_id = :idcomprobante 
        ORDER BY ID DESC LIMIT 1";
        $stmt = Database::conectar()->prepare($sql);
        $stmt->bindParam(':idcomprobante',$idcomprobante,PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Registrar Cliente Nuevo
    public function addcustomer_mod($tipo_doc,$doc,$razon_social,$direccion_cli,$ubigeo_id){
        $pdo = new Database ;
        $stmt = $pdo->conectar()->prepare("INSERT INTO clientes(tipo_doc_id, doc, razon_social, direccion, ubigeo_id) 
        VALUES(:tipo_doc_id, :doc, :razon_social, :direccion_cli, :ubigeo_id)");
        $stmt->bindParam(':tipo_doc_id',$tipo_doc,PDO::PARAM_INT);
        $stmt->bindParam(':doc',$doc,PDO::PARAM_STR);
        $stmt->bindParam(':razon_social',$razon_social,PDO::PARAM_STR);
        // $stmt->bindParam(':telefono',$telefono,PDO::PARAM_STR);
        // $stmt->bindParam(':email',$email,PDO::PARAM_STR);
        $stmt->bindParam(':direccion_cli',$direccion_cli,PDO::PARAM_STR);
        $stmt->bindParam(':ubigeo_id',$ubigeo_id,PDO::PARAM_INT);
        if($stmt->execute()){
            $idd = $pdo->conectar()->query("SELECT id  FROM clientes ORDER BY ID DESC LIMIT 1"); 
            $lastId = $idd->fetchColumn();
            return $lastId ;
        } 
        $stmt->close();
        $stmt = null;

    }

    // Registrar Venta
    public function setventa($serie,$numero,$codigo_hash,$xml,$cdr,$sunat,$productos_vendidos,
                            $grabada,$descuento,$total_igv,$total,$total_en_letras,
                            $pdf_A4,$pdf_ticket,$usuario_id,$comprobante_id,$cliente_id,$estado){
        $sql = "INSERT INTO ventas(serie, numero, codigo_hash, xml, cdr, sunat, productos_vendidos,
                            grabada, descuento,total_igv, total,total_en_letras, pdf_A4,
                            pdf_ticket, usuario_id, comprobante_id, cliente_id, estado) 
        VALUES (:serie, :numero, :codigo_hash, :xml, :cdr, :sunat, :productos_vendidos, 
                :grabada, :descuento, :total_igv, :total, :total_en_letras, :pdf_A4, :pdf_ticket,
                :usuario_id, :comprobante_id, :cliente_id, :estado)";
        $pdo = new Database ;
        $stmt = $pdo->conectar()->prepare($sql);
        $stmt->bindParam(':serie',$serie,PDO::PARAM_STR);
        $stmt->bindParam(':numero',$numero,PDO::PARAM_STR);
        $stmt->bindParam(':codigo_hash',$codigo_hash,PDO::PARAM_STR);
        $stmt->bindParam(':xml',$xml,PDO::PARAM_STR);
        $stmt->bindParam(':cdr',$cdr,PDO::PARAM_STR);
        $stmt->bindParam(':sunat',$sunat,PDO::PARAM_STR);
        $stmt->bindParam(':productos_vendidos',$productos_vendidos,PDO::PARAM_STR);
        $stmt->bindParam(':grabada',$grabada,PDO::PARAM_STR);
        $stmt->bindParam(':descuento',$descuento,PDO::PARAM_STR);
        $stmt->bindParam(':total_igv',$total_igv,PDO::PARAM_STR);
        $stmt->bindParam(':total',$total,PDO::PARAM_STR);
        $stmt->bindParam(':total_en_letras',$total_en_letras,PDO::PARAM_STR);
        $stmt->bindParam(':pdf_A4',$pdf_A4,PDO::PARAM_STR);
        $stmt->bindParam(':pdf_ticket',$pdf_ticket,PDO::PARAM_STR);
        $stmt->bindParam(':usuario_id',$usuario_id,PDO::PARAM_INT);
        $stmt->bindParam(':comprobante_id',$comprobante_id,PDO::PARAM_INT);
        $stmt->bindParam(':cliente_id',$cliente_id,PDO::PARAM_INT);
        $stmt->bindParam(':estado',$estado,PDO::PARAM_STR);
        
        if($stmt->execute()){
            $idd = $pdo->conectar()->query("SELECT id  FROM ventas ORDER BY ID DESC LIMIT 1");
            // $lastId = $idd->fetchColumn(); $pdo->conectar()->lastInsertId() 
            $lastId = $idd->fetchColumn();
            return $lastId ;
        }else{
            return 'error';
        }
            
         
    }

    // Restar el stock por producto
    public function stockproduct($stock,$id){
        $sql = "UPDATE productos SET stock_actual = stock_actual - :stock, c_ventas = c_ventas + 1  where id = :id ";
        $stmt = Database::conectar()->prepare($sql);
        $stmt -> bindParam(':stock',$stock, PDO::PARAM_INT);
        $stmt -> bindParam(':id', $id, PDO::PARAM_INT);
        if($stmt -> execute()){
            return 'ok';
        }else{
            return 'error';
        } 
    }
    
    // Actualizando el numero de compras del cliente
    public function ncompraclient($id){ 
        $sql = "UPDATE clientes SET c_compras = c_compras + 1 WHERE id = :id";
        $stmt = Database::conectar()->prepare($sql);
        $stmt -> bindParam(':id',$id,PDO::PARAM_INT);
        if($stmt->execute()){
            return 'ok';
        }else{
            return 'error';
        }

        $stmt -> close();
        $stmt = null;
    }

   

    

    // // Registrar venta - productos
    // public function setventaproducts($venta_id,$producto_id,$cantidad,$descuento){
    //     $sql = "INSERT INTO detalle_venta(venta_id,producto_id,cantidad,descuento)
    //             VALUES (:venta_id, :producto_id, :cantidad,:descuento)";
    //     $stmt = Database::conectar()->prepare($sql);
    //     $stmt->bindParam(':venta_id',$venta_id,PDO::PARAM_INT);
    //     $stmt->bindParam(':producto_id',$producto_id,PDO::PARAM_INT);
    //     $stmt->bindParam(':cantidad',$cantidad,PDO::PARAM_INT);
    //     $stmt->bindParam(':descuento',$descuento,PDO::PARAM_INT);
    //     if($stmt->execute()){
    //         return 'ok';
    //     }else{
    //         return 'error';
    //     }

    // }

}