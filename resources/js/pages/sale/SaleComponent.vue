<template>
  <div class="content-wrapper">
    <content-header
    nameContent="Ventas"
    nameMain = "Home"
    nameAct = "Sale"
    ></content-header>

    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header"> 
                        <p class="card-title">{{namecomprobantepe}}</p> 
                    </div>

                    <div class="card-body"> 
                        <div class="row">
                            <!-- TIPO DE DOC -->
                            <div class="col-md-4  form-group">
                                <label for="Cliente" class="labelpe"><i class="fas fa-user "></i> Tipo Doc.Ident</label>
                                 <select class="form-control" v-model="tipo_doc_select" > 
                                    <option disabled value="">Selecione Doc.</option>
                                    <option :value="1">D.N.I</option>
                                    <option :value="2">R.U.C</option> 
                                </select> 
                            </div>
                            <!-- NUM DOC -->
                            <div class="col-md-4  form-group">
                                <label for="N° de Doc" class="labelpe" >
                                    <i class="fas fa-pencil-alt "></i> N° de Doc. <i class="fas fa-circle fa-xs " :class="existecli" ></i>
                                </label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" v-model="num_doc" pattern="[0-9]*" inputmode="numeric"  placeholder="Número de documento Aquí">
                                    <div class="input-group-append"> 
                                        <button class="btn btn-dark" @click="searchClient()" ><i class="fas" :class="searhlupa" ></i></button> 
                                    </div>
                                </div> 
                            </div>
                            <!-- RAZON SOCIAL - NOMBRE APELLIDO -->
                            <div class="col-md-4  form-group">
                                <label for="Razon Social o Dato Persona" class="labelpe" :class="existecli" ><i class="fas fa-id-card"></i> Razon Social o Dato Persona</label>
                                <input type="text" class="form-control" v-model="razon_social_nom" placeholder="Nombre o Razón Social Aquí">
                            </div>

                        </div>
                        <div class="row">
                            <!-- DIRECCION -->
                            <div class="col-md-5 form-group">
                                <label for="Razon Social o Dato Persona" class="labelpe" :class="existecli"><i class="fas fa-house-damage"></i> Dirección</label>
                                <input type="text" class="form-control" v-model="direccion" placeholder="Escribe aqui la dirección completa">
                            </div>
                            <!-- UBIGEOS -->
                            <div class="col-md-5  form-group">
                                <label for="Ubigeo" class="labelpe" :class="existecli"><i class="fas fa-globe"></i> Ubigeo</label>
                                 <select class="form-control " v-model="ubigeoselected" style="width: 100%;"> 
                                    <option disabled value="">Seleciona Tu código de Ubigeo </option>
                                    <option v-for="ubigeo in ubigeos" :key="ubigeo.id" :value="ubigeo.id">
                                        {{ubigeo.departamento}} - {{ubigeo.provincia}} - {{ubigeo.distrito}}
                                    </option> 
                                </select> 
                            </div>
                            <!-- SERIE DE FACTURA -->
                            <!-- <div class="col-md-3 form-group">
                                <label for="Razon Social o Dato Persona" class="labelpe"><i class="fas fa-file-alt"></i> Serie N°</label>
                                <input type="text" class="form-control" v-model="num_serie" readonly>
                            </div> -->

                        </div>

                        <div class="card-header">
                            Lista de Productos
                        </div> <br>
                        <!-- LISTA PRODUCTOS SELECCIONADOS EN LA VENTA -->
                        <div class="row"> 
                            <div class="col-md-3"> 
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control " :class="estado_encontrado"  placeholder="Ingrese Codigo de Barras"
                                       @change="validad_product()" v-model="buscar_code_product"  >
                                    <div class="input-group-append"> 
                                        <button class="btn btn-dark"  ><i class="fas fa-barcode"></i></button> 
                                    </div>
                                    <div class="invalid-feedback">
                                        No se encontro Producto con este Codigo 
                                    </div>
                                </div>
                            </div>
                       
                            <template  v-if="estado_encontrado === 'is-valid'">
                                <div class="col-md-3">
                                    <div class="form-grou">
                                        <input type="text" class="form-control"  :class="estado_encontrado" v-model="name_encontrado" readonly>
                                    </div>
                                </div>
                            </template>
                           
                            <div class="col-md-2  form-group">
                                <div class="input-group mb-3 ">
                                    <div class="input-group-prepend">
                                        <button class="btn btn-dark "  @click="cantProd++"><i class="fas fa-plus"></i></button> 
                                    </div>
                                    <input type="number" class="form-control " :class="estado_encontrado" min="1" max="99999" inputmode="numeric" v-model="cantProd">
                                    <div class="input-group-append">
                                        <button class="btn btn-dark" :disabled="cantProd==1 ||cantProd==0 " @click="cantProd--" ><i class="fas fa-minus"></i></button> 
                                    </div>
                                    <div class="valid-tooltip " >
                                            Stock : {{stock_encontrado}}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-2">
                                <button class="btn btn-success" @click="buscar_p()" ><i class="fas fa-plus"></i> 
                                </button>
                            </div>
                        </div>
                        <div class="row">
                            <button class="btn btn-success ml-auto" data-toggle="modal" 
                                    data-target="#modal-listproduct"><i class="fas fa-plus"></i> Agregar
                            </button>
                        </div>
                        <hr>

                        <!-- LISTA DE COMPRA -->
                        <div class="row">
                          
                            <div class="card-body pb-2 pt-0 px-2 mb-3 elevation-1 table-responsive" style="height:280px">
                                <table class=" table table-hover table-bordered table-head-fixed " >
                                    <thead>                  
                                        <tr >
                                            <th style="width: 10px">#</th>
                                            <th>Codigo</th>
                                            <th>Descripción</th>
                                            <th>U.Medida</th>
                                            <th>Cantidad</th>
                                            <th>Precio</th>
                                            <th >Sub.Total</th>
                                            <th>P.Venta</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody >
                                        <tr v-for="(listCompra, index) in listCompras" :key ="listCompra.id"  >
                                            <td>{{index +1}}</td>
                                            <td >{{listCompra.codigo}}</td>
                                            <td>{{listCompra.name}}</td>
                                            <td>{{listCompra.simbolo}}</td>
                                            <td>{{listCompra.cantidad}}</td>
                                            <td>S/. {{listCompra.p_venta_sin}}</td>
                                            <td class="table-primary">S/. {{ listCompra.cantidad * listCompra.p_venta_sin  }}</td>
                                            <td >S/. {{listCompra.p_venta_in  }}</td>
                                            <td class="form-group">
                                                <button class="btn btn-primary btn-sm">
                                                    <i class="fas fa-pen"></i>
                                                </button>
                                                <button class="btn  btn-danger btn-sm" @click="deleteList(index)">
                                                    <i class="fas fa-trash"></i>
                                                </button> 
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                           
                            
                        </div>

                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="des" class="labelpe"><i class="fas fa-percentage "></i> Descuento Total (porcentaje %)</label>
                                    <input type="text" v-model.number="descuent_pe" @change="ejecutando_descuento()" class="form-control w-50">
                                </div>
                                <div class="form-group">
                                    <label for="des" class="labelpe"><i class="fas fa-file-alt"></i> Observacion</label>
                                    <textarea cols="30" class="form-control " rows="4"></textarea> 
                                </div>
                            </div>
                            <div class="col-md-4">
                                <!-- <label for="resumen" class="labelpe" >Resumen:</label> -->
                                <table class="bg-navy table table-condensed" id="tablaResumen">
                                    <thead>
                                        <tr>
                                            <th colspan="2" class="text-center">Resumen</th>
                                        </tr>
                                                         
                                        <tr v-if="descuent_total !== 0"> 
                                            <th>Sub Total Ventas: </th> 
                                            <th class="h5">S/. {{sub_total_venta}}</th>
                                        </tr>
                                        <tr> 
                                            <th>Gravada</th> 
                                            <th class="h5">S/. {{neto}}</th>
                                        </tr>
                                        <tr>
                                            <th>(-) Descuento Total</th> 
                                            <th class="h5">{{descuent_total}}</th>
                                        </tr>
                                        <tr>
                                            <th>IGV (18%) </th> 
                                            <th class="h5">S/. {{imp_igv}}</th>
                                        </tr>
                                        <tr>
                                            <th >TOTAL</th>  
                                            <th class="h5">S/. {{imp_total}}</th>
                                        </tr>
                                    </thead> 
                                </table>
                            </div>
                        </div>
                        

                        <hr>
                        <!-- GENERAR DOCUMENTO -->
                        <div class="row mt-2">
                                <div class="col-md-4 d-flex justify-content-center">
                                    <div class="form-group clearfix">
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="radioPrimary1" name="r1" value="firmarImprimir"  checked>
                                            <label for="radioPrimary1">
                                                Solo Firmar e Imprimir
                                            </label>
                                        </div> 
                                    </div>
                                </div>
                                <div class="col-md-4  d-flex justify-content-center">
                                    <div class="form-group clearfix">
                                        <div class="icheck-success d-inline">
                                            <input type="radio" id="radioPrimary2" name="r1" value="enviarSunat" >
                                            <label for="radioPrimary2">
                                                Enviar a SUNAT ahora mismo!
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4  d-flex justify-content-center">
                                    <div class="icheck-danger d-inline">
                                        <input type="radio" id="radioPrimary3" name="r1" checked value="soloGuardar" >
                                        <label for="radioPrimary3">
                                            Solo Guardar la Venta
                                        </label>
                                    </div>
                                </div>
                        </div>
                        <!-- GUARDAR DOCUMENTO -->
                        <div class="row mt-4 d-flex justify-content-center">
                            <div class=" form-group">
                                <button class="btn btn-primary"   @click="save_venta()" ><i class="fas fa-save"></i> GUARDAR DOCUMENTO</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Modal Lista productos para Agregar -->
    <add-modal-listprod
        :updneto= "updneto"
    ></add-modal-listprod>
  </div>
