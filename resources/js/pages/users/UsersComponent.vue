<template>
  <div class="content-wrapper tt">
    <content-header
     nameContent="Usuario"
     nameMain = "Home"
     nameAct = "Users"
    ></content-header>
    <section class="content">

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header  ">
                        <div class="row">
                            <div class="card-title col-auto mr-auto  ">
                                <button class="btn btn-primary btn-sm" 
                                data-toggle="modal" data-target="#modalUser" >Agregar Usuario</button>
                                <button class="btn btn-dark btn-sm" ><i class="fas fa-users"></i> Editar Perfiles</button>
                               
                            </div>
                            <div class="col-auto ">
                                <transition name="fade">
                                <span v-if="actualizarLista" class="text-danger mr-2">Actualizaciones Pendientes</span>
                                </transition>
                                <!-- <button class="btn btn-warning btn-md " 
                                data-toggle="modal" data-target="#editmodalUser" ><i class="fas fa-pencil-alt text-white"></i></button> -->
                                <button class="btn btn-dark btn-md " :disabled="!actualizarLista" @click="updateList(actualizarLista)" ><i class="fas fa-sync-alt"></i></button>
                            </div>
                        </div>
                    </div>

                    <div class="card-body table-responsive">
                        <table id="" class="table dt-responsive   table-hover " width="100%" >
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Usuario</th>
                                    <th>Nombre</th>
                                    <th>Celular</th>
                                    <th>Foto</th>
                                    <th>Perfil</th>
                                    <template v-if="!editar">
                                        <th>Estado</th>
                                        <th>Ultimo Login</th>
                                    </template>
                                    <template v-else>
                                        <th colspan="2">Contraseña</th>
                                        <!-- <th></th> -->
                                    </template>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            
                            <tbody > 
                                <tr v-for="(usuario, index) in users" :key="usuario.id">
                                    <td>{{index + 1}}</td>
                                    <td>
                                        <template v-if="editar & idActualizar == index">  
                                            <input type="text" class="form-control shadow-sm" v-model="newUser">
                                        </template> 
                                        <template v-else>{{usuario.usuario}} </template>
                                    </td>
                                    <td>
                                        <template v-if="editar & idActualizar == index"> 
                                            <label for="" class="labelpe ml-1"> Nombre </label>
                                            <input type="text" class="form-control shadow-sm" v-model="newName">
                                            <label for="" class="labelpe ml-1"> Apellido</label> 
                                            <input type="text" class="form-control shadow-sm" v-model="newSurName"> 
                                        </template>
                                        <template v-else> {{usuario.nombre}} {{usuario.apellido}}</template>
                                       
                                    </td>
                                    <td>
                                        <template v-if="editar & idActualizar == index"> 
                                            <input type="text" class="form-control shadow-sm" v-model.number="newMobile"> 
                                            </template> 
                                        <template v-else> {{usuario.celular}}</template> 
                                    </td>
                                    <td style="width: 102px !important;" >
                                         <template v-if="editar & idActualizar == index"> 
                                            <img :src="path_upload + usuario.foto"  alt="" width="40px" class="elevation-1 img-bordered-sm img-fluid ">
                                            <img :src="prevnewimg"  alt="" width="40px" class="elevation-1 img-bordered-sm img-fluid ml-3 ">
                                            <!-- <button class="btn mt-2 btn-warning btn-sm">Cargar IMG</button> -->
                                            <div class="custom-fil mt-3 mr-4 ml-4 d-inline" >
                                                <label for="fileUpload" style="cursor: pointer;" class="file-upload btn btn-dark  btn-block btn-sm  shadow-sm"> 
                                                    <i class="fas fa-upload"></i> <span class="labelpe">FOTO</span>  
                                                    <input  type="file"  ref="filee"  @change="newimg()" id="fileUpload" class="form-control-file"
                                                    accept="image/png, .jpg, .jpeg"  > 
                                                 </label>
                                                <!-- <input type="file" ref="filee"  accept="image/png, .jpg, .jpeg" @change="newimg()" class="form-control-file" > -->
                                                 
                                            </div>
                                         </template>
                                         <template v-else>
                                             <div class="">
                                                <img :src="path_upload + usuario.foto"  alt="" width="40px" class="elevation-1 img-bordered-sm img-fluid ">
                                               
                                            </div> 
                                         </template>
                                    </td>

                                    <td>
                                         <template v-if="editar & idActualizar == index">
                                             <select class="custom-select select shadow-sm" v-model="selectedU"  style="width: 100%;"> 
                                                    <option v-for="rol in rols" :key="rol.id" :value="rol.id" v-text="rol.name"> </option>
                                            </select>
                                        </template>
                                        <template v-else>
                                            {{usuario.rol_id}}
                                        </template>
                                    </td>
                                    
                                    <template v-if="editar & idActualizar == index">
                                        <td colspan="2">
                                            <input type="text" class="form-control shadow-sm" v-model="newPassword" readonly> 
                                             
                                        </td>
                                        <!-- <td></td> -->
                                    </template>
                                    <template v-else>
                                        <td> 
                                            <button  v-if="Number(usuario.estado)" @click="cambiarState(usuario.id, usuario.estado, index)"
                                                class="btn btn-success btn-xs "> Activado</button> 
                                            <button  v-else @click="cambiarState(usuario.id,usuario.estado,index)" class="btn btn-danger btn-xs" > Desactivado</button>
                                            
                                        </td>
                                        <td >15-10-2019  </td>
                                    </template>

                                    <td>
                                        <div class="btn-group">
                                            <template v-if="editar  & idActualizar == index">
                                                <button class="btn btn-success mr-1 btn-sm" @click="updateUser(usuario.id)" > 
                                                    <span>Guardar</span>
                                                </button> 
                                                <button class="btn btn-dark btn-sm" @click="cancelar(index)" > 
                                                    <span>Cancelar</span>
                                                </button> 
                                            </template>

                                            <template v-else>
                                                <button class="btn btn-warning mr-2 btn-sm" @click="editarUser(index)" > 
                                                    <i class="fas fa-pencil-alt text-white" ></i>
                                                </button> 
                                                <button class="btn btn-danger btn-sm"  @click="deleteUser(usuario.id,usuario.foto, index)" > 
                                                    <i class="fa fa-times"></i>
                                                </button>
                                            </template>
                                             
                                        </div>
                                    </td>
                                </tr> 
                                 
 
                            </tbody> 

                        </table>
                    </div>

                </div>
            </div>
        </div>

    </section>
    <!-- MODAL USERS -->
    <userModal nameModal = "Agregar Usuario" :rols = "rols"
    @actualizarList="actualizarLista = $event" 
    
    ></userModal>
