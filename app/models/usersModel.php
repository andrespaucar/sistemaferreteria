<?php 

class UsersModel extends Model{
    

    public function loginuser($user, $pass){
        $sql = "SELECT usuario, nombre,apellido,password,foto, roles.name AS perfil,
        SUBSTR(created_at,1,11) AS fecha_creado from usuarios
        LEFT JOIN roles on usuarios.rol_id = roles.id WHERE usuario = :usuario AND password = :password";
        $stmt = Database::conectar()->prepare($sql);
        $stmt -> bindParam(':usuario',$user,PDO::PARAM_STR);
        $stmt -> bindParam(':password',$pass,PDO::PARAM_STR);
        $stmt -> execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->close();
        $stmt = null;         
        
    }

    public  function getusers(){
        $sql = "SELECT users.id as id,usuario,nombre,apellido,foto,celular,password,estado,rols.name as rol_id,ultimo_login,users.rol_id as id_rol
                FROM usuarios AS users INNER JOIN roles AS rols ON users.rol_id = rols.id ORDER BY users.id ASC";
        $data =  Database::conectar()->prepare($sql);
        $data  ->execute();
         
        // $data =[[
        //     "id" => 1,
        //     "nombre" => "Andres",
        //     "usuario" => "andrespe",
        //     "password" =>"<img src=".IMAGES."webpack.png"." alt='' width='40px' class='elevation-1 img-bordered-sm img-fluid' >"  ,
        //     "rol_id" => "administrador",
        //     "estado" => "activo",
        //     "ultimo_login" => "15-15-2019",
        //     "celular" => "editarEliminar" 
        // ]] ;
        return $data->fetchAll(PDO::FETCH_ASSOC);
        // return $data;
        $data->close();
    }

    public static function deleteUser($id){
        $stmt = Database::conectar()->prepare("DELETE FROM usuarios WHERE id = :id");
        $stmt-> bindParam(":id",$id, PDO::PARAM_INT);
        if($stmt ->execute()){
            return 'ok';
        }else{
            return 'error';
        }
        $stmt->close();
        $stmt = null;
         
    }

    public static function addUser($usuario,$name,$surname,$pass,$foto,$mobile,$estado,$rol_id){
        $sql = 'INSERT INTO usuarios(usuario, nombre, apellido, password, foto, celular, estado, rol_id)
        VALUES (:usuario, :nombre, :apellido, :password, :foto ,:celular, :estado, :rol_id)';
        $stmt = Database::conectar()->prepare($sql);
        $stmt->bindParam(':usuario',$usuario, PDO::PARAM_STR);
        $stmt->bindParam(':nombre',$name, PDO::PARAM_STR);
        $stmt->bindParam(':apellido',$surname, PDO::PARAM_STR);
        $stmt->bindParam(':password',$pass, PDO::PARAM_STR);
        $stmt->bindParam(':foto',$foto, PDO::PARAM_STR);
        $stmt->bindParam(':celular',$mobile, PDO::PARAM_STR);
        $stmt->bindParam(':estado',$estado, PDO::PARAM_INT);
        $stmt->bindParam(':rol_id',$rol_id, PDO::PARAM_INT);
        if($stmt->execute()){
            return 'ok';
        }else{
            return 'error';
        }
        $stmt->close();
        $stmt = null;
    }

    public function updatestate($id,$state){
        $stmt = Database::conectar()->prepare("UPDATE usuarios SET estado = :statee WHERE id = :id ");
        $stmt-> bindParam(":id",$id, PDO::PARAM_INT);
        $stmt-> bindParam(":statee",$state, PDO::PARAM_INT);
        if($stmt ->execute()){
            return 'ok';
        }else{
            return 'error';
        }
        $stmt->close();
        $stmt = null;
        
    }

    public static function rols(){
        $stmt = Database::conectar()->prepare('SELECT * FROM roles');
        $stmt -> execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->close();
        $stmt = null;
    }

    public function updateUser($id,$user,$name,$surname,$pass,$foto,$mobile,$estado,$rolid){
        $sql = "UPDATE usuarios SET usuario = :user, nombre = :name, apellido = :surname, 
        password = :pass, foto = :foto, celular = :mobile, estado = :estado, rol_id = :rolid WHERE id = :id";
        $stmt = Database::conectar()->prepare($sql);
        $stmt -> bindParam(':id',$id, PDO::PARAM_INT);
        $stmt -> bindParam(':user',$user, PDO::PARAM_STR);
        $stmt -> bindParam(':name',$name, PDO::PARAM_STR);
        $stmt -> bindParam(':surname',$surname, PDO::PARAM_STR);
        $stmt -> bindParam(':pass',$pass, PDO::PARAM_STR);
        $stmt -> bindParam(':foto',$foto, PDO::PARAM_STR);
        $stmt -> bindParam(':mobile',$mobile, PDO::PARAM_STR);
        $stmt -> bindParam(':estado',$estado, PDO::PARAM_INT);
        $stmt -> bindParam(':rolid',$rolid, PDO::PARAM_INT);
        if($stmt->execute()){
            return 'ok';
        }else{
            return 'error';
        }
        $stmt->close();
        $stmt = null;
    }

    public static function countUsers(){
        $stmt = Database::conectar()->prepare("SELECT COUNT(*) AS count_users FROM usuarios");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); 
        $stmt->close();
        $stmt = null;
    }
}