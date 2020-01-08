<template>
    <div class="content-wrapper">
        <content-header
            nameContent="Configuración Empresa"
            nameMain = "Home"
            nameAct = "Setting"
        >
        </content-header>

        <section class="content">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">

                        </div>
                        <div class="card-body">
                            <div class="  card">
                            <div class="row card-body "> 
                                <!-- IMAGE PREW -->
                                <div class="col-md-2 align-self-center">
                                    <div class="" v-if="namelogoimg !== ''" >
                                        <img :src="path_company + namelogoimg"  alt="" style="width: auto;height: 86px;" 
                                        class="elevation-1 img-bordered-sm img-fluid mb-3  mx-auto d-block">
                                       <!-- <small>Tamaño Sugerido 150px150px</small>  -->
                                    </div>    
                                </div>
                                <div class="col-md-2 align-self-center" v-if="prevnewimg !== ''">
                                    <img :src="prevnewimg"  alt="" style="width: auto;height: 86px;" 
                                        class="elevation-1 img-bordered-sm img-fluid mb-3  mx-auto d-block">
                                </div>
                                <div class="col-md-2 ml-auto text-right align-self-center">
                                    <!-- <label for="CargarImg" class="labelpe" ><i class="far fa-image fa-md"></i> Cargar Imagen</label> -->
                                    <div class="custom-fil mb-3" >
                                        <label for="fileUpload" style="cursor: pointer;" class="file-upload btn btn-dark  btn-block  shadow-sm"> 
                                            <i class="fas fa-upload"></i> <span class="labelpe">SUBIR LOGO</span>  
                                            <input  type="file"  ref="imagepro"  @change="imagecompany()" id="fileUpload" class="form-control-file"
                                            accept="image/png, .jpg, .jpeg"  > 
                                        </label>     
                                    </div> 
                                </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4 "> 
                                    <label for="RUC" class="labelpe"><i class="fas fa-building"></i> R.U.C</label>
                                    <div class="input-group">
                                        <input type="text" placeholder="R.U.C" v-model="ruc" class="form-control">
                                        <span class="input-group-append">
                                            <button type="button" class="btn btn-dark" @click="consultaruc()" >
                                                <i class="fas " :class="searhlupa"></i>
                                                </button>
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group col-md-4 ">
                                    <label for="Razón Social" class="labelpe"><i class="fas fa-suitcase"></i> Razón Social</label>
                                    <input type="text" placeholder="Razon Social" v-model="razon_social" class="form-control"> 
                                </div>
                                <div class="form-group col-md-4 ">
                                    <label for="NombreComercial" class="labelpe"><i class="fas fa-suitcase"></i> Nombre Comercial</label>
                                    <input type="text" v-model="nombre_comercial" placeholder="Nombre Comercial" class="form-control"> 
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-2"> 
                                    <label for="Telefono" class="labelpe"><i class="fas fa-phone-alt"></i> Telefono</label>
                                    <input type="text" placeholder="Telefono" v-model="telefono" class="form-control"> 
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="EmailEmpresa" class="labelpe"><i class="fas fa-envelope"></i> Email de la Empresa</label>
                                    <input type="text" placeholder="Email de la Empresa" v-model="email" class="form-control"> 
                                </div>
                                <div class="form-group col-md-3">  
                                     
                                        <label for="Ubigeo" class="labelpe"><i class="fas fa-globe"></i> Ubigeo</label>
                                        <select class="form-control " v-model="ubigeoselected" style="width: 100%;"> 
                                            <option disabled value="">Seleciona de Ubigeo </option>
                                            <option v-for="ubigeo in ubigeos" :key="ubigeo.id" :value="ubigeo.id">
                                                   {{ubigeo.provincia}} - {{ubigeo.distrito}}
                                            </option> 
                                        </select> 
                                    
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="DireccionF" class="labelpe"><i class="fas fa-map-marked-alt"></i> Direccion Fiscal</label>
                                    <input type="text" placeholder="Direccion Fiscal" v-model="direccion_fiscal" class="form-control"> 
                                </div>
                            </div>
                            <div class="row">
                                <!-- <div class="col-md-2">
                                    <label for="Código" class="labelpe"><i class="fas fa-percentage"></i> IGV</label> 
                                    <div class="input-group mb-3">
                                        <div class="input-group-append">
                                            <span class="input-group-text  bg-disabled-gray ">IGV </span>
                                        </div>
                                        <input type="text" name="igv" v-model="igvpe"  readonly="readonly" class="form-control">
                                    </div>
                                </div>  -->
                                
                                 <div class="col-md-4 ml-auto text-right ">  
                                    <button class="btn btn-primary " @click="savecompany()" >Guardar Información</button>
                                     
                                </div>
                            </div>

                            <p class="text-secondary  my-0 py-0" style="font-size:15px">Usuario y Password SOL - SUNAT</p>
                            <hr class="mt-1">

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="UsuarioSol" class="labelpe"><i class="fas fa-user-tie"></i> Usuario Sol</label>
                                    <input type="text" placeholder="Usuario Sol" class="form-control"> 
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="ContraseñaSol" class="labelpe"><i class="fas fa-lock"></i> Contraseña Sol</label>
                                    <input type="text" placeholder=" Contraseña Sol" class="form-control"> 
                                </div>
                                
                            </div>
                            <p class="text-secondary my-0 py-0" style="font-size:15px">Certificado Electrónico .pfx y Password</p>
                            <hr class="mt-1">
                            <div class="row">
                                 <div class="form-group col-md-6">
                                    <div class="custom-file">
                                        <!-- <label for="CertificadoElectronico" class="labelpe "><i class="fas fa-key"></i> Certificado Electronico</label> -->
                                        <input type="file" class="custom-file-input" id="customFilepe" >
                                        <label class="custom-file-label" for="customFilepe">Choose file</label> 
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <!-- <label for="Contraseña del Cetificado" class="labelpe"><i class="fas fa-lock"></i> Contraseña del Cetificado</label> -->
                                    <input type="text" placeholder="Contraseña del Cetificado" class="form-control"> 
                                </div>

                            </div>
                            
                            <div class="row">
                                <div class="col-md-4 ml-auto text-right">
                                    <button class="btn btn-primary ">Guardar </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


    </div>
