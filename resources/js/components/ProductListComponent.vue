<template>

    <div class="container mt-3">
      <div class="row">
        <div>
            <img class="card-img-top" :src="'/public/img/1_1.png'" alt="Product Image">
        </div>
        <div v-for="(product, index) in products" :key="index" class="col-md-3 mb-4">
          <div class="card h-100">
            <img class="card-img-top" :src="product.image_path1" alt="Product Image">
            <div class="card-body">
              <h5 class="card-title text-truncate">{{ product.product_name }}</h5>
              <p class="card-text text-truncate">{{ product.product_detail_master.length > 0 && product.product_detail_master[0].price ? product.product_detail_master[0].price : '-' }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        products: []
      }
    },
    methods: {
      getProducts() {
        axios.get('/api/index')
          .then((res) => {
            this.products = res.data;
          }).catch((e) => console.log(e));
      }
    },
    mounted() {
      this.getProducts();
    }
  }
  </script>
  
  <style>
  /* CSSクラスはVueファイル内に記述 */
  .card-title, .card-text {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }
  </style>
  