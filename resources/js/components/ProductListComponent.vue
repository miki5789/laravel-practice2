<template>

    <div class="container mt-3">
      <div class="row">

        <div v-for="(product, index) in paginatedProducts" :key="index" class="col-md-3 mb-4 product-item">
          <router-link :to="{name: 'product.detail', params: {product_master_id: product.product_master_id}}" class="product-link">
            <img :src="(product.product_image_master.length > 0 && product.product_image_master[0].image_path1) ? product.product_image_master[0].image_path1 : '/images/default.png'" alt="product_image" class="img-fluid product-image">
            <h5 class="text-truncate mt-2">{{ product.product_name }}</h5>
          </router-link>

          <!-- 価格情報の表示（オプション） -->
          <p>{{ product.product_detail_master.length > 0 && product.product_detail_master[0].price ? `¥${formatPrice(product.product_detail_master[0].price)}` : '-' }}</p>
        </div>
      </div>

          <!-- ページング -->
      <nav>
        <ul class="pagination justify-content-center mt-4">
          <li class="page-item" :class="{ disabled: currentPage === 1 }">
            <a class="page-link" @click.prevent="goToPage(currentPage - 1)" href="#">前</a>
          </li>
          <li class="page-item" v-for="page in totalPages" :key="page" :class="{ active: currentPage === page }">
            <a class="page-link" @click.prevent="goToPage(page)" href="#">{{ page }}</a>
          </li>
          <li class="page-item" :class="{ disabled: currentPage === totalPages }">
            <a class="page-link" @click.prevent="goToPage(currentPage + 1)" href="#">次</a>
          </li>
        </ul>
      </nav>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  export default {
    data() {
      return {
        products: [],
        currentPage: 1, // 現在のページ番号
        itemsPerPage: 8 // 1ページあたりのアイテム数
      }
    },
    computed: {
    paginatedProducts() {
      // ページ番号に基づいて表示する商品の範囲を計算
      const start = (this.currentPage - 1) * this.itemsPerPage;
      const end = start + this.itemsPerPage;
      return this.products.slice(start, end);
    },
    totalPages() {
      // 全商品数に基づいて総ページ数を計算
      return Math.ceil(this.products.length / this.itemsPerPage);
    }
    },
    methods: {
      async getProducts() {
        const res = await this.$http.get('/api/index');
        if(res) {
          this.products = res.data;
          //throw new Error('test');
          /*
          .then((res) => {
            this.products = res.data;
          
          }).catch((error) => {
            console.log('errorIn');
            console.log(error);
            throw error;
            //throwしないと例外はここで終わってしまう
            //throwするか、catchしてからthrowするか
          
          });
          */
        };
      },
      goToPage(pageNumber) {
        // ページ番号が範囲内であれば移動
        if (pageNumber >= 1 && pageNumber <= this.totalPages) {
          this.currentPage = pageNumber;
        }
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

  .product-item {
  display: flex;
  flex-direction: column;
  justify-content: flex-start; /* すべての要素を上部に揃える */
  align-items: center; /* 要素を中央に揃える */
  text-align: center; /* 商品名や価格も中央揃えにする */
  height: 100%; /* 商品アイテム全体の高さを統一するためのプロパティ */
  }

  .product-link {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-decoration: none; /* リンクから下線を削除 */
    color: inherit; /* テキストの色を継承 */
  }
  .product-image {
  max-width: 100%;
  height: auto;
  margin-bottom: 10px; /* 画像と商品名の間のスペース */
  }

  .pagination {
    list-style: none;
    padding: 0;
  }

  .page-item {
    display: inline;
    margin: 0 5px;
  }

  .page-link {
    cursor: pointer;
  }
  </style>