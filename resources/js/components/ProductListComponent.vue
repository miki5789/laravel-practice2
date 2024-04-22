<template>

    <div class="container mt-3">
      <div class="row">

        <div v-for="(product, index) in products" :key="index" class="col-md-3 mb-4">
          <p>Product ID Check: {{ product.product_detail_master.length > 0 ? product.product_detail_master[0].product_id : 'No Product ID' }}</p>
          <router-link :to="{name: 'product.detail', params: {product_master_id: product.product_master_id}}" class="product-link">
            <img :src="(product.product_image_master.length > 0 && product.product_image_master[0].image_path1) ? product.product_image_master[0].image_path1 : '/images/1_1.png'" alt="test" class="img-fluid">
            <h5 class="text-truncate mt-2">{{ product.product_name }}</h5>
          </router-link>

          <!-- 価格情報の表示（オプション） -->
          <p>{{ product.product_detail_master.length > 0 && product.product_detail_master[0].price ? `¥${formatPrice(product.product_detail_master[0].price)}` : '-' }}</p>
          <p>{{ product.product_detail_master.length > 0 && product.product_detail_master[0].product_id ? product.product_detail_master[0].product_id : 0 }}</p>
          <ChildComponent
            v-if="product.product_detail_master && product.product_detail_master.length > 0 && product.product_detail_master[0].product_id"
            :product_id="product.product_detail_master[0].product_id" 
          />
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
      },
      // 価格をフォーマットするメソッドを追加
      formatPrice(value) {
        // toLocaleStringを使用して価格をフォーマット
        return Number(value).toLocaleString();
      }
    },
    mounted() {
      this.getProducts();
    }
  }
  </script>
  
  <style>

  .img-fluid {
    max-height: 150px; /* 画像の最大高さを150pxに設定 */
    width: auto; /* 幅は自動調整 */
    display: block; /* 画像をブロック要素として表示 */
    margin: 0 auto; /* 左右のマージンを自動で設定し、画像を中央に配置 */
  }

  /* 以下のスタイルはオプショナルで、各商品のコンテナの高さを統一し、整ったレイアウトにします */
  .col-md-3 {
    display: flex;
    flex-direction: column;
    justify-content: space-between; /* 内容を均等に分布させる */
  }


  </style>