<?php 

class View{ 

    public static function render($view= 'index', $data =  [] ){
        
        if(!is_file(VIEWS.CONTROLLER.DS.$view.'.php')){
            die(printf("No existe la vista '%s' en la carpeta '%s'", $view, CONTROLLER));
        }else{
            require_once VIEWS.CONTROLLER.DS.$view.'.php'; 
            exit();
        }
    }
}