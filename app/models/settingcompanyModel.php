<?php 

class SettingCompanyModel extends Model{

    public function update_company($ruc,$razon_social,$nombre_comercial,$logo,$telefono,$email,$ubigeo_id,$direccion_fiscal){
        $sql = "UPDATE configuracion SET  ruc = :ruc, razon_social = :razon_social, nombre_comercial = :nombre_comercial,
                logo = :logo, telefono = :telefono, email = :email, ubigeo_id = :ubigeo_id, direccion_fiscal = :direccion_fiscal";
        $stmt = Database::conectar()->prepare($sql);
        $stmt -> bindParam(':ruc',$ruc, PDO::PARAM_STR);
        $stmt -> bindParam(':razon_social',$razon_social, PDO::PARAM_STR);
        $stmt -> bindParam(':nombre_comercial',$nombre_comercial, PDO::PARAM_STR);
        $stmt -> bindParam(':logo',$logo, PDO::PARAM_STR);
        $stmt -> bindParam(':telefono',$telefono, PDO::PARAM_STR);
        $stmt -> bindParam(':email',$email, PDO::PARAM_STR);
        $stmt -> bindParam(':ubigeo_id',$ubigeo_id, PDO::PARAM_STR);
        $stmt -> bindParam(':direccion_fiscal',$direccion_fiscal, PDO::PARAM_STR);
        if($stmt ->execute()){
            return 'ok';
        }else{
            return 'error';
        }
        $stmt -> close();
        $stmt = null;
    }

    // Optener empresa
    public function getcompanype(){
        $sql = "SELECT * FROM configuracion";
        $stmt = Database::conectar()->prepare($sql);
        $stmt ->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt -> close();
        $stmt = null;
    }
}