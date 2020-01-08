<template>
   <div class="card-body table-responsive">
        <table id="" class="table dt-responsive   table-hover " style="width:100%" > 
        <thead>
            <tr>
                
                <th width="20px">ID</th>
                <th width="120px">Fecha</th>
                <th>Comprobante</th>
                <th>Cliente</th>
                <th>Total</th>
                <th>PDF</th>
                <th>Ticket</th>
                <!-- <th>XML</th>
                <th>CDR</th>
                <th>Sunat</th> -->
                <!-- <th>Acciones</th> -->
                
            </tr>
        </thead>
        <tbody>
            <tr v-for="(sale, index) in sales" :key="sale.id">
                <td>{{index + 1}}</td>
                <td>{{ sale.created_at }}</td>
                <td>{{sale.name}} <br> {{sale.serie}} - {{sale.numero}}</td>
                <td> {{sale.doc}} <br>
                     <p class="text-uppercase" style="margin-bottom: 0;font-size:14px">{{sale.razon_social}}</p> 
                </td>
                <td>S/. {{sale.total}}</td>
                <!-- <td>{{sale.pdf}}</td> -->
                <td> <a :href="[path_comprobante] + `${sale.serie}/${sale.numero}/a4`" target="_blank" >
                    <img :src="[path_img] + 'pdf.svg' " class='img-fluid' width='30px'>
                    </a> 
                </td>
                <!-- <td>{{sale.ticket}}</td> -->
                <td> <a :href="[path_comprobante] + `${sale.serie}/${sale.numero}/ticket`" target="_blank" >
                    <img :src="[path_img] + 'ticket.svg' " class='img-fluid' width='30px'>
                    </a> 
                </td>
                <!-- <td>{{sale.xml}}</td>
                <td>{{sale.cdr}}</td>
                <td>{{sale.sunat}}</td> -->
                <!-- <td>Eliminar EDITAR </td> -->

            </tr>
        </tbody>
        
        </table>

   </div>
</template>

<script>
import {mapActions,mapState} from 'vuex';
export default {
    data(){
        return{
             
        }
    },
    mounted(){
        console.log("Component SalesAll Mounted");
        this.obtenerVentas();
    },
    computed:{
        ...mapState(['sales','path_img','path_comprobante'])
    },
    methods:{
         ...mapActions(['obtenerVentas'])
    }
}
</script>

<style>

</style>