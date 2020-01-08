<?php  
// LIBS
require_once 'app/libs/dompdf/lib/html5lib/Parser.php';
require_once 'app/libs/dompdf/lib/php-font-lib/src/FontLib/Autoloader.php';
require_once 'app/libs/dompdf/lib/php-svg-lib/src/autoload.php';
require_once 'app/libs/dompdf/src/Autoloader.php';
require 'vendor/autoload.php';
require_once 'app/libs/dompdf/autoload.inc.php';
// Dompdf\Autoloader::register();
//--------------------------------------

require_once 'app/core/app.php';


App::fly();
 