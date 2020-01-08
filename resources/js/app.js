require('./bootstrap');
import Vue from 'vue'; // Esta version es para PAQUETES https://vuejs.org/v2/guide/installation.html
import Vuex from 'vuex';


Vue.use(Vuex);

// import VueRouter from 'vue-router/dist/vue-router.esm'
// Vue.use(VueRouter);



//COMPONENT
Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('content-header',require('./components/ContentHeader.vue').default);
// USERS
Vue.component('user-component',require('./pages/users/UsersComponent.vue').default);
// PRODUCTS
Vue.component('product-component',require('./pages/products/ProductComponent.vue').default);
Vue.component('table-products',require('./pages/products/TableProducts.vue').default);
Vue.component('add-products',require('./pages/products/AddProduct.vue').default);
Vue.component('show-modal-products',require('./pages/products/ProductModalComponent.vue').default);
Vue.component('update-stock',require('./pages/products/UpdateStock.vue').default);
// UPDATE productos SET stock = stock +5 
// CATEGORIES
Vue.component('category-component',require('./pages/categories/CategoryComponent.vue').default);
Vue.component('table-categories',require('./pages/categories/TableCategories.vue').default);
// SALE
Vue.component('sale-component',require('./pages/sale/SaleComponent.vue').default);
Vue.component('add-modal-listprod',require('./pages/sale/ModalSale.vue').default);
//SALE ALL
Vue.component('sale-all-component',require('./pages/sales_all/SaleAllComponent.vue').default);
Vue.component('table-saleall',require('./pages/sales_all/TableSaleAll.vue').default);
// SALE REPORT
Vue.component('sale-report-component',require('./pages/salereport/salereportComponent.vue').default);
Vue.component('product-report',require('./pages/salereport/productreport.vue').default);
Vue.component('sale-of-today',require('./pages/salereport/salesoftoday.vue').default);
Vue.component('client-report',require('./pages/salereport/clientreport.vue').default);

// Vue.component('product-modal-component',require('./pages/products/ProductModalComponent.vue').default);
// document.write('Escribiendo desde JS');
//Setting
Vue.component('setting-component',require('./pages/setting/SettingComponent.vue').default);
//Customers
Vue.component('customers-component', require('./pages/customers/CustomersComponent.vue').default);
Vue.component('table-customers', require('./pages/customers/TableCustomers.vue').default);
//LOGIN
Vue.component('login-cardpe', require('./pages/login/loginComponent.vue').default);

// Products
const store = new Vuex.Store({
    state : {
        count : 0,
        path_img_user:'public/uploads/users/',
        path_img_product:'public/uploads/products/',
        path_img: "public/images/",
        path_comprobante: "pdf/comprobante/",
        path_company : "public/uploads/company/",
        products: [],
        users : [], 
        categories:[],
        categoriesreal: [],
        customers : [],
        ubigeos : [], 
        listCompras: [],
        tipo_docs:[],
        sales :[],
    },
    mutations : { 
        allproductspe(state,cursosAccion){
            state.products = cursosAccion;
        }, 
        alluserspe(state,usersAccion){
            state.users = usersAccion;
        },
        allcategoriespe(state,categoryAccion){
            state.categories = categoryAccion;
        },
        allcategoriesreal(state,categoryRealAcction){
            state.categoriesreal = categoryRealAcction;
        },
        allcustomers(state,customerAction){
            state.customers = customerAction;
        },
        allubigeos(state, ubigeosAction){
            state.ubigeos = ubigeosAction;
        }, 
        alltipodocs(state,tipodocAcction){
            state.tipo_docs = tipodocAcction;
        },
        allsalesvouchers(state,ventasAcction){
            state.sales = ventasAcction;
        }
    },
    actions:{
        obtenerproductos : async function({commit}){
            // const data = await fetch('products/allproducts');
            // const productos = await data.json();
            const res = await axios.get('products/allproducts');
            const productos = await res.data;
            commit('allproductspe',productos)
        },
        obtenerusuarios :async function({commit}){
            const res = await axios.get('users/showUsers');
            const usuarios = await res.data;
            commit('alluserspe',usuarios)
        },
        // Categorias------------------------//
        obtenercategorias : async function({commit}){ 
            const res = await axios.get('categories/all'); 
            const categorias = await res.data; 
            commit('allcategoriespe',categorias)
        },
        obtenercategorialreal : async function({commit}){
            const res = await axios.get('categories/allreal');
            const categoriasrealp = await res.data; 
            commit('allcategoriesreal',categoriasrealp)
        },
        //-----------------------------------//
        obtenerclientes: async function({commit}){
            const res = await axios.get('customers/all');
            const clientes = await res.data;
            commit('allcustomers',clientes);
        },
        obtenerUbigeo : async function({commit}){
            const res = await axios.get('apisunat/allubigeosunat');
            const ubigeosp = await res.data;
            commit('allubigeos',ubigeosp);
        },
        obtenerTipoDocs : async function({commit}){
            const res = await axios.post('apisunat/tipodocitentidad');
            const tipodocument = await res.data;
            commit('alltipodocs', tipodocument);
        },
        obtenerVentas: async function({commit}){
            const res = await axios.get('saleall/allsalesvouchers');
            const ventas = await res.data; 
            commit('allsalesvouchers',ventas)
        }
        
    }
})
 
 
const app = new Vue({
    el: '#app',
    store,
    // store
    // router,
});