</template>

<script>
import {mapState, mapActions} from 'vuex'
export default {
    data(){
        return{
            ruc : '',
            razon_social: '',
            nombre_comercial: '',
            telefono : '',
            email: '',
            ubigeoselected : '',
            searhlupa: 'fa-search',
            direccion_fiscal: '',
            igvpe: '18%',
            prevnewimg:  '',
            defaultimg:'',
            namelogoimg: '',

        }
    },
    mounted(){
        console.log(this.ubigeos)
        this.getcompany();
        this.obtenerUbigeo();
    },
    computed:{
        ...mapState(['ubigeos','path_company'])
    },
    methods:{
        ...mapActions(['obtenerUbigeo']),
        consultaruc(){
            if(this.ruc.length !== 11){return true;}
            this.searhlupa = 'fa-spinner fa-spin';
            axios.post('settingcompany/consultaruc',{
                ruc : this.ruc
            }).then(res =>{
                this.searhlupa = 'fa-search';
                this.razon_social = res.data.razonSocial
                this.nombre_comercial = res.data.nombreComercial
                console.log(res.data)
            })
        },
        imagecompany(){
            var input = event.target;
            // console.log("INPUT" , input)
            if(input.files && input.files[0]){
                var reader = new FileReader();
                reader.onload = (e) =>{
                    this.prevnewimg = e.target.result;
                }
                 reader.readAsDataURL(input.files[0]);
            }
        },
        getcompany(){
            axios.get('settingcompany/getcompany')
            .then(res =>{
                console.log(res.data)
                this.ruc = res.data.ruc
                this.razon_social = res.data.razon_social
                this.nombre_comercial = res.data.nombre_comercial
                this.telefono = res.data.telefono
                this.email = res.data.email
                this.ubigeoselected = res.data.ubigeo_id
                this.namelogoimg = res.data.logo
            })
        },
        savecompany(){
            let fordata = new FormData()
            fordata.append('ruc',this.ruc)
            fordata.append('razon_social',this.razon_social)
            fordata.append('nombre_comercial',this.nombre_comercial)
            fordata.append('telefono',this.telefono)
            fordata.append('email',this.email)
            fordata.append('ubigeoselected',this.ubigeoselected)
            fordata.append('direccion_fiscal',this.direccion_fiscal)
            fordata.append('anteriorfoto', this.namelogoimg)
            fordata.append('image', this.$refs.imagepro.files[0])
            axios.post('settingcompany/updatecompany',fordata, {headers: {'Content-Type': 'multipart/form-data' }})
            .then(res =>{
                console.log(res.data)
                this.prevnewimg = ''; 
                this.$refs.imagepro.value='';
                this.getcompany();
                if(res.data == 'ok'){
                    toastr.success('Datos guardados correctamente'); 
                }else{
                    toastr.error('Error al Guardar')
                }
            })
        }
    }
}


</script>

<style>

</style>