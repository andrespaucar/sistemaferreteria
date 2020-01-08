<?php include_once LAYOUTS."header.php" ?>
<?php require_once LAYOUTS.'main_header.php' ?>
<?php require_once LAYOUTS.'menu.php' ?>


<user-component
    path_upload = "<?php echo UP_USERS; ?>"
></user-component>


 

<?php include_once LAYOUTS."footer.php" ?>

<script>
    // fetch("users/showUsers")
    // .then( rest =>{
    //     if(rest.ok){
    //         return rest.json();
    //     }else{
    //         throw "Error al solicitar Usuarios con Fech";
    //     }
    // })
    // .then( data => {
    //     console.log(data )
    // //     var dataJson = eval(data)
    // //     // console.log(dataJson[0].data[0])
    // //     $(".userDataTable").DataTable({
    // //         'data' : datoU[0].data,
    // //     })
    // })


  
</script>
