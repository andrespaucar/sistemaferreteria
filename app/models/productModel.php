<?php 

class ProductModel extends Model{

    // Traendo todas la UNIDADES DE MEDIDA
    public static function allUnityMedidas(){
        
        $stmt = Database::conectar()->prepare("SELECT * FROM unidades_medida");
        $stmt -> execute();
        return $stmt -> fetchAll(PDO::FETCH_ASSOC);
        $stmt -> close(); 
        $stmt = null;
    }

    // AGREGANDO UN PRODUCTO
    public static function addproduct($name,$codigo,$image,$stock,$stock_min,$p_venta_sin,$p_venta_in,$p_compra,$estado,$unidad_id,$categoria_id,$updated_at){
        
        $sql = 'INSERT INTO productos(name,codigo,image,stock,stock_min,stock_actual,p_venta_sin,p_venta_in,p_compra,estado,unidad_id,categoria_id,updated_at)
                 VALUES (:name,:codigo,:image,:stock,:stock_min,:stock_actual,:p_venta_sin,:p_venta_in,:p_compra,:estado,:unidad_id,:categoria_id,:updated_at)';
        $stmt = Database::conectar()->prepare($sql);
        $stmt -> bindParam(':name', $name, PDO::PARAM_STR);
        $stmt -> bindParam(':codigo', $codigo, PDO::PARAM_STR);
        $stmt -> bindParam(':image', $image, PDO::PARAM_STR);
        $stmt -> bindParam(':stock', $stock, PDO::PARAM_INT);
        $stmt -> bindParam(':stock_actual', $stock, PDO::PARAM_INT); // AQUI estamos asignando al stock actual - al stock registrado
        $stmt -> bindParam(':stock_min', $stock_min, PDO::PARAM_INT);
        $stmt -> bindParam(':p_venta_sin', $p_venta_sin, PDO::PARAM_INT);
        $stmt -> bindParam(':p_venta_in', $p_venta_in, PDO::PARAM_INT);
        $stmt -> bindParam(':p_compra', $p_compra, PDO::PARAM_INT);
        $stmt -> bindParam(':estado', $estado, PDO::PARAM_INT);
        $stmt -> bindParam(':unidad_id', $unidad_id, PDO::PARAM_INT);
        $stmt -> bindParam(':categoria_id', $categoria_id, PDO::PARAM_INT);
        $stmt -> bindParam(':updated_at', $updated_at, PDO::PARAM_STR);
        if($stmt -> execute()){
            return 'ok';
        }else{
            return 'error';
        }
        $stmt->close();
        $stmt = null; 
    }

    //OBTENEMOS TODOS LOS PRODUCTOS
    public static function allproductsp($count = null){
        
        $sql = 'SELECT productos.id,productos.name,codigo,image,stock,stock_actual,stock_min,p_compra,p_venta_sin,p_venta_in,
        estado, unidad_id,categoria_id, productos.created_at, productos.updated_at,
        categorias.name as namecat, unidades_medida.name as nameuni, unidades_medida.simbolo as simbolo
        FROM productos 
        LEFT JOIN categorias  ON productos.categoria_id = categorias.id 
        LEFT JOIN unidades_medida  ON productos.unidad_id = unidades_medida.id
        WHERE productos.deleted_at = 0';
        if($count == "count"){
            $stmt = Database::conectar()->prepare("SELECT COUNT(deleted_at) AS count_products FROM productos where deleted_at=0");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);  
            $stmt = null;
        }else{
            //Obtenemos los productos que estan con el estado '0' 
            $stmt = Database::conectar()->prepare($sql);
            $stmt -> execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stmt->close(); 
            $stmt = null;
        }
         
    }

    // ELIMINADO UN PRODUCTO = Cambiamos el estado del Producto
    public static function delproduct($id){
        $stmt = Database::conectar()->prepare('UPDATE productos SET deleted_at = 1, image = "default.jpg" WHERE id = :id');
        $stmt -> bindParam(':id',$id, PDO::PARAM_INT);
        // $stmt -> bindParam(':img','default.jpg', PDO::PARAM_STR);
        if($stmt ->execute()){
            return 'ok';
        }else{
            return 'error';
        }
        $stmt->close();
        $stmt = null;
    }

    //UPDATE STOCK SUM
    public function updateStock($id, $newStockSum){
        $stmt = Database::conectar()->prepare('UPDATE productos SET stock= :newstock,stock_actual=:newstock WHERE id= :id');
        $stmt->bindParam(':id',$id,PDO::PARAM_INT);
        $stmt->bindParam(':newstock',$newStockSum,PDO::PARAM_INT);
        // $stmt->bindParam(':newstock',$newStockSum,PDO::PARAM_INT);
        if( $stmt->execute()){
            return 'ok';
        }else{
            return 'error';
        }
        $stmt -> close(); 
        $stmt = null;
    }

    // GET Product 
    public function getProduct($id){
        $sql = 'SELECT productos.id,productos.name,codigo,image,stock,stock_actual,stock_min,p_compra,p_venta_sin,p_venta_in,
        estado, unidad_id,categoria_id, productos.created_at, productos.updated_at,
        categorias.name as namecat, unidades_medida.name as nameuni, unidades_medida.simbolo as simbolo
        FROM productos 
        LEFT JOIN categorias  ON productos.categoria_id = categorias.id 
        LEFT JOIN unidades_medida  ON productos.unidad_id = unidades_medida.id
        WHERE productos.deleted_at = 0 AND productos.id = :id';
        $stmt = Database::conectar()->prepare($sql);
        $stmt -> bindParam(":id",$id, PDO::PARAM_STR);
        $stmt -> execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->close();
        $stmt = null; 
    }

    // Update State product
    public function updatestateproduct($id,$state){
        $stmt = Database::conectar()->prepare('UPDATE productos SET estado = :estado WHERE id = :id ');
        $stmt -> bindParam(":id",$id,PDO::PARAM_INT);
        $stmt -> bindParam(":estado",$state,PDO::PARAM_INT);
        if($stmt->execute()){
            return 'ok';
        }else{
            return 'error';
        }
    }

}