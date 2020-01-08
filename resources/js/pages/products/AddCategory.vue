<template> 
   <div class="modal fade"   id="modal-addcategory"  data-backdrop="static">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Agregar Categoria </h4>
                    <button type="button" class="close" @click="cerraraddcat()"  data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="Actualizar" class="labelpe">Ingrese Nueva Categoria </label>
                        <input type="text"  v-model="addcategory_m"
                            class="form-control ">
                    </div>
                    
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-dark" @click="cerraraddcat()" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" 
                        @click="addcategoryp()"  :disabled="addcategory_m.length == 0" data-dismiss="modal" >Guardar Cambios</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {mapActions} from 'vuex'
export default {
    props : ['showaddcategory'],
    data(){
        return{
            addcategory_m : '',
            showcategory : '',
        }   
    },
    methods:{
        ...mapActions(['obtenercategorias']),
        addcategoryp(){
            if(this.addcategory_m=='') return toastr.error('Dato requerido');
            axios.post('categories/addcategory',{newname :this.addcategory_m})
            .then(res =>{
                if(res.data == 'ok'){
                    toastr.success('Categoria agregado correctamente')
                    this.addcategory_m = '';
                    this.obtenercategorias();
                }else{
                    toastr.error('Error al agregar categoria')
                }
                console.log('res ', res.data)
            })
        },
        cerraraddcat(){
            this.$emit('showcategory',false);
        }
    }
}
</script>

<style>

</style>