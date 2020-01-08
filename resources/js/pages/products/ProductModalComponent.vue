<template>
    <div class="modal fade" id="modalProduct"  tabindex="-1" role="dialog" data-backdrop="static" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content ">
            <div class="modal-header ">
                <h5 class="modal-title">{{title}}</h5>
                <button type="button" @click="dest" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body ">
                <div v-if="productmodal == ''" class="fa-3x text-center"><i class="fas fa-circle-notch fa-spin"></i></div>
                <div v-else class="row">
                <!-- <div  class="row"> -->
                    <div class="col-md-4">
                        <div class="row">
                             <div class="col-md-12">
                                <label for="Código" class="labelpe" ><i class="fas fa-barcode"></i> Código: </label>
                                <label   class="labelpe"> <b>{{productmodal.codigo}}  </b>  </label>
                                <!-- <input v-else type="text" v-model="productmodal.codigo" class="form-control" > -->
                             </div>
                            <!-- JBARCODE -->
                             <div class="col-md-12 ">
                                <div class="card card-body p-2">
                                    <div class="row ">
                                        <label for="Código" class="labelpe col-6">Listo para imprimir </label>
                                        <div class="col-6 form-group clearfix text-right mb-0 ">
                                            <div class="icheck-dark  d-inline">
                                                <input type="radio" id="radioPrimary4" 
                                                    :value="'#000000'"  v-model="viewrcolor" >
                                                <label for="radioPrimary4">
                                                </label>
                                            </div>
                                            <div class="icheck-primary d-inline ">
                                                <input type="radio" id="radioPrimary5"
                                                    :value="'#007bff'" v-model="viewrcolor">
                                                <label for="radioPrimary5">
                                                </label>
                                            </div>
                                            <div class="icheck-danger d-inline ">
                                                <input type="radio" id="radioPrimary6"
                                                    :value="'#dc3545'" v-model="viewrcolor">
                                                <label for="radioPrimary6">
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <img id="viewbarcode" class="viewbarcode mx-auto d-block"  
                                        data-width = "1"  data-background ="white"  /> 
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6 col-sm-6 col-6 form-group">
                                        <label class="labelpe" for="Cantidad">Ancho (mm)</label>
                                        <input type="number" class="form-control form-control-sm" min="1" v-model.number="viewancho">
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-6 form-group">
                                        <label class="labelpe" for="Cantidad">Alto (mm)</label>
                                        <input type="number" class="form-control form-control-sm" min="1" v-model.number="viewalto">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4  col-4 form-group">
                                        <label class="labelpe" for="Cantidad">Cantidad</label>
                                        <input type="number" class="form-control form-control-sm" min="1" v-model.number="viewcantidad">
                                    </div>
                                    <!-- <div class="col-md-5  col-4 form-group">
                                        <label class="labelpe" for="Cantidad">Formato</label>
                                         <select v-model="viewfcodebarra" class="form-control form-control-sm"  >
                                            <option :value="'CODE128'">CODE128</option> 
                                            <option :value="'EAN13'" :disabled="productmodal.codigo.length != '12'" >EAN13</option>
                                        </select>
                                    </div> -->
                                    <!-- IMPRIMIR -->
                                    <div class="col-md-3  col-4 form-group d-flex flex-column">
                                        <label for="" class="labelpe">Print</label>
                                        <button class="btn btn-warning btn-sm " @click="imprimir()"><i class="fas fa-print "></i></button>
                                    </div>
                                </div>
                            </div> 
                            <!-- END - JBARCODE -->
                         </div>
                    </div>
                   
                    <div class="col-md-8 ">
                        <div class="row">
                            <div class="col-md-4 ">
                                <label for="nombre" >Nombre Producto</label>
                                    <p  class="body-text">{{productmodal.name}}</p>
                                    <!-- <div class="form-group"> -->
                                    <!-- <input  v-else type="text" v-model="productmodal.name" class="form-control"> -->
                                    <!-- </div> -->
                            </div>
                            <div class="col-md-4 ">
                                <label for="nombre">Unidad de Medida</label>
                                <p class="body-text">{{productmodal.nameuni}}</p>
                            </div>
                            <div class="col-md-4 ">
                                <label for="nombre">Categoria</label>
                                <p class="body-text">{{productmodal.namecat}}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 ">
                                <label for="nombre" >Precio Venta(sin IGV)</label>
                                <p class="body-text">S/. {{productmodal.p_venta_sin}}</p>
                            </div>
                            <div class="col-md-4 ">
                                <label for="nombre">Precio Venta(in. IGV)</label>
                                <p class="body-text">S/. {{productmodal.p_venta_in}}</p>
                            </div>
                            <div class="col-md-4 ">
                                <label for="nombre">IGV</label>
                                <p class="body-text">18%</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 ">
                                <label for="nombre" >Stock Inicial </label>
                                <p class="body-text">{{productmodal.stock}} <small class="badge bg-primary"> {{productmodal.simbolo}}</small></p>
                            </div>
                            <div class="col-md-4 ">
                                <label for="nombre">Stock Minimo <small class="badge bg-primary"> {{productmodal.simbolo}}</small></label>
                                <p class="body-text">{{productmodal.stock_min}}</p>
                            </div>
                            <div class="col-md-4 ">
                                <label for="nombre">Stock Actual <small class="badge bg-primary"> {{productmodal.simbolo}}</small></label>
                                <p v-if="Number(productmodal.stock_actual) > Number(productmodal.stock_min)" class="body-text h5">
                                    <span class="badge bg-success">{{productmodal.stock_actual}}</span>
                                </p>
                                <p v-else class="body-text h5"><span class="badge bg-danger">{{productmodal.stock_actual}}</span></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 ">
                                <label for="cred" >Registrado el:</label>
                                <p class="body-text">{{productmodal.created_at}}</p>
                            </div>
                            <div class="col-md-4 ">
                                <label for="upd">Actualizado el:</label>
                                <p class="body-text">{{productmodal.updated_at}}</p>
                            </div>
                            <div class="col-md-4">
                                <label for="precioCompra">Precio Compra(in IGV)</label>
                                <p class="body-text "> S/ {{productmodal.p_compra}} </p>
                            </div>
                            
                        </div>
                        <div class="row">
                            <div class="col-md-4 ">
                                <img :src="path_img_product + productmodal.image" style="width: auto;height: 86px;" 
                                    class="elevation-1 img-bordered-sm img-fluid mb-3  mx-auto " alt="img"> <!-- d-block -->
                            </div>
                        </div>
                    </div>
                 </div>
            </div>
            <div class="modal-footer  ">
                <button type="button" class="btn btn-dark" data-dismiss="modal"  @click="dest">Cerrar</button>
            </div>
            </div>
        </div>
    </div>
