<?php 
/* LOS ULTIMOS 10 MESES
SELECT * FROM ventas WHERE created_at 
BETWEEN date_sub(now(), INTERVAL 10 MONTH) 
AND NOW() ORDER BY Id ASC
*/
class SaleReportModel extends model{

    // For Graphic report
    public function getreport($fechaInicial, $fechaFinal){
        if($fechaInicial == null){ // DEDAULT : los ultimos 10 meses
            $sql = "SELECT created_at AS awomes, total AS sale  FROM ventas WHERE deleted_at = 0
                    AND created_at BETWEEN DATE_SUB(NOW(), INTERVAL 10 MONTH) AND NOW() 
                    ORDER BY id ASC ";//LIMIT 10
            $stmt = Database::conectar()->prepare($sql);
            $stmt -> execute();
            return $stmt -> fetchAll(PDO::FETCH_ASSOC);

        }elseif($fechaInicial == $fechaFinal){ // HOY
            $sql = "SELECT SUBSTR(created_at,1,7) AS awomes, total AS sale FROM ventas
            WHERE created_at LIKE '$fechaFinal%'";
            $stmt = Database::conectar()->prepare($sql);
            $stmt -> execute();
            return $stmt -> fetchAll(PDO::FETCH_ASSOC);
        }else{
            $fechaActual = new DateTime();
			$fechaActual ->add(new DateInterval("P1D"));
			$fechaActualMasUno = $fechaActual->format("Y-m-d");

			$fechaFinal2 = new DateTime($fechaFinal);
			$fechaFinal2 ->add(new DateInterval("P1D"));
			$fechaFinalMasUno = $fechaFinal2->format("Y-m-d");
            
            if($fechaFinalMasUno == $fechaActualMasUno){ 
				$stmt = Database::conectar()->prepare("SELECT SUBSTR(created_at,1,7) AS awomes, total AS sale FROM ventas
                                    WHERE created_at BETWEEN '$fechaInicial' AND '$fechaFinalMasUno' AND deleted_at = 0");
			}else{
				$stmt = Database::conectar()->prepare("SELECT SUBSTR(created_at,1,7) AS awomes, total AS sale FROM ventas 
                                    WHERE created_at BETWEEN '$fechaInicial' AND '$fechaFinal' AND deleted_at = 0");
			}
			$stmt -> execute();
			return $stmt -> fetchAll(PDO::FETCH_ASSOC);
        }


        $stmt->close();
        $stmt = null;
    }


    //Obtener los productos 10 más vendidos
    public function maxventaproduct(){
        $sql = "SELECT  name, c_ventas FROM productos ORDER BY c_ventas DESC LIMIT 10";
        $stmt = Database::conectar()->prepare($sql);
        $stmt -> execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); 
        $stmt -> close();
        $stmt = null;
    }

    // Reporte de Clientes que tienes mayor compras
    public function maxventaclients(){
        // $sql = " SELECT clientes.c_compras, clientes.razon_social AS clientepe,
        //         FORMAT(clientes.c_compras * ventas.total,2) AS total_compras  FROM ventas 
        //         LEFT JOIN clientes   ON ventas.cliente_id = clientes.id 
        //         ORDER BY clientes.c_compras DESC LIMIT 10";
        $sql = "SELECT clientes.c_compras AS cantidad, clientes.razon_social AS clientepe, 
        ventas.total AS totalporventa FROM ventas 
        LEFT JOIN clientes   ON ventas.cliente_id = clientes.id 
        ORDER BY clientes.c_compras DESC LIMIT 10";
        $stmt = Database::conectar()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt -> close();
        $stmt = null;
    }

    public function excelandpfgreport($fechaInicial, $fechaFinal){
        
       

        $pdo = Database::conectar();
        if($fechaFinal == null){ // Trando todas las Ventas
            $sqlTotal = "SELECT serie,numero, productos_vendidos, grabada, descuento, total_igv, total,ventas.created_at
            ,clientes.doc,clientes.razon_social AS cliente, usuarios.nombre AS vendedor_nombre, 
            usuarios.apellido AS vendedor_apellido
            FROM ventas 
            LEFT JOIN clientes ON ventas.cliente_id = clientes.id
            LEFT JOIN usuarios ON ventas.usuario_id = usuarios.id
            WHERE ventas.deleted_at = 0
            ORDER BY ventas.id ASC ";
            $stmt = $pdo -> prepare($sqlTotal);

        }elseif($fechaInicial == $fechaFinal){ /// Traendo la ventas del DIa
            $sqlr = "SELECT serie,numero, productos_vendidos, grabada, descuento, total_igv, total,ventas.created_at
            ,clientes.doc,clientes.razon_social AS cliente, usuarios.nombre AS vendedor_nombre, 
            usuarios.apellido AS vendedor_apellido
             FROM ventas 
             LEFT JOIN clientes ON ventas.cliente_id = clientes.id
             LEFT JOIN usuarios ON ventas.usuario_id = usuarios.id
             WHERE ventas.deleted_at = 0 AND ventas.created_at LIKE '$fechaFinal%'
            ORDER BY ventas.id ASC ";
            $stmt = $pdo -> prepare($sqlr);
        }else{
            $fechaActual = new DateTime();
			$fechaActual ->add(new DateInterval("P1D"));
			$fechaActualMasUno = $fechaActual->format("Y-m-d");

			$fechaFinal2 = new DateTime($fechaFinal);
			$fechaFinal2 ->add(new DateInterval("P1D"));
			$fechaFinalMasUno = $fechaFinal2->format("Y-m-d");
            
            if($fechaFinalMasUno == $fechaActualMasUno){
                $sqlone = "SELECT serie,numero, productos_vendidos, grabada, descuento, total_igv, total,ventas.created_at
                ,clientes.doc,clientes.razon_social AS cliente, usuarios.nombre AS vendedor_nombre, 
                usuarios.apellido AS vendedor_apellido
                FROM ventas 
                LEFT JOIN clientes ON ventas.cliente_id = clientes.id
                LEFT JOIN usuarios ON ventas.usuario_id = usuarios.id
                WHERE ventas.created_at BETWEEN '$fechaInicial' AND '$fechaFinalMasUno' AND ventas.deleted_at = 0"; 
                $stmt = $pdo -> prepare($sqlone);
			}else{
                $sqldos = "SELECT serie,numero, productos_vendidos, grabada, descuento, total_igv, total,ventas.created_at
                ,clientes.doc,clientes.razon_social AS cliente, usuarios.nombre AS vendedor_nombre, 
                usuarios.apellido AS vendedor_apellido
                 FROM ventas 
                 LEFT JOIN clientes ON ventas.cliente_id = clientes.id
                 LEFT JOIN usuarios ON ventas.usuario_id = usuarios.id 
                 WHERE ventas.created_at BETWEEN '$fechaInicial' AND '$fechaFinal' AND ventas.deleted_at = 0";  
                $stmt = $pdo -> prepare($sqldos);
			}
        }

        $stmt -> execute();
        return $stmt -> fetchAll(PDO::FETCH_ASSOC);
        $stmt -> null;
        $stmt = null;
    }


    // REPORTE DE VENTA POR MES EN EL ULTIMO AÑO
    public function getventasanual(){
        // Para obtener  los datos del ultimo año
          $datein =  date('Y').'-01-01';
          $datefin =  date('Y').'-12-31';
        $sql2 = " SELECT created_at AS awomes, total AS sale FROM ventas 
        WHERE deleted_at = 0 AND created_at BETWEEN :datein AND :datefin
        ORDER BY id ASC
       ";
 
        $stmt = Database::conectar()->prepare($sql2);
        $stmt  -> bindParam(':datein',$datein,PDO::PARAM_STR);
        $stmt  -> bindParam(':datefin',$datefin,PDO::PARAM_STR);
        $stmt -> execute();
        return $stmt -> fetchAll(PDO::FETCH_ASSOC);
    }

    // TOTAL DE VENTAS ANUAL
    public function totaldeventanual(){
        $datein =  date('Y').'-01-01';
        $datefin =  date('Y').'-12-31';
        $sql = "SELECT SUM(total) AS total FROM ventas WHERE deleted_at = 0 AND created_at BETWEEN :datein AND :datefin ";
        // $stmt = Database::conectar()->query($sql);
        // $stmt -> execute();
        $stmt = Database::conectar()->prepare($sql);
        $stmt  -> bindParam(':datein',$datein,PDO::PARAM_STR);
        $stmt  -> bindParam(':datefin',$datefin,PDO::PARAM_STR);
        $stmt -> execute();
        return $stmt -> fetch(PDO::FETCH_ASSOC);
        $stmt -> close();
        $stmt = null;
    }

    // TOTAL FACTURA AND BOLETAS ANUAL
    public function total_factura_boleta_anual($idcomprobante){
        $datein =  date('Y').'-01-01';
        $datefin =  date('Y').'-12-31';
        $sql = "SELECT SUM(total) AS total FROM ventas WHERE ventas.comprobante_id = :idcomprobante AND deleted_at = 0
            AND created_at BETWEEN :datein AND :datefin";
        $stmt = Database::conectar()->prepare($sql);
        $stmt -> bindParam('idcomprobante',$idcomprobante,PDO::PARAM_INT);
        $stmt  -> bindParam(':datein',$datein,PDO::PARAM_STR);
        $stmt  -> bindParam(':datefin',$datefin,PDO::PARAM_STR);
        $stmt -> execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); 
        $stmt -> close();
        $stmt = null;
        
    }

    // TOTAL DE VENTA DE DIA
    public function totaldeventadia(){
        $date =  date('Y-m-d');
        // $datefin =  date('Y-m-d');
        $sql = "SELECT SUM(total) AS total FROM ventas WHERE deleted_at = 0 AND 
        created_at LIKE '$date%' ";
        
        $stmt = Database::conectar()->prepare($sql);
        $stmt -> execute();
        return $stmt -> fetch(PDO::FETCH_ASSOC);
        $stmt -> close();
        $stmt = null;
    }

    // TOTAL FACTURA AND BOLETAS DEL DIA
    public function total_factura_boleta_dia($idcomprobante){
        $date =  date('Y-m-d');
        
        $sql = "SELECT SUM(total) AS total FROM ventas WHERE ventas.comprobante_id = :idcomprobante AND deleted_at = 0
        AND created_at  LIKE '$date%'";
        $stmt = Database::conectar()->prepare($sql);
        $stmt -> bindParam('idcomprobante',$idcomprobante,PDO::PARAM_INT);
        $stmt -> execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); 
        $stmt -> close();
        $stmt = null;
        
    }

}