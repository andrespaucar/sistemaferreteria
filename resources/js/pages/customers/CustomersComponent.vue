<template>
  <div class="content-wrapper">
        <content-header
        nameContent="Clientes"
        nameMain = "Home"
        nameAct = "Customers"
        ></content-header>

        <section class="content">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                <button class="btn btn-sm" :class="[showaddcustomer? 'btn-danger':'btn-dark']"
                                    @click="showaddcustomer = !showaddcustomer" >
                                   {{showaddcustomer? 'Cancelar':'Registrar'}}
                                </button>
                            </div>
                            <div class="card-tools">
                                <div class="input-group input-group" style="width: 190px;">
                                    <input type="text" name="table_search" v-model="buscandocustomer"
                                        class="form-control float-right" placeholder="Buscar Doc Cliente">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <table-customers 
                        :buscandocustomer = 'buscandocustomer'
                        :showaddcustomer = 'showaddcustomer'
                        >

                        </table-customers>
                        
                    </div>
                </div>
            </div>
        </section>


  </div>
</template>

<script>
export default {
    data(){
        return {
            showaddcustomer : '',
            buscandocustomer : '',
        }
    }
}
</script>

<style>

</style>