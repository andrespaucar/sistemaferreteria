<?php 

class CustomersModel extends Model{

    public function allcustomers(){
        $sql = "SELECT clientes.id,doc, razon_social, telefono, email, estado, created_at,
            tipo_documentos.nombre AS tipo_doc from clientes 
            LEFT JOIN tipo_documentos on clientes.tipo_doc_id = tipo_documentos.id  WHERE clientes.deleted_at = 0";
        $stmt = Database::conectar()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); 
    }

    public function countcustomers(){
        $stmt = Database::conectar()->prepare('SELECT COUNT(deleted_at) AS count_customers FROM clientes WHERE deleted_at = 0');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); 
    }

    public function updateStateCustomer($id){
        $stmt = Database::conectar()->prepare('UPDATE clientes SET estado = !estado WHERE id=:id' );
        $stmt->bindParam(':id',$id,PDO::PARAM_INT);
        if($stmt->execute()){
            return 'ok';
        }else{
            return 'error';
        }
    }

    public function delcustomer($id){
        $sql = "UPDATE clientes SET deleted_at = 1 WHERE id = :id";
        $stmt = Database::conectar()->prepare($sql);
        $stmt->bindParam(':id',$id,PDO::PARAM_INT);
        if($stmt->execute()){
            return 'ok';
        }else{
            return 'error';
        }
    }

    public function addcustomer_mod($tipo_doc,$doc,$razon_social, $telefono = null, $email = null,$direccion_cli = null,$ubigeo_id){
        $stmt = Database::conectar()->prepare("INSERT INTO clientes(tipo_doc_id, doc, razon_social, telefono, email,direccion, ubigeo_id) 
        VALUES(:tipo_doc_id, :doc, :razon_social, :telefono, :email,:direccion_cli, :ubigeo_id)");
        $stmt->bindParam(':tipo_doc_id',$tipo_doc,PDO::PARAM_INT);
        $stmt->bindParam(':doc',$doc,PDO::PARAM_STR);
        $stmt->bindParam(':razon_social',$razon_social,PDO::PARAM_STR);
        $stmt->bindParam(':telefono',$telefono,PDO::PARAM_STR);
        $stmt->bindParam(':email',$email,PDO::PARAM_STR);
        $stmt->bindParam(':direccion_cli',$direccion_cli,PDO::PARAM_STR);
        $stmt->bindParam(':ubigeo_id',$ubigeo_id,PDO::PARAM_INT);
        if($stmt->execute()){
            return 'ok';
        } 
        $stmt->close();
        $stmt = null;

    }

    // Verificar si existe RUC o DNI en la DB
    public function verifydocdb($doc){
        $sql = "SELECT doc from clientes where doc = :doc";
        $stmt = Database::conectar()->prepare($sql);
        $stmt->bindParam(':doc',$doc, PDO::PARAM_STR);
        $stmt->execute();
        if($stmt->fetch()){
            return 'siexiste';
        }else{
            return 'noexiste';
        }
        $stmt->close();
        $stmt = null;
    }
}