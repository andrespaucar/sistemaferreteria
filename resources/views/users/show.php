<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h2>show</h2>
    <?php 
     
    echo "<br>";
    print_r($data->ob);
    echo "<br>";
    highlight_string("<?php\n\$data =\n" . var_export($data, true) . ";\n?>");
    
    
    ?>
</body>
</html>