</template>

<script>
import {mapState} from 'vuex'; 
export default {
    props : ['title','idproduc'],
    data(){
        return{
            productmodal : [],
            viewprevnewimg: 'default.jpg', 
            viewrcolor:'#000000',
            viewfcodebarra:'CODE128',
            viewcodebarra:'',
            viewcantidad:1,
            viewalto : 20,
            viewancho : 40,
             
        }
    },
    computed:{
        
        ...mapState(['path_img_product'])
    },
    watch:{
        
        viewrcolor: function(){
            this.jbarcode_show();
        },
        viewfcodebarra:function(){
            this.jbarcode_show();
        },
        
    },
    mounted(){
        
        console.log('Component ProductModal mounted') 
        // Obteniendo Solo un producto para la Vista Producto
        this.allproduct(this.idproduc); 
         
    },
    methods:{
        allproduct: async function (id){
            await axios.get(`products/product/${id}`)
            .then(res =>{
                this.productmodal = res.data
                console.log("PRODUCTP: ", res.data)
                // this.jbarcode_show();
            })
            this.jbarcode_show();
        },
        jbarcode_show : async function(){
            console.log((this.productmodal.codigo))
            await JsBarcode("#viewbarcode", this.productmodal.codigo,
                {format:this.viewfcodebarra,lineColor : this.viewrcolor,height: 65, width: 1});
        },
        imprimir(){ 
            window.open(`http://localhost/pos_pe/pdf/imcodeproduct/${this.productmodal.codigo}/${this.viewcantidad}/${this.viewrcolor.substring(1,7)}`, 'nuevo', 'directories=no, location=no, menubar=no, scrollbars=yes, statusbar=no, tittlebar=no, width=1024, height=716')
        },

        dest(){
            this.$emit('delCom',false);
        }
    },
    destroyed(){
        console.log('COMPONENT DELETY PRoduct MOdal')
    }
    
}
 
</script>

<style>

</style>