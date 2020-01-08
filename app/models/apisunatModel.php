<?php 

class ApiSunatModel extends Model{
    // GET ALL UBIGEO
    public function getUbigeo(){
        $stmt = Database::conectar()->prepare('SELECT * FROM ubigeo');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        // $stmt -> close();
        // $stmt = null; 
    }

    // All TIPO DOCUMENTO
    public function tipo_doc_sunat(){
        $sql = "SELECT id, nombre, descripcion, code_sunat FROM tipo_documentos";
        $stmt = Database::conectar()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}