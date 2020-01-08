<?php 

// Mostramos los datos de una Variable pero formateados con estilos basicos
function dd($d){
    $color1 = "#e8e8e8";
    $color2 = "#150808";
    echo "<div style='background:$color1; height:max-content; width:max-content;padding:8px'>";
  /*  highlight_string("<?php\n\$data =\n" . var_export($d, true) . ";\n?>");*/
    highlight_string("<?php\n" . var_export($d, true) . ";\n?>");
    
    echo "</div>";
}

function now(){
  return date('Y-m-d H:i:s');
}
