<template>
  <div class="card-body">
       <!-- CODIGO DE BARRA Y IMG CODIGO DE BARRAS-->
        <div class="row">
            <div class=" col-md-4">
                <div class="row ">
                    <div class="col-md-12">
                        <label for="Código" class="labelpe" ><i class="fas fa-barcode"></i> Código Max:13 | {{codebarra.length}}</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" maxlength="13" v-model="codebarra" :readonly="fcodebarra == 'EAN13'" placeholder="Código">
                            <div class="input-group-append">
                                <button class="btn bg-dark " @click="generarcode" ><i class="fas fa-redo fa-flip-horizontal"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 ">
                        <!-- JBARCODE -->
                        <div class="card ">
                                <div class="card-body p-2">
                                    <div class="row">
                                        <label for="Código" class="labelpe col-6">Listo para imprimir </label>
                                        <div class="col-6 form-group clearfix text-right mb-0 ">
                                            <div class="icheck-dark  d-inline">
                                                <input type="radio" id="radioPrimary1" :disabled="codebarra == ''"
                                                    :value="'#000000'"  v-model="rcolor" >
                                                <label for="radioPrimary1">
                                                </label>
                                            </div>
                                            <div class="icheck-primary d-inline ">
                                                <input type="radio" id="radioPrimary2"  :disabled="codebarra == ''" 
                                                    :value="'#007bff'" v-model="rcolor">
                                                <label for="radioPrimary2">
                                                </label>
                                            </div>
                                            <div class="icheck-danger d-inline ">
                                                <input type="radio" id="radioPrimary3"  :disabled="codebarra == ''" 
                                                    :value="'#dc3545'" v-model="rcolor">
                                                <label for="radioPrimary3">
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                  
                                    <img id="barcode" class="barco mx-auto d-block" 
                                        data-width = "2"  data-background ="white" 
                                        />
                                    <!-- <svg id="barcode" class="barco mx-auto d-block" ></svg> -->

                                    
                                </div>
                        </div>
                        
                    </div>
                    <div class="col-md-12 ">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label class="labelpe" for="Ancho">Ancho (mm)</label>
                                <input type="number" class="form-control form-control-sm" min="1">
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="labelpe" for="Alto">Alto (mm)</label>
                                <input type="number" class="form-control form-control-sm" min="1" >
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label class="labelpe" for="Cantidad">N. Cantidad</label>
                                <input type="number" min="1" value="1" v-model.number="cantidad" class="form-control form-control-sm"  >
                            </div>
                           <!-- <div class="col-md-6 form-group">
                                <label class="labelpe" for="Cantidad">Formato</label>
                                <select v-model="fcodebarra" class="form-control form-control-sm ">
                                    <option :value="'CODE128'">CODE128</option>
                                    <option :value="'UPC'" :disabled="codebarra.length != '11'" >UPC</option>
                                     <option :value="'EAN13'" :disabled="codebarra.length != '13'" >EAN13</option>
                                </select>
                                
                            </div> -->
                            <div class="col-md-3 form-group d-flex flex-column">
                                <label class="labelpe" for="Print">Print</label>
                                <button class="btn btn-warning btn-sm" @click="imprimircode"><i class="fas fa-print "></i></button>
                            </div>
                        </div>

                                
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="row">
                    <!-- NOMBRE DE PRODUCTO O SERVICIO -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="Codigo" class="labelpe"><i class="fab fa-product-hunt"></i> Nombre del Producto o Servicio</label>
                            <input type="text" class="form-control" v-model="nameproduct" placeholder="Nombre del Producto o Servicio">
                        </div>
                    
                    </div>
                    
                    <!-- CATEGORIAS -->
                    <div class="col-md-6">
                        <label for="Categoría" class="labelpe" ><i class="fas fa-cubes"></i> Categoría</label>
                        <div class="input-group mb-3 ">
                            <select class="custom-select " v-model="category" style="width: 80%;">
                                <option disabled value="" >Seleccione una Categoría</option>
                                <option v-for="categ in categories" :key="categ.id" :value="categ.id" v-text="categ.name" ></option>
                               
                            </select>
                            <div class="input-group-prepend ">
                                <button @click="showaddcategory = true"  class="btn bg-dark " data-toggle="modal" data-target="#modal-addcategory"><i class="fas fa-plus-circle"></i> </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- UNIDADES DE MEDIDA -->
                    <div class="col-md-4">
                        <label for="Código" class="labelpe"><i class="fas fa-layer-group"></i> Unidades de Medida</label>
                        <div class="input-group mb-3">
                            <select class="custom-select" v-model="unity"  >
                                    <option  disabled value="" >Seleccione una Opción</option>
                                    <option v-for="uni in units" :key="uni.id" :value="uni.id" v-text="uni.name"></option>
                                    
                            </select>
                        </div> 
                    </div>
                    <!-- IGB -->
                    <div class="col-md-2">
                        <label for="Código" class="labelpe" ><i class="fas fa-percentage"></i> IGV</label>
                        <div class="input-group mb-3">
                            <div class="input-group-append">
                                <span class="input-group-text  bg-disabled-gray ">IGV </span> 
                            </div>
                            <input type="text" class="form-control" name="igv" placeholder="18%" readonly >
                        </div>
                    </div>
                    <!-- Precio COMPRA -->
                    <div class="col-md-3">
                        <label for="Código" class="labelpe" ><i class="fas fa-money-bill"></i> PrecioVenta(sin IGV)</label>
                        <div class="input-group mb-3">
                            <div class="input-group-append">
                                <span class="input-group-text  bg-disabled-gray "> S/. </span> 
                            </div>
                            <input type="text" ref="pcompra" class="form-control" pattern="[0-9]+" @change="pre_sin_igv()"  v-model.number="precio_venta_sin" >
                        </div>
                    </div>
                    <!-- Precio de VENTA -->
                    <div class="col-md-3">
                        <label for="Código" class="labelpe"><i class="fas fa-money-bill"></i> PrecioVenta(in. IGV)</label>
                        <div class="input-group mb-3">
                            <div class="input-group-append">
                                <span class="input-group-text  bg-disabled-gray "> S/. </span> 
                            </div>
                            <input type="text" class="form-control" @change="pre_con_igv()" v-model.number="precio_venta_in" >
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Precio de COMPRA -->
                    <div class="col-md-3">
                        <label for="Código" class="labelpe"><i class="fas fa-money-bill"></i> PrecioCompra(in. IGV)</label>
                        <div class="input-group mb-3">
                            <div class="input-group-append">
                                <span class="input-group-text  bg-disabled-gray "> S/. </span> 
                            </div>
                            <input type="text" class="form-control" v-model.number="precio_compra" >
                        </div>
                    </div>
                    <!-- STOCK INICIAL -->
                    <div class="col-md-2 ">
                        <div class="form-group">
                        <label for="Stock Inicial" class="labelpe"  ><i class="far fa-bookmark fa-xs"></i> Stock Inicial</label>
                            <input type="number" v-model="stockinit" min="1" class="form-control" placeholder="0" >
                        </div>
                    </div>  
                    <!-- STOCK MINIMO -->  
                    <div class="col-md-2 ">
                        <div class="form-group">
                        <label for="StockMinimo" class="labelpe"  ><i class="far fa-bookmark fa-xs"></i> Stock Mínimo</label>
                            <input type="number" v-model="stockmin" min="1" class="form-control" placeholder="0" >
                        </div>
                    </div>

                    <!-- ESTADO PRODUCTO -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="Estado" class="labelpe"><i class="fas fa-fire"></i> Estado</label>
                            <select v-model="state" class="form-control">
                                <option disabled value="" >Selecione Estado</option>
                                <option :value="1" >Activo</option>
                                <option :value="0" >Inactivo</option>
                            </select>
                        </div>
                    </div>
                    
                </div>

                <div class="row">
                    <!-- CARGAR IMG -->
                    <div class="col-md-2">
                        <label for="CargarImg" class="labelpe" ><i class="far fa-image fa-md"></i> Cargar Imagen</label>
                        <div class="custom-fil mb-3" >
                            <label for="fileUpload" style="cursor: pointer;" class="file-upload btn btn-dark  btn-block  shadow-sm"> 
                                <i class="fas fa-upload"></i> <span class="labelpe">FOTO</span>  
                                <input  type="file"  ref="imagepro"  @change="imageproduct()" id="fileUpload" class="form-control-file"
                                accept="image/png, .jpg, .jpeg"  > 
                            </label>     
                        </div> 
                    </div>
                    <!-- VISTA PREVIA IMG -->
                    <div class="col-md-2">
                        <div class="" >
                            <img :src="prevnewimg"  alt="" style="width: auto;height: 86px;" 
                        class="elevation-1 img-bordered-sm img-fluid mb-3  mx-auto d-block">
                        </div>
                    </div>
                </div>   
                
                <div class="row">
                    <div class="col-md-12 d-flex justify-content-end">
                        <!-- <button type="button" class="btn btn-secondary ml-2 " >Cerrar</button> -->
                        <button type="button" class="btn btn-success ml-2" @click="addproduct">Guardar</button>
                
                    </div>
                </div> 
            </div>
        </div>

        <add-category v-if="showaddcategory" @showcategory='showaddcategory = $event'
           
        
        > 
        </add-category>
  </div>
