<template>
  <div class="modal fade"   id="modal-update"  data-backdrop="static">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Actualizar Stock #{{indexidpro + 1}}</h4>
                    <button type="button" class="close" @click="cerrarmu()"  data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="Actualizar" class="labelpe">N. Ingrese el Nuevo Stock </label>
                        <input type="number" min="1" maxlength="4" v-model.number="updatestock"
                            class="form-control ">
                    </div>
                    
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-dark" @click="cerrarmu()" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" 
                         @click="updateStockActual()"  :disabled="updatestock.length == 0" data-dismiss="modal" >Guardar Cambios</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props : ['indexidpro','idproduc','getproductUpd'],
    data(){
        return{
            updatestock:'',
            modal: false
        }
    },
    mounted(){
        console.log('Update Stock Mounted')
    },
    methods:{
        updateStockActual(){ console.log( this.updatestock)
            if(this.updatestock === ''){
                Toast.fire({ type: 'warning',  title: ' No puedes enviar campos vacíos' })
                return;
            }
            axios.post('products/updatestocksum',{
                id  : this.idproduc,
                stocksum : this.updatestock
            })
            .then(res =>{
            
                if(res.data == 'ok'){
                    this.modal = true
                    toastr.success('Stock Actualizado')
                    // this.products[this.indexidpro].stock_actual = this.updatestock;
                    // OTRO METHOD PARA SOLO ACTUALIZAR EL QUE CORRESPODE
                    // this.allproducts();
                    this.getproductUpd(this.idproduc,this.indexidpro);
                    this.updatestock = '';
                    
                    this.$emit('cerrarmup',false)
                }else{
                    toastr.error('Error al Actualizar')
                }
                
            })
        },
        cerrarmu(){
            this.$emit('cerrarmup',false)
        }
    }
}
</script>

<style>

</style>