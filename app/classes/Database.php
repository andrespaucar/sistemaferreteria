<?php 

class Database 
{
    private $link;
    private $engine;
    private $host;
    private $name;
    private $user;
    private $pass;
    private $charset;
    private $opciones;

    /**
     * Constructor para nuestra clase
     */
    public function __construct()
    {
        $this->engine = DB_ENGINE;
        $this->name = DB_NAME;
        $this->host = DB_HOST;
        $this->user = DB_USER;
        $this->pass = DB_PASS;
        $this->charset = DB_CHARSET;
        $this->opciones =[PDO::ATTR_CASE => PDO::CASE_LOWER, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_ORACLE_NULLS => PDO::NULL_EMPTY_STRING, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ];
        return $this;
    }
    

    /**
     * MÃ©todo para abrir una conexiÃ³n a la base de datos
     * 
     * @return void
     */
    private function connect()
    {
        try{
            $this->link = new PDO($this->engine.':host='.$this->host.';dbname='.$this->name.';charset='.$this->charset, $this->user,$this->pass, $this->opciones);
            // $this->link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
            return $this->link;
        } catch(PDOException $e){
            die(sprintf('No hay conexión a la base de datos, hubo un error: %s ', $e->getMessage()));
        }
    }
     

    public static function conectar(){
        $db = new self();
        $link = $db->connect();
        return $link;
    }

    /**
     * MÃ©todo para hacer un query a la base de datos
     * 
     * @param string $sql
     * @param array $params
     * @return void
     */
    public static function query($sql, $params = [])
    {
        // $db = new self();
        // $link = $db->connect(); // muestra la conexion a la db
        // $link -> beginTransaction(); // Guarda los datos si con correctos y si no sale bien se hace un Rollback, por cualquier error , cheackpoint
        // $query = $link ->prepare($sql);

        //Manejando errores en el query o la peticion
        // SELECT * FROM usuario WHERE id='123'; no hacer esto si no trabajar con PLACEHOLDER DE PDO
        // SELCT * FROM usuario WHERE id= ?;
        // if(!$query->execute($params)){
        //     $link-> rollBack();
        //     $error = $query->errorInfo();
            // Index 0 es el tipo de error 
            // index 1 es el codigo de error
            // Index 2 es ele mensaje de error del usuario
        //     throw new Exception($error[2]);
        // }

        // SELECT / INSET / UPDATE / DELETE / AFTER TABLE
        // Manejando el tipo de query
        // SELECT * FROM usuarios;
        // if(strpos($sql,'SELECT') !== false){
        //     return $query->rowCount() > 0 ? $query->fetchAll() : false; // No hay resultados

        // }elseif(strpos($sql,'INSERT') !== false){
        //     $id = $link -> lastInsertId();
        //     $link -> commit();
        //     return $id;

        // }elseif(strpos($sql, 'UPDATE') !== false){
        //     $link -> commit();
        //     return true;

        // }elseif(strpos($sql,'DELETE') !== false){
        //     if($query->rowCount() > 0 ){
        //         $link -> commit();
        //         return true;
        //     }
        //     $link->rollBack();
        //     return false; // Nada ha sido borrado
        // } else{

        //     // ALTER TABLE / DROP TABLE
        //     $link -> commit();
        //     return true;
        // }
    }

    


}