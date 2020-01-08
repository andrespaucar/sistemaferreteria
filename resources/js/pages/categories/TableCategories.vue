<template>
    <div class="card-body table-responsive">
        <div v-if="showaddcategory" class="row">
            <div class="form-group col-md-2">
                <input type="text" v-model="newCategory" placeholder="Nombre Categoria" class="form-control form-control-sm" >
            </div>
            <div class="form-group col-md-2">
                <input type="text" v-model="newDescript" placeholder="Descripción" class="form-control form-control-sm" >
            </div>
            <div class="form-group col-md-1">
                <button class="btn btn-primary btn-sm" @click="add">Agregar</button>
            </div>
        </div>
        <table class="table dt-responsive table-hover" style="width:100%" >
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Estado</th>
                    <th>Creado el</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(category, index) in filtercategories" :key="category.id">
                    <td>{{index +1 }}</td>
                    <td>
                        <input v-if="editarcategoria & idAct == index" type="text"    v-model="category.name" class="form-control w-75">
                        <p  v-else >{{category.name}}</p> 
                    </td>
                    <td>
                         <input v-if="editarcategoria & idAct == index" type="text"    v-model="category.description" class="form-control w-75">
                        <p v-else v-text="category.description"></p>
                    </td>
                    <td>
                        <button class="btn btn-xs" @click="changeState(category.id, category.state, index)" :class="(category.state==1)? 'btn-success':'btn-danger'">
                            {{(Boolean(Number(category.state)))? 'Activo':'Desactivado'}}
                        </button>
                    </td>
                    <td>
                        {{category.created_at}}
                    </td>
                    <td>
                        <div class="btn-group">
                            <!-- EDIT AND DELETE -->
                            <template v-if="editarcategoria & idAct == index">
                               <button @click="save(category.name, category.description ,category.id,index)" class="btn btn-success btn-sm">
                                    Guardar
                                </button>
                                <button @click="cancelar()" class="btn btn-dark btn-sm">
                                    Cancelar
                                </button>
                            </template>
                            <template v-else>
                                
                                 <button @click="edit(index)" class="btn btn-warning btn-sm">
                                    <i class="fas fa-pencil-alt text-white"></i>
                                </button> 
                                <button @click="deletecategory(index, category.id)"  class="btn btn-danger btn-sm">
                                    <i class="fa fa-times"></i>
                                </button>
                            </template>
                            
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import {mapState ,mapActions} from 'vuex'
export default {
    props: ['buscandocategory','showaddcategory'],
    data(){
        return{
            showdef : true,
            editarcategoria : false,
            idAct :'',
            newCategory : '',
            newDescript : '',
        }
    },
    mounted(){
        console.log('Component Table Mounted')
        // Obteniendo los productos
        
        this.obtenercategorialreal()
    },
    
    computed:{
        ...mapState(['categoriesreal']),
        filtercategories(){
            if(this.buscandocategory){
                return this.categoriesreal.filter(category =>{
                    return category.name.toLowerCase().includes(this.buscandocategory.toLowerCase())
                })
            }else{
                return this.categoriesreal
            }
        }
    },
    methods:{
        ...mapActions(['obtenercategorialreal']),
        deletecategory(index, id){
            Swal.fire({
            title: '¿Esta seguro de borrar la categoria ?',
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
                    axios.post('categories/deletecategory',{ id : id })
                    .then(res => {
                        if(res.data == 'ok'){
                            Swal.fire('Eliminado!','La categoria ha sido eliminado','success')
                            this.categoriesreal.splice(index,1)
                            console.log('DEL ID',res.data)
                        }else if(res.data =='cat_con_product'){
                                Swal.fire('Error!',
                                'No podemos eliminar la categoría, porque aún hay productos que utilizan esta categoría!',
                                'error')
                        }
                        else{
                            // error al eliminar     
                            console.log("Error! ",res.data)
                        }
                    })
                }
            }) 
        },
        edit(index){
            console.log(this.categoriesreal)
            this.idAct = index
            this.editarcategoria = true
        },
        save(nameCategoria,description, idCategoria,index){
            axios.post('categories/updatecategory',{
                name : nameCategoria, id:idCategoria,
                description : description
                })
            .then(res =>{
                if(res.data == 'ok'){
                    toastr.success('Categoria actualiado correctamente')
                }else{
                    console.log('RES_DELETECATEGORY', res.data)
                }
            })
            this.editarcategoria = false
        },
        cancelar(){
            // this.categories[index].name = ''
            this.editarcategoria = false;
        },
        add(){
            if(this.newCategory=='') return toastr.error('Dato requerido');
            axios.post('categories/addcategory',{newname :this.newCategory,newdescription: this.newDescript})
            .then(res =>{
                if(res.data == 'ok'){
                    toastr.success('Categoria agregado correctamente')
                    this.newCategory = '';
                    this.newDescript = '';
                    this.obtenercategorialreal();
                }else{
                    toastr.error('Error al agregar categoria')
                }
                console.log('res ', res.data)
            })
        },
        changeState(id,state,index){
            axios.post('categories/upstate',{id:id})
            .then(res =>{
                if(res.data == 'ok'){
                    this.categoriesreal[index].state = Boolean(!Number(state));
                }
                console.log('REST ', res.data)
            })
        }
    }
}
</script>

<style>

</style>