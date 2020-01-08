<template>
  <div class="card-body table-responsive">
        <table id="" class="table dt-responsive   table-hover " style="width:100%" >
            <thead>
                <tr>
                    <th style="width:25px">#</th>
                    <th >Código</th>
                    <th style="width:55px">Imagen</th>
                    <th style="width:200px">Descripción</th>
                    <th>Categoría</th>
                    <th >Stock</th>
                    <th >Estado</th>
                    <th >Unidad</th> 
                    <th>P. Venta</th>
                    <!-- <th>Agregado</th> -->
                    <th style="width: 50px">Acciones</th>
                </tr>
            </thead>

            <tbody>
                <!--  :class="[(Number(product.stock_actual) > Number(product.stock_min))? '':'table-danger' ]"  -->
                <tr v-for="(product, index) in filterProducts" :key="product.id">
                    <td>{{index + 1}}</td>
                    <td>{{product.codigo }}</td>
                    <td>
                        <div class=" ">
                            <img :src="path_img_product + product.image"  alt="" width="50px" class="elevation-1 img-bordered-sm img-fluid ">
                        </div>
                    </td> 
                    <td>  {{product.name}} </td>
                    <td>{{product.namecat}}</td>
                    <td > 
                        <button v-if="Number(product.stock_actual) > Number(product.stock_min)" class="btn btn-success btn-sm" :data-descr="['Minimo: ' + product.stock_min]"
                                @click="idproduc = product.id , indexidpro = index,showupdatestock = true" data-toggle="modal" data-target="#modal-update" > 
                            {{product.stock_actual}} 
                        </button> 
                        <button v-else class="btn btn-danger btn-sm"  :data-descr="['Minimo: ' + product.stock_min]"
                                @click="idproduc = product.id , indexidpro = index,showupdatestock = true"  data-toggle="modal" data-target="#modal-update"  > 
                            {{product.stock_actual}} 
                        </button> 
                    </td>
                    <td>
                        <button class="btn btn-xs" :class="[Number(product.estado)==1? 'bg-success':'bg-danger']" @click="changeStateProduct(product.estado,product.id,index)" >
                            {{Number(product.estado)==1? 'Activo' : 'Desactivado'}}
                        </button>
                    </td>
                    <td><p class="badge  badge-dark">{{product.simbolo}}</p></td>
                    <!-- <td>{{product.p_compra}}</td> -->
                    <td>S/. {{product.p_venta_in}}</td>
                    <!-- <td>{{product.created_at.split(' ')[0]}}</td> -->
                    <td>
                        <div class="btn-group">
                            <!-- EDIT -->
                            <button class="btn btn-warning btn-sm" >
                                <i class="fas fa-pencil-alt text-white" ></i>
                            </button> 
                            <!-- SHOW MODAL -->
                            <button class="btn btn-primary btn-sm" data-toggle="modal"
                                    @click="showmodalprod = !showmodalprod, indexidpro = index, idproduc = product.id "  data-target="#modalProduct" > 
                                <i class="fa fa-eye"></i>
                            </button> 
                            <!-- DELETE -->
                            <button class="btn btn-danger btn-sm" @click="deleteproduct(index,product.id, product.image)" > 
                                <i class="fa fa-times"></i>
                            </button> 
                        </div>
                    </td>
                </tr>

            </tbody>
             
        </table>
        <!-- MODAL UPDATE STOCK -->
        <update-stock v-if="showupdatestock"
            :indexidpro="indexidpro" :getproductUpd="getproductUpd" 
            :idproduc="idproduc" 
             @cerrarmup="showupdatestock = $event" >
        </update-stock>
      
        <!--VENTANA MODAL -->
        <show-modal-products v-if="showmodalprod"  :productmodal="products[indexidpro]" :idproduc="idproduc" 
         @delCom="showmodalprod = $event"
            title="Vista del Producto" 
        ></show-modal-products>
    </div> 
</template>

<script>
import {mapState,mapActions,mapMutations} from 'vuex'; 
export default {
    props :['buscar'],
    data(){
        return{
           idproduc : '',
           indexidpro:'',
           showprotable: true,
           updatestock:'',
           codig:'',
           showmodalprod :false,
           showupdatestock : false,
        }
    },
    computed:{
        ...mapState(['path_img_product','products']),
        filterProducts(){
            if(this.buscar){
                let fproduct = new RegExp(this.buscar,'i');
                return this.products.filter(({name,codigo}) => fproduct.test([name,codigo]) )
                // console.log("iDEX: ",this.indexidpro, 'IDPRO:',this.idproduc)
                 
                // return this.products.filter(product =>{
                //     return  product.name.toLowerCase().includes(this.buscar.toLowerCase()) || 
                //             product.codigo.toLowerCase().includes(this.buscar.toLowerCase())
                // })
            }else{
                return this.products
            }
        }
    },
    mounted(){
        console.log('Component Table Mounted')
         //Obteniendo Todos los productos
        this.obtenerproductos();
        
    }, 
    methods:{
        ...mapActions(['obtenerproductos']),
        // allproducts(){
        //     axios.get('products/allproducts')
        //     .then(res => { 
        //         this.products = res.data
        //     })
        // },
        deleteproduct(index,id,img){ 
             
            Swal.fire({
            title: '¿Esta seguro de borrar el producto ?',
            text: "¡Si no lo está puede cancelar la accion!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Si, borrar producto!'
            })
            .then((result) => {
                if (result.value) { 
                    axios.post('products/deleteproduct',{ id : id, image: img})
                    .then(res => { 
                        if(res.data == 'ok'){
                            Swal.fire(
                                'Eliminado!',
                                `Se cambiado de estado del Producto Correctamente id: ${id}`,
                                'success'
                            )
                            this.products.splice(index,1)
                            console.log('DEL ID',res.data)
                        }else{
                            console.log("Error! ",res.data)
                        }
                    })
                }
            })

            
        }, 
     
        
        getproductUpd(id,indexprod){
            axios.get(`products/product/${id}`)
            .then(res =>{
                // console.log(res.data)
                this.products[indexprod].codigo = res.data.codigo;
                this.products[indexprod].image = res.data.image;
                this.products[indexprod].name = res.data.name;
                this.products[indexprod].categoria_id = res.data.categoria_id;
                this.products[indexprod].stock_actual = res.data.stock_actual;
                this.products[indexprod].stock = res.data.stock;
                this.products[indexprod].stock_min = res.data.stock_min;
                this.products[indexprod].estado = res.data.estado;
                this.products[indexprod].p_compra = res.data.p_compra;
                this.products[indexprod].p_venta = res.data.p_venta;
                // this.products[indexprod].updated_at = res.data.updated_at;
                this.products[indexprod].created_at = res.data.created_at;
            })
        },
        changeStateProduct(state,id,index){
            // console.log("DATA" , Number(!Number(state)) , id, index)
            axios.post('products/changeState',{
                state : Number(!Number(state)) , id : id
            }).then(res => {
                console.log("re", res.data)
                if(res.data == 'ok'){
                    this.products[index].estado =Number(!Number(state)) 
                }else{
                    console.log('error al actualizar Stado')
                }
            })
        }
    }
}
  
</script>

<style>
button[data-descr] {
  position: relative;
}
button[data-descr]:hover::after
/* button[data-descr]:focus::after  */
{
    content:attr(data-descr);
    position: absolute;
    color: white;
    width: 80px;
    background: #1f1f1f;
    padding: 3px 6px;
    border-radius: 6px;
    font-size: 12px;
    margin-top :8px;
 }
</style>