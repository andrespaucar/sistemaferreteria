<template>
  <div class="card-body pt-1 table-responsive">
      <!-- ADD USER -->
        <div v-if="showaddcustomer" class="row pt-3">  
            <div class="form-group col-md-2">
                <select class="form-control" v-model="select_tipo_doc">
                    <option  disabled value="">TIPO DOC</option>
                    <option v-for="tipo_doc in tipo_docs" :key="tipo_doc.id" :value="tipo_doc.id"
                        >{{tipo_doc.nombre}}</option>
                     
                </select>
            </div>
            <div class="form-group col-md-3">
                <!-- <input type="text" placeholder="N. Doc."  class="form-control">  -->
                <div class="input-group "> 
                    <input type="text" class="form-control" maxlength="11" v-model="num_doc" :class="existedoc" @change="verify_doc()"  pattern="[0-9]*" 
                                inputmode="numeric"  placeholder="Número de documento">
                    <div class="input-group-append"> 
                        <button class="btn btn-dark" @click="apiperuconsut()" ><i class="fa" :class="searhlupa"></i></button> 
                    </div>
                </div> 
            </div>
            <div class="form-group col-md-3">
                <input type="text" placeholder="Razon Social o Nombre" v-model="razon_social_nombre"  class="form-control">
            </div>
            <div class="form-group col-md-2">
                <input type="text" placeholder="Telefono" v-model="telefono_cli" class="form-control">
            </div>
            <div class="form-group col-md-2">
                <input type="text" placeholder="Email" v-model="email_cli" class="form-control">
            </div> 
            <div class="form-group col-md-3">
                <input type="text" placeholder="Dirección" v-model="direccion_cli" class="form-control">
            </div> 
            <div class="form-group col-md-3">
                <select v-model="ubigeo_cli" class="form-control">
                    <option disabled value="">Ubigeo</option> 
                    <option v-for="ubigeo in ubigeos" :key="ubigeo.id" :value="ubigeo.id" > {{ubigeo.provincia}} - {{ubigeo.distrito}} </option> 
                </select>
            </div> 
            <div class="form-group col-md-2">
                <button v-if="addshow" class="btn btn-primary btn-sm" :disabled="btndisableadd" @click="add()">Agregar</button>
            </div> 
            
        </div> 
         
        <table class="table  dt-responsive table-hover" style="width:100%" >
            <thead>
                <tr>
                    <th>#</th>
                    <th>R. Social</th>
                    <th>N. Doc.</th>
                    <th>Tipo Doc.</th>
                    <th>Telefono</th>
                    <th>Email</th>
                    <th>Estado</th>
                    <th>Registrado el</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(customer, index) in filtercustomers" :key="customer.id">
                    <td>{{index +1 }}</td>
                    <td>
                        <p v-text="customer.razon_social"></p> 
                    </td>
                    <td>
                       <p v-text="customer.doc"></p>
                    </td>
                    <td>
                        <p v-text="customer.tipo_doc"></p> 
                    </td>
                    <td>
                        <p>{{customer.telefono}}</p> 
                    </td>
                    <td>
                        <p>{{customer.email}}</p>
                    </td>
                    <td>
                        <button class="btn btn-xs" @click="changeStatec(customer.id, customer.estado, index)" :class="(customer.estado==1)? 'btn-success':'btn-danger'">
                            {{(Boolean(Number(customer.estado)))? 'Activo':'Desactivado'}}
                        </button>
                    </td>
                    <td>
                        <p>{{customer.created_at.split(' ')[0]}}</p>
                    </td>
                    <td>
                        <div class="btn-group">
                           
                                 <button @click="edit(index)" class="btn btn-warning btn-sm">
                                    <i class="fas fa-pencil-alt text-white"></i>
                                </button> 
                                <button @click="deletecustomer(index, customer.id)"  class="btn btn-danger btn-sm">
                                    <i class="fa fa-times"></i>
                                </button>
                           
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import {mapState, mapActions} from 'vuex';
export default {
    props : ['buscandocustomer','showaddcustomer'],
    data(){
        return{
            addshow : true,
            showedit: false,
            searhlupa: 'fa-search',
            newName: '',
            direccion_cli:'',
            select_tipo_doc:'',
            num_doc : '',
            razon_social_nombre :'',
            telefono_cli : '',
            email_cli : '',
            ubigeo_cli: '',
            existedoc : '',
            btndisableadd: false,
        }
    },
    mounted(){ 
        this.obtenerclientes();
        this.obtenerTipoDocs();
        this.obtenerUbigeo();
    },
    computed:{
        
        ...mapState(['customers','ubigeos','tipo_docs']),
        filtercustomers(){
            if(this.buscandocustomer){
                return this.customers.filter(customer =>{
                    return  customer.razon_social.toLowerCase().includes(this.buscandocustomer.toLowerCase()) ||
                            customer.doc.toLowerCase().includes(this.buscandocustomer.toLowerCase())
                })
            }else{
                return this.customers
            }
        }
    },
    methods:{
        ...mapActions(['obtenerclientes','obtenerUbigeo','obtenerTipoDocs']),
        add(){
            axios.post('customers/addcustomer',{
                select_tipo_doc : this.select_tipo_doc,
                num_doc         : this.num_doc,
                razon_social_nombre : this.razon_social_nombre,
                telefono_cli        : this.telefono_cli,
                email_cli           : this.email_cli,
                direccion_cli           : this.direccion_cli,
                ubigeo_cli         : this.ubigeo_cli,
            }).then(res =>{
                console.log(res.data)
                if(res.data == 'ok'){
                    toastr.success('Agregado Correctamente');
                    this.obtenerclientes();
                    this.limpiar_cli();
                }else{
                    toastr.error('Error: completar datos');
                    console.log('ERROR', res.data)
                }
            }) 
        },
        limpiar_cli(){
            this.select_tipo_doc = '';
            this.num_doc = '';
            this.razon_social_nombre = '';
            this.telefono_cli = '';
            this.email_cli = '';
            this.direccion_cli = '',
            this.ubigeo_cli = ''; 
        },
        edit(index){
            // this.addshow = false;
            // this.showaddcustomer = true;
            // this.num_doc = this.customers[index].doc;
        },
        changeStatec(id, state, index){
            axios.post('customers/updatestate',{id: id,state : state})
            .then(res => {
                if(res.data == 'ok'){
                    this.customers[index].estado = Boolean(!Number(state));
                }else{
                    toastr.error('Error al cambiar estado')
                }
            })
        },
         
        apiperuconsut(){
            this.searhlupa = 'fa-spinner fa-spin';
            axios.post('customers/peruconsult',{
                tipodoc : this.select_tipo_doc,
                numdoc : this.num_doc
            }).then(res =>{
                this.searhlupa = 'fa-search';
                if(res.data.doc == 'DNI'){
                    this.razon_social_nombre = res.data.person.nombres +' '+ res.data.person.apellidoPaterno +' '+ res.data.person.apellidoMaterno;
                    return true;
                }
                if(res.data.doc == 'RUC'){
                    this.razon_social_nombre = res.data.company.razonSocial;
                    return true;
                }
                
            })
        },
        verify_doc(){
            axios.post('customers/verifydoc',{
                num_doc : this.num_doc
            }).then(res =>{
                if(res.data == 'siexiste'){
                    this.existedoc = 'is-invalid';
                    this.btndisableadd = true;
                }else{
                    this.existedoc = 'is-valid';
                    this.btndisableadd = false;
                }
                console.log(res.data)
            }) 
        },
        deletecustomer(index, customerId){
            console.log(customerId)
            Swal.fire({
            title: '¿Esta seguro de borrar al Cliente ?',
            text: "¡Si no lo está puede cancelar la accion!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Si, borrar cliente!'
            })
            .then((result) => {
                if (result.value) { 
                    axios.post('customers/delecustomer',{
                        id : customerId
                    }).then(res =>{
                        if(res.data == 'ok'){
                            Swal.fire(
                            'Eliminado!',
                            'El cliente ha sido cambido de estado #'+customerId,
                            'success' )
                            this.obtenerclientes();
                        }
                        console.log(res.data)
                    });
                }
            })
            
        }

    }
}
</script>

<style>

</style>
