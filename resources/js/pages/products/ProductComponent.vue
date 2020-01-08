<template>
    <div class="content-wrapper">
         
        <content-header
            nameContent="Productos"
            nameMain = "Home"
            nameAct = "Products"
        ></content-header>

        <section class="content"> 
        
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                               
                                <!-- <button class="btn btn-primary btn-sm" @click="prueva" >probandope</button> -->
                                <button class="btn btn-sm" @click="showAddProduct" :class="[showadd? 'btn-danger' :'btn-dark']"  >{{showadd? 'Cerrar':'Agregar'}}</button>

                            </div>
                            <transition name="fade">
                                <div class="card-tools" v-if="!showadd">
                                    <div class="input-group input-group" style="width: 190px;">
                                        <input type="text" name="table_search" v-model="buscando"
                                            class="form-control float-right" placeholder="Buscar por Codigo o Nombre">
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </transition>
                        </div>
                       
                       
                        <transition name="fade">
                            
                            <add-products v-if="showadd"></add-products>
                        
                            <table-products v-else :buscar="buscando" ></table-products>

                        </transition>
                       
                    </div>
                </div>
            </div>
        </section>
      
    </div>
</template>

<script>


export default {
    
    data(){
        return{
        //    products :2,
           showadd : false,
           buscando :'',
        }
    },
    components: {
        
    }, 
    mounted(){
        console.log('Component ProductComponet Mounted')
    },

    methods:{
        showAddProduct(){
            this.showadd = !this.showadd;
        },
    }
}

</script>

<style>



.fade-enter-active, .fade-leave-active {
  transition: opacity .4s;
   
  
} 
.fade-enter, .fade-leave-to {
  opacity: 0;  
}
</style>