/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import { createApp } from 'vue';
import { createRouter, createWebHistory } from 'vue-router';
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
import UserCompleteComponent from "./components/UserComplete.vue";
import './bootstrap';


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
            path: '/product/order/confirm',
            name: 'order.confirm',
            component: ProductOrderConfirmComponent,
          },
          {
            path: '/user/complete',
            name: 'user.complete',
            component: UserCompleteComponent,
          },          
    ]
});

const app = createApp();
app.use(router);
app.component('header-component', HeaderComponent);

app.mount('#app');
