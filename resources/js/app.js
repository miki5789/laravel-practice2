/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import { createApp } from 'vue';
import { createRouter, createWebHistory } from 'vue-router';
import store from './store.js';
import HeaderComponent from "./components/HeaderComponent.vue";
import TaskListComponent from "./components/TaskListComponent.vue";
import TaskShowComponent from "./components/TaskShowComponent.vue";
import TaskCreateComponent from "./components/TaskCreateComponent.vue";
import TaskEditComponent from "./components/TaskEditComponent.vue";
import ProductListComponent from "./components/ProductListComponent.vue";
import ProductDetailComponent from "./components/ProductDetailComponent.vue";
import ProductCartComponent from "./components/ProductCartComponent.vue";
import UserInputComponent from "./components/UserInputComponent.vue";
import UserConfirmComponent from "./components/UserConfirmComponent.vue";
import ProductOrderConfirmComponent from "./components/ProductOrderConfirmComponent.vue";
import UserCompleteComponent from "./components/UserCompleteComponent.vue";
import ProductSearchComponent from "./components/ProductSearchComponent.vue";
import OrderCompleteEmailComponent from "./components/OrderCompleteEmailComponent.vue";
import ErrorComponent from "./components/ErrorComponent.vue";
import './bootstrap';
import http from '../../src/utils/axiosErrorHandler.js';


// Vue Routerの作成
const router = createRouter({
    history: createWebHistory(),
    routes: [
        
        {
            path: '/tasks',
            name: 'task.list',
            component: TaskListComponent
        },
        {
            path: '/tasks/create',
            name: 'task.create',
            component: TaskCreateComponent
        },
        {
            path: '/tasks/:taskId',
            name: 'task.show',
            component: TaskShowComponent,
            props: true
        },
        {
            path: '/tasks/:taskId/edit',
            name: 'task.edit',
            component: TaskEditComponent,
            props: true
        },
        {
            path: '/index',
            name: 'product.index',
            component: ProductListComponent
        },
        {
            path: '/product/detail/:product_master_id',
            name: 'product.detail',
            component: ProductDetailComponent,
        },
        {
            path: '/product/cart',
            name: 'cart',
            component: ProductCartComponent,
          },
          {
            path: '/user/input',
            name: 'prefectures.show',
            component: UserInputComponent,
          },
          {
            path: '/user/confirm',
            component: UserConfirmComponent,
          },
          {
            path: '/api/product/check_inventory',
            name: 'product.inventory.check',
            component: ProductOrderConfirmComponent,
          },
          {
            path: '/product/order/confirm',
            name: 'order.confirm',
            component: ProductOrderConfirmComponent,
          },
          
          {
            path: '/user/complete',
            name: 'user.complete',
            component: UserCompleteComponent,
          },  
          {
            path: '/product/search',
            name: 'product.search',
            component: ProductSearchComponent,
            props: route => ({ queryString: route.query.queryString })
          },
          {
            path: '/email_template/order_complete',
            name: 'email.send',
            component: OrderCompleteEmailComponent,
          },

          {
            path: '/api/error',
            name: 'error.result',
            component: ErrorComponent,
          },                         
    ]
});


const app = createApp();



app.component('header-component', HeaderComponent);


app.config.globalProperties.$http = http;
app.use(router);
app.use(store);
app.mount('#app');
export default router;