<template>
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Inicia sesión para comenzar...</p>
      
      <!-- <form > -->
        <div class="input-group mb-3">
          <input type="text" v-model="user" class="form-control " :class="[error? 'is-invalid':'']" placeholder="Usuario" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
          
        </div>
        <div class="input-group mb-3">
          <input type="password" v-model="pass" class="form-control" :class="[error? 'is-invalid':'']" placeholder="Contraseña" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
          
        </div>
        <div class="row">
          <div class="col-8">
            
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button @click="loginuser()" :disabled="btnname == ''" class="btn btn-primary btn-block btn-flat"> 
              <i v-show="snipper" class="fa fa-sync fa-spin"></i> {{btnname}}</button>
            
          </div>
          <!-- /.col -->
        </div>
      <!-- </form> -->
  
 
    </div>
    </div>
</template>

<script>
export default {
  data(){
    return{
      user : '',
      pass : '',
      snipper : false,
      btnname : 'Ingresar',
      error : false,
    }
  },
  methods:{
    loginuser(){
      this.btnname = '';
      this.snipper = true;
      axios.post('home/loginusuario',{
        user : this.user,
        pass : this.pass
      }).then(res =>{
        switch (res.data) {
          case 'administrador':
            this.error = false;
            window.location.href ='dashboard'
            break;
          case 'vendedor':
            this.error = false;
            window.location.href ='sale'
            break;
          case 'almacen':
            this.error = false;
            window.location.href ='products'
            break;
        
          default:
            this.error = true;
            break;
        }
        
        this.btnname = 'Ingresar';
        this.snipper = false;
        console.log(res.data)
      })
    }
  }
}
</script>

<style>

</style>