</div>
</template>

<script>

import {mapState,mapActions} from 'vuex';
import UserModal from '../../pages/users/UsersModalComponent';

export default {
    props : ['path_upload'],
    data(){
        return{
            editar : false,
            idActualizar : '',
            // users : [],
            actualizarLista :false,
            rols :'',
            newUser: '',
            newName: '',
            newSurName: '',
            newMobile: '',
            newFoto: '',
            newPerfil: '',
            newState: '',
            newPassword: '',
            prevnewimg: '',
            anteriorFoto : '',
            
        }
    }, 
    mounted(){
        console.log('Component userComponent Mounted')
        // Obteniendo todos los Usuarios
        this.obtenerusuarios();
       
        axios.get('users/allrols')
        .then(res =>{
            this.rols = res.data;
        })
        
    },
    computed:{
         ...mapState(['users'])
    },    
    components: { 
        'userModal' : UserModal,
    },

    methods:{ 
        ...mapActions(['obtenerusuarios']),

        // Actrualizar lista
        updateList(a){
            this.obtenerusuarios()
            this.actualizarLista = false;
        },
        deleteUser(id,fot,inde){
            
            let dat = new FormData();
            dat.append('id',id)
            dat.append('foto',fot)
            Swal.fire({
            title: '¿Esta seguro de borrar el usuario ?',
            text: "¡Si no lo está puede cancelar la accion!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Si, borrar usuario!'
            })
            .then((result) => {
                if (result.value) {
                        Swal.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                    )
                    axios.post('users/deleteproduct', dat)
                    .then(res =>{
                        this.users.splice(inde , 1); 
                        console.log('Elimado' ,res.data);
                    })
                }
            })
           
        },
        cambiarState(id,state,index){
            let dat = new FormData();
            dat.append('id',id)
            dat.append('state', Number(!Number(state)) )
            // this.users.estate= !this.users.estate;
             axios.post('users/updatestate',dat)
             .then(res =>{
                 console.log("REST", res.data)
                //  console.log("ESTATE", parseInt(state) )
                 console.log("ESTATE", Number(!Number(state))) 
                 this.users[index].estado = Number(!Number(state));
             })
        },
        editarUser(inde){
            this.prevnewimg = '', // Limpiando la img que se habia selecionado anteriormente
            this.newUser = this.users[inde].usuario
            this.newName = this.users[inde].nombre
            this.newSurName = this.users[inde].apellido
            this.newPassword = this.users[inde].password
            this.newState = this.users[inde].estado
            this.anteriorFoto = this.users[inde].foto
            // this.newFoto = '';
            this.selectedU = this.users[inde].id_rol
            this.newMobile = this.users[inde].celular
            this.idActualizar  = inde;
            // this.prevnewimg = this.indexpreviewimg
            this.editar = true;
            console.log('SELECTEC',this.selectedU);
        },
        cancelar(){
            this.prevnewimg = '',
            this.editar = false;
        },
        newimg(e){
            var input = event.target;
            let fotope =  event.target.files[0];
            console.log("INPUT" , input)
            if(input.files && input.files[0]){
                var reader = new FileReader();
                reader.onload = (e) =>{
                    this.prevnewimg = e.target.result;
                    this.newFoto = fotope
                }
                 reader.readAsDataURL(input.files[0]);
            }
             
            // console.log("this FILE",this.$refs.filee)
            // console.log("EVENT T", fotope)
            // console.log("EVENT", event.target.files[0].name)
        },

        updateUser(iduser){
            let newdat = new FormData();
            // console.log('EVENT IN UPDATEUSER',event.target)
            newdat.append('iduser',iduser)
            newdat.append('newuser',this.newUser)
            newdat.append('newname',this.newName)
            newdat.append('newsurname',this.newSurName)
            newdat.append('newpassword',this.newPassword)
            newdat.append('newmobile',this.newMobile)
            newdat.append('selectedu',this.selectedU)
            newdat.append('newstate',this.newState)
            newdat.append('newimg',this.newFoto)
            newdat.append('anteriorfoto',this.anteriorFoto)
            axios.post('users/updateuser',newdat,{
                headers :{
                    'Content-Type': 'multipart/form-data'
                }
            })
            .then(res =>{
                if(res.data = 'ok'){
                    this.obtenerusuarios();
                    Toast.fire({
                        type: 'success',
                        title: 'Usuario actualizado correctamente'
                    })
                    this.editar = false;
                }else{
                    Toast.fire({
                        type: 'error',
                        title: 'Error al actualizar usuario'
                    })
                }
                console.log("DATA", res.data);
            })
        }
        
    }
}

 
 
</script>

<style> 
 .file-upload input[type='file'] {
  display: none; 
}
.fade-enter-active, .fade-leave-active {
  transition: opacity .5s;
}
.fade-enter, .fade-leave-to {
  opacity: 0;
}
</style>