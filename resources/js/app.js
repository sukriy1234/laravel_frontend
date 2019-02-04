require('./bootstrap');

import Vue from 'vue'
import VueRouter from 'vue-router'
Vue.use(VueRouter)

import AutocompleteVue from 'autocomplete-vue';
import Datepicker from 'vuejs-datepicker';

Vue.component('autocomplete-vue', AutocompleteVue);
Vue.component('datepicker', Datepicker);

import Home    from './components/ExampleComponent.vue'

//PRODUCT
import Product from './components/ProductComponent.vue'
import ProductAdd from './components/ProductAddComponent.vue'
import ProductEdit from './components/ProductEditComponent.vue'

//ORDER
import Order   from './components/OrderComponent.vue'
import OrderAdd   from './components/OrderAddComponent.vue'
import OrderEdit   from './components/OrderEditComponent.vue'
import OrderEditFinance   from './components/OrderEditFinanceComponent.vue'
import OrderDetail   from './components/OrderDetailComponent.vue'
// import Order   from './components/AutoCompleteComponent.vue'

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home
        },
        {
            path: '/product',
            name: 'product',
            component: Product,
        },
        {
            path: '/product/add',
            name: 'productadd',
            component: ProductAdd,
        },
        {
            path: '/product/edit/:id',
            name: 'productedit',
            component: ProductEdit,
        },
        {
            path: '/order',
            name: 'order',
            component: Order,
        },
        {
            path: '/order/add',
            name: 'orderadd',
            component: OrderAdd,
        },
        {
            path: '/order/edit/:id',
            name: 'orderedit',
            component: OrderEdit,
        },
        {
            path: '/order/edit_finance/:id',
            name: 'OrderEditFinance',
            component: OrderEditFinance,
        },
        {
            path: '/order/detail/:id',
            name: 'OrderDetail',
            component: OrderDetail,
        },
    ],
});

const app = new Vue({
    el: '#app',
    router,
});