</template>

<script>
import {mapState,mapActions} from 'vuex';  
export default {
    // props: ['nombrecomprobante'],
    data(){
        return{
            existecli:'',
            tipo_doc_select: '',
            searhlupa:'fa-search',
            direccion:'',
            num_doc:'',
            num_serie: '',
            tipocomprobante:'',
            idcliente:'',
            razon_social_nom: '',
            ubigeoselected: '',
            buscar_code_product:'',
            cantProd:1, 
            neto: '',
            imp_igv:'',
            imp_total:'',
            sub_total_venta: '',
            descuent_total: 0,
            descuent_pe : 0,
            tipo_save :'',
            namecomprobantepe:'',
            estado_encontrado: '',
            stock_encontrado : '',name_encontrado :''
        }
    },
    mounted(){ //import {} from './numero_letra';
        console.log('Component Sale Mounted');
        console.log(NumeroALetras(44));
        // TIpoComprobante
        // if(this.nombrecomprobante == 'factura'){
        //     this.tipo_doc_select = 2 ;
        //     this.tipocomprobante = 1 ;
        //     this.num_serie = "F001" ;
        // }
        // if(this.nombrecomprobante == 'boleta'){
        //     this.tipo_doc_select = 1;
        //     this.tipocomprobante = 2;
        //     this.num_serie = "B001";
        // } 
        //Obteniendo Ubigeos
        this.obtenerUbigeo();
        this.updneto();
    },
    watch:{
        tipo_doc_select:function(){
            if(this.tipo_doc_select == 2){
                this.namecomprobantepe = "FACTURA"
                this.tipocomprobante = 1 ;
                this.num_serie = "F001" ;
            }
            if(this.tipo_doc_select == 1){
                this.namecomprobantepe = "BOLETA"
                this.tipocomprobante = 2 ;
                this.num_serie = "B001" ;
            }
        }
    },
     
    computed:{
        ...mapState(['ubigeos','listCompras']), 
    },
    methods:{
        ...mapActions(['obtenerUbigeo']),
        buscar_p(){
            axios.post('sale/buscarproduct',{
                code : this.buscar_code_product,
                cantidad : this.cantProd
            }).then(res =>{
                if(res.data){
                    this.listCompras.push(res.data);
                }
                console.log(res.data);
                this.estado_encontrado = '';
                this.buscar_code_product = '';
                this.name_encontrado = '';
                this.cantProd = 1
            })
              
        },
        validad_product(){
            axios.post('sale/buscarproduct',{
                code : this.buscar_code_product,
                cantidad : this.cantProd
            }).then(res =>{
                if(res.data){ 
                    this.estado_encontrado = 'is-valid'
                    this.stock_encontrado = res.data.stock_actual
                    this.name_encontrado = res.data.name
                }else{
                    this.estado_encontrado = 'is-invalid'
                }
                console.log(res.data); 
            })
        },
        //Actualizadno el Precio Neto
        updneto(){
            console.log('SUMANDO NETO PE')
            if(this.descuent_pe == 0){
                this.neto = this.listCompras.reduce((sum, value) => (sum + Number(value.p_venta_sin) * Number(value.cantidad) ),0);
                this.imp_igv = this.round_math(this.neto * 0.18, 2);
                this.imp_total = this.round_math(this.neto * 1.18, 2);
            }else{
                this.neto = this.listCompras.reduce((sum, value) => (sum + Number(value.p_venta_sin) * Number(value.cantidad) ),0);
                this.sub_total_venta = this.neto;
                this.descuent_total = this.round_math( (this.descuent_pe / 100 )* this.neto, 2) ;
                this.neto = this.neto - this.descuent_total;
                this.imp_igv = this.round_math(this.neto * 0.18, 2);
                this.imp_total = this.round_math(this.neto * 1.18, 2);
            }
        },
        ejecutando_descuento(){
            this.updneto();
        },
        //Eliminamos un producto de la lista de compra
        deleteList(index){
            this.listCompras[index].enable = 1;
            this.listCompras.splice(index,1)
            this.updneto();
        },
        round_math(numero, decimales) {
            var flotante = parseFloat(numero);
            var resultado = Math.round(flotante * Math.pow(10, decimales)) / Math.pow(10, decimales);
            return resultado;
        },

        searchClient(){
            // console.log(this.num_doc.length !== 8)
            if(this.num_doc == '' && (this.num_doc.length !== 8 || this.num_doc.length !== 11)) {return true;}
            this.searhlupa = 'fa-spinner fa-spin';
            axios.post('sale/searchclient',{
                tipoDoc : this.tipo_doc_select,
                numDoc : this.num_doc
            }).then(res =>{
                this.searhlupa = 'fa-search';
                if(res.data.doc == 'DNI'){
                    this.existecli = 'text-danger'
                    this.razon_social_nom = res.data.person.nombres +' '+ res.data.person.apellidoPaterno +' '+ res.data.person.apellidoMaterno;
                    this.direccion = '',
                    this.ubigeoselected =''
                    this.idcliente = ''
                    return true;
                }
                if(res.data.doc == 'RUC'){
                    this.existecli = 'text-danger'
                    this.razon_social_nom = res.data.company.razonSocial;
                    this.direccion = '',
                    this.ubigeoselected = ''
                    this.idcliente =''
                    return true;
                }
                this.existecli = 'text-success'
                this.razon_social_nom = res.data.razon_social
                this.direccion = res.data.direccion
                this.ubigeoselected = res.data.ubigeo_id
                this.idcliente = res.data.idcliente
                console.log(res.data)
                
            })
        },

        save_venta(){
            console.log('tipo_doc_select: ',this.tipo_doc_select,
            'num_serie: ',this.num_serie,'tipocomprobante: ', this.tipocomprobante);
            if(this.listCompras == ''){
                return true;
            }
            // let resumenTable = document.getElementById('tablaResumen')
            // resumenTable.classList.remove('bg-navy','table-condensed')
             
            Swal.fire({
            title: 'Necesitamos de tu Confirmación',
            html: ` Se creará el documento electrónico con los siguientes datos!
                    <table class=" table " > 
                        <thead>        
                            <tr><th colspan="2" class="text-center">Resumen</th></tr>                 
                            <tr> 
                                <th>Gravada</th> 
                                <th class="h5">S/. ${this.neto}</th>
                            </tr>
                            <tr>
                                <th>Descuento Total</th> 
                                <th class="h5">${this.descuent_total}</th>
                            </tr>
                            <tr>
                                <th>IGV (18%) </th> 
                                <th class="h5">S/. ${this.imp_igv}</th>
                            </tr>
                            <tr>
                                <th >TOTAL</th>  
                                <th class="h5">S/. ${this.imp_total}</th>
                            </tr>
                        </thead> 
                    </table> <b class="font-weight-bold text-success">¿Está Usted de Acuerdo?</b>`,
            type: 'warning',
            showCancelButton: true,reverseButtons: false,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#dc3545',
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Si, borrar usuario!',
            showLoaderOnConfirm: true, 
            preConfirm:  () =>{ 
                return axios.post('sale/guardarventa',{
                        tipo_doc_select : this.tipo_doc_select,
                        num_doc : this.num_doc,
                        idcliente : this.idcliente,
                        razon_social_nom : this.razon_social_nom,
                        direccion : this.direccion,
                        ubigeoselected : this.ubigeoselected,
                        listCompras : this.listCompras,
                        grabada : this.neto,
                        descuent_total : this.descuent_total,
                        imp_igv : this.imp_igv,
                        imp_total   : this.imp_total,
                        letra_numero : NumeroALetras(this.imp_total),
                        tipo_save   : $('input[name="r1"]:checked').val(),
                        tipocomprobante : this.tipocomprobante,
                        num_serie : this.num_serie,
                    }).then(response => {
                        if( response.status == 200){
                            return response;
                        }
                    }) 
                },
            allowOutsideClick: () => false
            }).then((result) => {
                console.log(result.value.data); 
                if (result.value.data.ok == 'ok') {
                    Swal.fire({
                        type :'success',
                        title: `${result.value.data.estado_envio}`,
                        html: ` ${result.value.data.estado_guardado} </br> </br>
                                ${result.value.data.message} </br> </br>
                                ${result.value.data.pdf} ${result.value.data.ticket}`,
                        confirmButtonText: 'Realizar otra Venta!',
                        cancelButtonText: 'Ver Lista Documentos',
                        cancelButtonColor: '#f15642',
                        showCancelButton: true,
                        allowOutsideClick: false
                    }).then( (result) =>{
                        if(result.value){
                            window.location.reload(true);
                        }else{
                            window.location.href = "saleall";
                        }
                    } )
                }else{
                    Swal.fire('Error!',
                        'Erro al guardar el Documento!',
                        'error')
                }
            })


        }
    }

}
</script>

<style>

</style>