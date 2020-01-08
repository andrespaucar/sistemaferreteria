<?php 

class CategoryModel extends Model {
    public function allCategories($real = null){
        if($real){
            $stmt = Database::conectar()->prepare('SELECT * FROM categorias WHERE  deleted_at=0');
        }else{
            $stmt = Database::conectar()->prepare('SELECT * FROM categorias WHERE state = 1 and deleted_at=0');
        }
        
        $stmt -> execute();
        return $stmt -> fetchAll(PDO::FETCH_ASSOC);
        $stmt -> close();
        $stmt = null;
    }

    //DElETE CATEGORY = solo cambiamos el estado de la categoria
    public function delupCategory($id,$upstate = null){
        // $stmt = Database::conectar()->prepare('DELETE FROM categorias WHERE id = :id');
        if($upstate){
            $stmt = Database::conectar()->prepare('UPDATE categorias SET state=!state WHERE id= :id'); 

        }else{
            $stmt = Database::conectar()->prepare('SELECT  productos.categoria_id , categorias.id  
                                            FROM categorias RIGHT JOIN productos ON 
                                            categorias.id = productos.categoria_id WHERE categorias.id = :id');
            $stmt->bindParam(':id',$id,PDO::PARAM_INT);
            $stmt->execute();
            // $stmt->fetchAll(PDO::FETCH_ASSOC);
            if($stmt->fetchAll(PDO::FETCH_NUM) == []){
                $stmt = Database::conectar()->prepare('UPDATE categorias SET state=0, deleted_at = !deleted_at WHERE id= :id');
                $stmt->bindParam(':id',$id,PDO::PARAM_INT);
                $stmt -> execute();// Aki se elimina la categoria
                return 'ok';
                $stmt -> close();
                $stmt = null; 
            }else{
                return 'cat_con_product';
                $stmt -> close();
                $stmt = null; 
            }
            

            die();
            if($stmt->fetchAll(PDO::FETCH_NUM) == []){
                // Por si hay productos con categorias registradas
                return 'cat_con_product';
                $stmt -> close();
                $stmt = null;
            }else{
                $stmt = Database::conectar()->prepare('UPDATE categorias SET state=0, deleted_at = !deleted_at WHERE id= :id');
                $stmt->bindParam(':id',$id,PDO::PARAM_INT);
                $stmt -> execute();// Aki se elimina la categoria
                return 'ok';
                $stmt -> close();
                $stmt = null;
            }
        }

        $stmt->bindParam(':id',$id,PDO::PARAM_INT);
        if($stmt->execute()){
            return 'ok';
        }else{
            return 'error';
        }
        $stmt -> close();
        $stmt = null;
    }

    public function upState($id){
        $stmt = Database::conectar()->prepare('UPDATE categorias SET state=!state WHERE id= :id');
        $stmt->bindParam(':id',$id,PDO::PARAM_INT);
        if($stmt->execute()){
            return 'ok';
        }else{
            return 'error';
        }
        $stmt -> close();
        $stmt = null;
    }

    // UPDATE CATEGORY = actualizando la categoria
    public function upCategory($id,$name,$description){
        $stmt = Database::conectar()->prepare('UPDATE categorias SET name=:name, description = :description WHERE id = :id');
        $stmt -> bindParam(':id',$id, PDO::PARAM_INT);
        $stmt -> bindParam(':name',$name, PDO::PARAM_STR);
        $stmt -> bindParam(':description',$description, PDO::PARAM_STR);
        if($stmt->execute()){
            return 'ok';
        }else{
            return 'error';
        }
        $stmt -> close();
        $stmt = null;
    }

    //ADD CATEGORY = agregando categoria
    public function addCategory($name,$newdescription,$state){
        $stmt = Database::conectar()->prepare('INSERT INTO categorias(name,description,state) 
                                                    VALUES (:name,:description, :state)');
        $stmt->bindParam(':name',$name, PDO::PARAM_STR);
        $stmt->bindParam(':description',$newdescription, PDO::PARAM_STR);
        $stmt->bindParam(':state',$state, PDO::PARAM_INT);
        if($stmt->execute()){
            return 'ok';
        }else{
            return 'error';
        }
    }
}