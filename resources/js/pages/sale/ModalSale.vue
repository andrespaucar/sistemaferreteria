<template>
  <div class="modal fade" id="modal-listproduct"  data-backdrop="static"  >
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content ">
            <div class="modal-header ">
                <h5 class="modal-title"> Listado de Productos </h5>
                <!-- <button type="button" @click="dest" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button> -->
                <div class="card-tools">
                  <div class="input-group " style="width: 210px;">
                    <input type="text" name="table_search" v-model="buscarpro" class="form-control float-right" placeholder="Buscar producto"> 
                    <div class="input-group-append">
                      <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                    </div>
                  </div>
                </div>
            </div>
            <div class="modal-body table-responsive p-0" style="height: 380px;">
                 <!-- <div class="row"> -->
                    <!-- <div class="col-12 table-responsive p-0" style="height: 300px;"> -->
                        <table class="table table-head-fixed  table-hover ">
                            <thead>
                                <tr>
                                    <th style="width: 20px;">#</th>
                                    <th>Codigo</th>
                                    <th style="width:160px;">Description</th>
                                    <th>Stock</th>
                                    <th style="width:120px">PrecioVenta</th>
                                    <th style="width:140px">Cantidad</th>
                                    <th>Accion</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(pro_sale, index) in filterProductsmod" :key="pro_sale.id">
                                    <td><p>{{index + 1}}</p> </td>
                                    <td style="width:35px"><p>{{pro_sale.codigo}}</p> </td>
                                    <td><p>{{pro_sale.name}}</p> </td>
                                    <td><p>{{pro_sale.stock_actual}} <span class="badge bg-danger">- {{pro_sale.cantidad}}</span> </p> </td>
                                    <td ><p>S/. {{pro_sale.p_venta_in}}</p> </td>
                                    <td ><div class="form-group">
                                            <div class="input-group mb-3 ">
                                                <div class="input-group-prepend">
                                                    <button class="btn btn-dark btn-xs px-2" @click="pro_sale.cantidad++ , updneto()"  ><i class="fas fa-plus"></i></button> 
                                                </div>
                                                <input type="number" class="form-control" min="1" max="999999" inputmode="numeric" v-model="pro_sale.cantidad">
                                                <div class="input-group-append">
                                                    <button class="btn btn-dark btn-xs px-2" @click="pro_sale.cantidad-- , updneto()" :disabled="pro_sale.cantidad==0" ><i class="fas fa-minus"></i></button> 
                                                </div>
                                            </div>
                                        </div>  
                                    </td>
                                    <td>
                                        <button class="btn btn-primary btn-sm" :disabled="pro_sale.enable === 0 || pro_sale.cantidad > pro_sale.stock || pro_sale.cantidad==0"
                                             @click="addlist(index)" >Agregar
                                        </button>
                                        
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    <!-- </div> -->
                 <!-- </div> -->
            </div>
            <div class="modal-footer  ">
                <button type="button" class="btn btn-dark" data-dismiss="modal"  @click="dest()">Cerrar</button>
            </div>
            </div>
        </div>
    </div>
</template>

<script>
import {mapState} from 'vuex'
export default {
    props:['updneto'],
    data(){
        return{
            listprod_sale :[],
            disablebtn: '',
            listdisable:'',
            indexdisable: '',
            cantidadmod: 1,
            buscarpro: ''
        }
    },
    mounted(){
        console.log('Modal SaleList mounted')
        this.allmodalp();
    },
    
    computed:{
        ...mapState(['listCompras']),
        filterProductsmod(){
            if(this.buscarpro){ 
                return this.listprod_sale.filter(pro_sale =>{  
                    return  pro_sale.name.toLowerCase().includes(this.buscarpro.toLowerCase()) || 
                            pro_sale.codigo.toLowerCase().includes(this.buscarpro.toLowerCase())
                })
            }else{
                return this.listprod_sale
            }
        }
    },
    methods:{
        allmodalp(){
            axios.get('sale/allproductslist')
            .then(res =>{
                // let newa = [];
                // for (let i = 0; i < res.data.length; i++) {
                //     newa[i] = res.data[i];
                // }
                console.log('data', res.data)
                this.listprod_sale = res.data; 
            })
        },
        addlist(index){
            console.log('DT', this.listprod_sale[index]) 
            this.listprod_sale[index].enable = 0;
            this.listCompras.push(this.listprod_sale[index])
            this.updneto();
        },
        dest(){

        }
    }
}
</script>

<style>

</style>