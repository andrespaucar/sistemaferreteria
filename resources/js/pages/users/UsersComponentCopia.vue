<template>
  <div class="content-wrapper">
     <contentHeader
     nameContent="Usuario"
     nameMain = "Home"
     nameAct = "Users"
     />
    <section class="content">

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header  ">
                        <div class="row">
                            <div class="card-title col-auto mr-auto  ">
                                <button class="btn btn-primary btn-sm" 
                                data-toggle="modal" data-target="#modalUser" >Agregar Usuario</button>
                            </div>
                            <div class="col-auto">
                                <button class="btn btn-warning btn-md " 
                                data-toggle="modal" data-target="#editmodalUser" ><i class="fas fa-pencil-alt text-white"></i></button>
                                <button class="btn btn-danger btn-md " id="#deleteUser" ><i class="fa fa-times"></i></button>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <table id="exampleDataTableUsers" class="table userDataTable table-bordered dt-responsive nowrap  table-hover" style="width:100%" >
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Usuario</th>
                                    <th>Foto</th>
                                    <th>Perfil</th>
                                    <th>Estado</th>
                                    <th>Ultimo Login</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            
                            <tbody id="tablausuario"  >
                                <!-- <tr>
                                    <td>#</td>
                                    <td>Nombre</td>
                                    <td>Usuario</td>
                                    <td>Foto</td>
                                    <td>Perfil</td>
                                    <td>Estado</td>
                                    <td>Ultimo Login</td>
                                    <td>Acciones</td>
                                </tr>
                                 -->
                                <!-- <tr v-for="usuario in usuarios" :key="usuario.id">
                                    <td>1</td>
                                    <td>{{usuario.nombre}}</td>
                                    <td>{{usuario.usuario}}</td>
                                    <td>
                                        <div class=" ">
                                            <img src="/pos_pe/public/dist/img/avatar2.png"  alt="" width="40px" class="elevation-1 img-bordered-sm img-fluid ">
                                        </div>
                                    </td>
                                    <td>{{usuario.rol}}</td>
                                    <td> 
                                        <a href="#" v-if="1 == usuario.estado" class="btn btn-primary btn-xs" > Activo {{usuario.estado}} </a> 
                                        <a href="#" v-else class="btn btn-danger btn-xs" > Activo {{usuario.estado}} </a> 
                                    </td>
                                    <td>15-10-2019</td>
                                    <td>
                                        <div class="btn-group">
                                            <button class="btn btn-warning btn-sm" > 
                                                <i class="fas fa-pencil-alt text-white" ></i>
                                            </button> 
                                            <button class="btn btn-danger btn-sm" > 
                                                <i class="fa fa-times"></i>
                                            </button> 
                                        </div>
                                    </td>
                                </tr> -->
                                 
 
                            </tbody> 

                        </table>
                    </div>

                </div>
            </div>
        </div>

    </section>
    <!-- MODAL USERS -->
    <userModal></userModal>
</div>
</template>

<script>
import ContentHeader from '../../components/ContentHeader';
import UserModal from '../../pages/users/UsersModalComponent';

export default {
    data(){
        return{
            usuarios : []
        }
    },
    mounted(){
        console.log('Component userComponent Mounted')
            fetch("users/showUsers")
            .then( rest =>{
                if(rest.ok){
                    return rest.text();
                }else{
                    throw "Error al solicitar Usuarios con Fech";
                }
            })
            .then( data => {
                console.log(data ) 
                // this.usuarios = data
                console.log(eval(data))
                 $("#exampleDataTableUsers").DataTable({
                    "paging": true,
                    "lengthChange": true,
                    "searching": true,
                    "ordering": true,
                    "info": false,
                    "autoWidth": true,
                    data : eval(data),
                    // columns : [ 
                    //     {"data" : "id"},
                    //     {"data" : "nombre"},
                    //     {"data" : "usuario"}, 
                    //     {"data" : "password"},
                    //     {"data" : "rol_id"}, 
                    //     {"data" : "estado"}, 
                    //     // {"data" : "celular"}, 
                    //     {"data" : "ultimo_login"}, 
                    //     {"data" : "celular"}
                    // ]
                });

                
            }) 

        // let tabla_user = document.getElementById('btndel')
        // let aa = tabla_user.getAttribute('idusuario');
        // console.log(aa);
       
    },
    
    components: {
        'contentHeader' : ContentHeader,
        'userModal' : UserModal,
    },

    methods:{
        delete(){
            console.log('ELIMINADO PE');
        }
        
    }
}

       
         
// }) 
// $(function () { 
    // PONER ESTO EN EL FOOTER O EN OTRO ARCHIVO JAVASCRIPT
    // $(".userDataTable").on("click","button.btndeluser",function(){
    //     var idusuario = $(this).attr("idusuario"); 
    //     console.log("idusuario",idusuario);
    // })
    // }

// });

</script>

<style>

</style>