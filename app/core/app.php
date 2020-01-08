<?php 

class App {
    
    private $frameword = "LESS_PHP";
    private $url = [];

    function __construct(){
        $this->init();
    }

    /** Método iniciara la Aplicacion
     * @return void
     */
    private function init(){ 
        $this->init_load_config();
        $this->init_load_function(); 
        $this->init_autoload();
        $this->routes_amg();
    }

    /**
     * Método para cargar las configuraciones del sistema
     * @return void
    */
    private function init_load_config(){
        $file = "config.php";
        if(!is_file("app/config/".$file)){
            die(printf("El archivo %s nose encuntra, es requerido para que el %s funcione", $file, $this->frameword));
        }  
        //Cargando el archivo
        require_once "app/config/".$file;
        return;
    }
    /**
     * Método para cargar todas las function del sistema y del usuario
     * @return void
    */
    private function init_load_function(){
        $file = 'core_functions.php';
        if(!is_file(FUNCTIONS.$file)){
            die(printf("El archivo %s no se encuentra, es requerido para que el  %s funcione", $file, $this->frameword));
        }
        //Cargando el archivo
        require_once FUNCTIONS . $file;
        return;
    }
    /**
     * Método para cargar todos los archivos del sistema de manera automatica
     * @return void
     */
    private function init_autoload(){ 
        require_once CONFIG.'autoloader.php';
        Autoloader::init();

        return;
    }
    

    /**
     * Método papara ejecutar  y cargar de manera automatica los controladores, metodos y parametros
     * @return void
     */
    private function routes_amg(){
        if(isset($_GET['url'])){
            $this->url = $_GET['url'];
            $this->url = rtrim($this->url, '/');
            $this->url = filter_var($this->url, FILTER_SANITIZE_URL);
            $this->url = explode('/', strtolower($this->url));
        }

        /*----------------------------------------------------*/
        // Si no se ingresa un Controllador
        if(isset($this->url[0])){
            $c_controller = $this->url[0];
            unset($this->url[0]);
        }else{
            $c_controller = DEFAULT_CONTROLLER;
        }
        //Ejecutando el controllador
        $controller = $c_controller.'Controller';
        if(!class_exists($controller)){
            $controller = DEFAULT_ERROR_CONTROLLER.'Controller';// errorController
            $c_controller = DEFAULT_ERROR_CONTROLLER; // Para que el CONTROLLER sea error
        }
        /*----------------------------------------------------*/
        // Cuando el Metodo es Solicitado
        if(isset($this->url[1])){
            $method = str_replace('-','_',$this->url[1]);
            // Exisste o no el methodo de la clase
            if(!method_exists($controller, $method)){
                $controller = DEFAULT_ERROR_CONTROLLER.'Controller';
                $c_method = DEFAULT_METHOD; // Index
                $c_controller = DEFAULT_ERROR_CONTROLLER; // Para que el CONTROLLER sea 404
            }else{
                $c_method = $method;
            }
            unset($this->url[1]);
        }else{
            $c_method = DEFAULT_METHOD;
        }
        /*-----------------------------------------------------*/
        // Creando las constantes
        define('CONTROLLER',$c_controller);
        define('METHOD', $c_method);
        /*-----------------------------------------------------*/
        // Ejecutando el controller y method
        $controller = new $controller;

        //Opteniendo la URL
        $params = array_values(empty($this->url)? [] : $this->url);
        //llamando al método solicitado por el usuario
        if(empty($params)){
            call_user_func([$controller, $c_method]); 
        }else{
            call_user_func_array([$controller,$c_method], $params);
        }
        return ;
 
    }

    public static function fly(){
        $fl = new self();
         
        return;
    }
}