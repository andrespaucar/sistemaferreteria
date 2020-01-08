<template>
    <div class="card ">
        <div class="card-body p-2">
            <div class="row">
                <label for="Código" class="labelpe col-6">Listo para imprimir </label>
                <div class="col-6 form-group clearfix text-right mb-0 ">
                    <div class="icheck-dark  d-inline">
                        <input type="radio" id="radioPrimary1" :disabled="codebarra == ''"
                            :value="'black'"  v-model="rcolor" >
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
                data-width = "2"  data-background ="white"  />
            
        </div>
    </div>
</template>

<script>
export default {
    props : ['codebarra','rcolor'], 
    data(){
        return {

        }
    },
    mounted(){
        console.log('Component Jbarcode Mounted')
    }

}
</script>

<style>

</style>