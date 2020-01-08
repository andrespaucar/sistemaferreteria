<?php 

define('NAME_APP'   , "Aplication Andres");
define('CARPETA_PROYECT','/pos_pe/');
define('URL_L'      ,'http://'.$_SERVER['SERVER_NAME'].'/pos_pe/');
date_default_timezone_set('America/lima');
// true = local | false : production
define('IS_LOCAL'   , true); 
define('URL_P'      , "__URL_PRODUCTION__/");
// DATABASE : Configuracion de acceso a la base de datos
define('DB_ENGINE'  , 'mysql'); 
define('DB_HOST'    , 'localhost');
define('DB_USER'    , 'root');
define('DB_PASS'    , '');
define('DB_NAME'    , 'post_pe');
define('DB_CHARSET'    , 'utf8mb4');

// Definiendo la URL padre
define('DS'     , DIRECTORY_SEPARATOR);
define('ROOT'   , getcwd() . DS); 
define('URL'    , IS_LOCAL ?  URL_L: URL_P);

// Directory App
define('APP'        , ROOT  .   'app'.DS);
define('CONTROLLERS', APP   .   'controllers'.DS);
define('MODELS'     , APP   .   'models'.DS);
define('CONFIG'     , APP   .   'config'.DS);
define('CORE'       , APP   .   'core'.DS);
define('CLASSES'    , APP   .   'classes'.DS);
define('FUNCTIONS'  , APP   .   'functions'.DS);

// Directory Resources
define('RESOURCES'  , ROOT      .   'resources'.DS);
define('VIEWS'      , RESOURCES .   'views' .DS);
    define('LAYOUTS'    , VIEWS .   'layouts' .DS);


// Directory Public
define('PUBLIC_C'   , URL       .   'public/');
define('JS'         , PUBLIC_C  .   'js/');
define('CSS'        , PUBLIC_C  .   'css/');
define('IMAGES'     , PUBLIC_C  .   'images/');
define('UPLOADS'    , PUBLIC_C  .   'uploads/');
define('UPLODADS_USERS', UPLOADS . 'users/');
define('UP_USERS'   , 'public/uploads/users/');
define('UP_PRODUTS'   , 'public/uploads/products/');
define('UP_COMPANY'   , 'public/uploads/company/');

define("DEFAULT_CONTROLLER", 'home');
define("DEFAULT_ERROR_CONTROLLER", 'error');
define("DEFAULT_METHOD", 'index');
