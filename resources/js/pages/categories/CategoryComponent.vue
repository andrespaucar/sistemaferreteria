<template>
  <div class="content-wrapper">
    <content-header
    nameContent="Categorias"
    nameMain = "Home"
    nameAct = "Categories"
    >
    </content-header>

    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <button class="btn btn-sm" :class="[showaddcategory? 'btn-danger':'btn-dark']" 
                                @click="showaddcategory = !showaddcategory" >
                                {{showaddcategory? 'Cancelar': 'Agregar'}}
                            </button>
                        </div>

                        <div class="card-tools">
                            <div class="input-group input-group" style="width: 190px;">
                                <input type="text" name="table_search" v-model="buscandocategory"
                                    class="form-control float-right" placeholder="Buscar">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                     
                     <table-categories 
                     :buscandocategory="buscandocategory" 
                     :showaddcategory ="showaddcategory"
                     ></table-categories>

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
            buscandocategory: '',
            showaddcategory : false
        }
    }
}
</script>

<style>

</style>