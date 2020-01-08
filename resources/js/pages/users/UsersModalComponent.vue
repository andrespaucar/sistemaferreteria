<template>
  <div class="modal fade  " id="modalUser"  tabindex="-1" role="dialog" aria-labelledby="modalUser" aria-hidden="true">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{nameModal}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST"> 
                    <!-- CODIGO DE BARRA Y NOMBRE DEL PRODUCT -->
                    <div class="row">
                        <div class="col-6">
                            <label for="Código" class="labelpe" ><i class="fas fa-user"></i> Usuario</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" v-model="user" placeholder="Usuario">
                                <div class="input-group-append">
                                    <button class="btn bg-dark "  type="button" @click="generate_user"><i class="fas fa-redo fa-flip-horizontal"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <label for="Codigo" class="labelpe"><i class="fas fa-lock"></i> Contraseña</label>
                            <div class="input-group mb-3">
                                <input   type="text" class="form-control" placeholder="Contraseña" v-model="pass" >
                                <div class="input-group-append"> 
                                        <button class="btn btn-dark" type="button" @click="generate_pass"> Generar</button> 
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- CATEGORIAS Y UNIDADESD DE MEDIDAS-->
                    <div class="row">
                        <div class="col-6">
                                <div class="form-group">
                                    <label for="Codigo" class="labelpe"><i class="fas fa-user"></i> Nombre</label>
                                    <input type="text" class="form-control" v-model="name" placeholder="Nombre">
                                </div> 
                        </div>
                        <div class="col-6">
                                <div class="form-group">
                                    <label for="Codigo" class="labelpe"><i class="fas fa-user"></i> Apellido</label>
                                    <input type="text" class="form-control" v-model="surname" placeholder="Apellido">
                                </div> 
                        </div>
                         
                    </div>
                    <!-- CELULAR - ROL  -->
                    <div class="row">
                        <div class="col-6">
                                <div class="form-group">
                                    <label for="Codigo" class="labelpe"><i class="fas fa-mobile-alt"></i> Celular</label>
                                    <input type="text" class="form-control" v-model.number="mobile" placeholder="Celular">
                                </div>
                        </div>
                        <div class="col-6"> 
                            <label for="Código" class="labelpe"><i class="fas fa-users"></i> Rol</label>
                            <div class="input-group mb-3">
                            <select class="custom-select select" v-model="selected"  style="width: 100%;">
                                    
                                    <option disabled value="">Selecione un Perfil</option>
                                    <option v-for="rol in rols" :key="rol.id" :value="rol.id" v-text="rol.name"> </option>
                                   
                            </select> 
                            </div> 
                        </div>
                    </div>

                    <!-- FILE - IMG USER -->
                    <div class="row">
                        <div class="custom-file col-6">
                            <label >Subir Foto <small> Max: 2M | jpg y png</small> </label>
                            <input type="file" ref="file"  accept="image/png, .jpg, .jpeg" @change="img_upload()" class="form-control-file" >
                        </div>
                        <div class="col-6">
                            <img :src="previmg"   alt="" width="40px" class="elevation-1 img-bordered-sm img-fluid ">
                        </div>
                    </div>
                
                    
                </form>
            </div>
            <div class="modal-footer">
                <transition name="fade"> 
                    <span v-show="err" class="text-danger mr">Hay datos que se tiene que completar</span>
                </transition>
                <button type="button" class="btn btn-secondary" @click="limpiar" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" @click="add_user" >Guardar</button>
            </div>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    props: ['nameModal','rols'],
    data(){
        return{
            user : '',
            pass : '',
            image : '',
            name : '',
            surname : '',
            mobile : '',
            selected : '',
            err: false,
            previmg : 'public/uploads/users/default.jpg' ,
            updateList :true,
            // rols :''
        }
    },
    mounted(){
        // console.log(this.rols)
        console.log('MODAL USER ADD CREADO'); 
    },
    
    methods:{
        img_upload(){
            this.image = this.$refs.file.files[0];
            // console.log("this FILE",this.$refs.file)
            // console.log("EVENT", event.target.files[0])
             var input = event.target;
            // let fotope =  event.target.files[0];
            console.log("INPUT" , input)
            if(input.files && input.files[0]){
                var reader = new FileReader();
                reader.onload = (e) =>{
                    this.previmg = e.target.result;
                    // this.newFoto = fotope
                }
                 reader.readAsDataURL(input.files[0]);
            }
        },
        generate_user(){
            let r = Math.random().toString(36).substring(6);
            this.user = r;
        },
        generate_pass(){
            let r = Math.random().toString(36).substring(6);
            this.pass = r;
        },
        add_user(){ 
            let da = new FormData();
            da.append('image',this.$refs.file.files[0]);
            da.append('user',this.user);
            da.append('pass',this.pass);
            da.append('name',this.name);
            da.append('surname',this.surname);
            da.append('selected',this.selected);
            da.append('mobile',this.mobile);
            if(this.image.size > 2048000){ 
                Toast.fire({
                    type: 'error',
                    title: 'Imagen es mayor a 2M PE'
                })
                return;
            }
            // console.log(this.selected)
            // return;
            // Para validar los datos
            if( !da.get('user') || !da.get('pass')|| !da.get('name')|| !da.get('surname') || !da.get('selected')|| !da.get('mobile') ){
                this.err = true;
                console.log('Hay datos vacios...')
                return;
            } 
            axios.post('users/add',da,{
                headers :{
                    'Content-Type': 'multipart/form-data'
                }
            })
            .then(res =>{
                if(res.data == 'ok'){
                    //Enviamos al componente padre a que se pueda actualizar la lista...
                    this.$emit('actualizarList',this.updateList);
                    Toast.fire({
                        type: 'success',
                        title: 'Usuario agregado correctamente'
                    })
                    this.limpiar();
                    this.err = false;
                    // console.log('RES', res.data)
                    // console.log('RES', res)
                    
                }else{
                    console.log('ERROR',res.data)
                }
            })
        },
        limpiar(){
            this.user = ''
            this.name = ''
            this.surname = ''
            this.pass = ''
            this.selected = ''
            this.mobile = ''
            this.previmg = 'public/uploads/users/default.jpg'
            this.$refs.file.value=''// Limpiamos el input de la img Subido 
            
        }
    }
}


</script>

<style>
.fade-enter-active, .fade-leave-active {
  transition: opacity .5s;
}
.fade-enter, .fade-leave-to {
  opacity: 0;
}
</style>