</template>

<script>
import {mapActions, mapState} from 'vuex';
export default {
    data(){
        return{
            codebarra: "",
            prevnewimg: 'public/uploads/products/default.jpg',
            rcolor:'#000000',
            fcodebarra:'CODE128',
            cantidad: 1,
            precio_venta_sin : '',
            precio_venta_in: '',
            igv : 0.18,
            nameproduct:'',
            category: '',
            unity : '', 
            units :'',// All Unidades de Medida
            stockinit :'',
            stockmin :'',
            state: '',
            precio_compra:'',
            showaddcategory : false
        }
    },
    mounted(){
        console.log('Component AddProduct Mounted');
        JsBarcode("#barcode").init();
        // Obentemos todos las Cateogrias
        this.obtenercategorias(); 
         // Obentemos las Unidades de Medida
        axios.get('products/allunitymed')
        .then(res => {
            this.units = res.data
        })
        
    },
    watch :{
        codebarra: function(){
            if(this.codebarra != ''){
                this.init_jbarcode(); 
            }
        },
        rcolor : function(){
            this.init_jbarcode();
        }, 
    },
    computed : {
        ...mapState(['categories'])
        
    },
    methods:{
        ...mapActions(['obtenercategorias']),
        pre_sin_igv(){
            if(this.precio_venta_sin != ''){
                console.log("PRECIO DE precio_venta_sin :", this.precio_venta_sin * 1.18)
                this.precio_venta_in =(this.precio_venta_sin * 1.18).toFixed(2) //x + x.18
            }else{
                this.precio_venta_in = '';
            }
        },
        pre_con_igv(){
            if(this.precio_venta_in != ''){
                console.log("PRECIO DE precio_venta_sin :", this.precio_venta_in * 1.18)
                this.precio_venta_sin =(this.precio_venta_in * 0.82).toFixed(2) // x - x.0.18
            }else{
                this.precio_venta_sin = '';
            }
        },
        imageproduct(){
            // console.log('CARGANDO IMG', this.$refs.imagepro.files[0])
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
        init_jbarcode(){
            JsBarcode("#barcode", this.codebarra,{format:this.fcodebarra,height:100 ,lineColor : this.rcolor});
        },
        generarcode(){
            this.codebarra = Math.floor(Math.random() * 9999999999999);
        },
        imprimircode(){
           
            let url = document.getElementById('barcode');
            window.open(`http://localhost/pos_pe/pdf/imcodeproduct/${this.codebarra}/${this.cantidad}/${this.rcolor.substring(1,7)}`, 'nuevo', 'directories=no, location=no, menubar=no, scrollbars=yes, statusbar=no, tittlebar=no, width=1024, height=716')
        },
        addproduct(){
            
            let formd = new FormData();
            formd.append('nameproduct',this.nameproduct);
            formd.append('codebarra',this.codebarra);
            formd.append('category',this.category);
            formd.append('unity',this.unity);
            formd.append('precio_venta_sin',this.precio_venta_sin);
            formd.append('precio_venta_in',this.precio_venta_in);
            formd.append('precio_compra',this.precio_compra);
            formd.append('state',this.state);
            formd.append('stockinit',this.stockinit);
            formd.append('stockmin',this.stockmin);
            formd.append('image',this.$refs.imagepro.files[0]);
            // formd.forEach((xd)=>{
            //     if(xd == ''){ Toast.fire({ type: 'error',title: 'Completar los campos'}); return;} 
            // })
            axios.post('products/addproduct',formd,{headers: {'Content-Type': 'multipart/form-data' }})
            .then(res => {
                console.log('RESPUESTAPE', res)
                if(res.data == 'ok'){
                    Toast.fire({
                    type: 'success',
                    title: 'Registrado Correctamente'
                    })
                    this.limpiar()
                }else{ 
                    Toast.fire({
                    type: 'error',
                    title: 'Error al Registrar'
                    })
                }
            })
        },
        limpiar(){
            this.nameproduct = '',
            this.codebarra = '',
            this.category = '',
            this.unity = '',
            this.precio_venta_sin = '',
            this.precio_venta_in = '',
            this.stockinit = '',
            this.stockmin = '',
            this.prevnewimg = 'public/uploads/products/default.jpg',
            this.$refs.imagepro.value = ''
        }

    }
   
    
}
</script>

<style>

</style>