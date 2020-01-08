<?php include_once LAYOUTS."header.php" ?>
<?php require_once LAYOUTS.'main_header.php' ?>
<?php require_once LAYOUTS.'menu.php' ?>
 <?php 
 if($_SESSION['perfil'] == 'almacen' ){
    echo "<script> window.location.href = '/pos_pe/' </script>";
}
 
 ?>
<sale-component
  
></sale-component>
 
 
<?php include_once LAYOUTS."footer.php" ?>