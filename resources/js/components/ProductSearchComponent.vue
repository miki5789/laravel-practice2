<template>
  <div class="container mt-3">
    <div class="row">
      <!-- 検索結果を表示 -->
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
  
  export default {
  data() {
    return {
      searchResults: [],
      searchKeyword: '', // 検索バーで使用するキーワード
      currentPage: 1, // 現在のページ番号
      itemsPerPage: 8 // 1ページあたりのアイテム数
    };
  },
  created() {
    this.loadSearchResults();
  },
  watch: {
    // クエリパラメータが変更されたときに再度検索を実行
    '$route.query.keywords': function () {
      this.loadSearchResults();
    }
  },
  computed: {
    paginatedProducts() {
      // ページ番号に基づいて表示する商品の範囲を計算
      const start = (this.currentPage - 1) * this.itemsPerPage;
      const end = start + this.itemsPerPage;
      return this.searchResults.slice(start, end);
    },
    totalPages() {
      return Math.ceil(this.searchResults.length / this.itemsPerPage);
    }
    },
  methods: {
    // API リクエストで検索結果を取得
    async loadSearchResults() {
      const queryKeywords = this.$route.query.keywords;

      if (queryKeywords) {
        let keywords = [];

        // 配列であればそのまま利用し、文字列なら分割
        if (Array.isArray(queryKeywords)) {
          keywords = queryKeywords;
        } else if (typeof queryKeywords === 'string') {
          keywords = queryKeywords.split(',');
        }

        await this.fetchSearchResults(keywords);
      }
    },
    // API で検索結果を取得
    async fetchSearchResults(keywords) {
      const queryString = keywords.map(k => `keywords[]=${encodeURIComponent(k)}`).join('&');
      const response = await fetch(`/api/product/search?${queryString}`);
      if(response){
        const data = await response.json();
        console.log("検索結果:", data);

        // 結果を `searchResults` に設定
        this.searchResults = data;

        // クエリパラメータを更新
        this.$router.push({ name: 'product.search', query: { keywords: keywords.join(',') } });
      }
    },
    goToPage(pageNumber) {
        // ページ番号が範囲内であれば移動
        if (pageNumber >= 1 && pageNumber <= this.totalPages) {
          this.currentPage = pageNumber;
        }
    },
    // 価格をフォーマット
    formatPrice(value) {
      return Number(value).toLocaleString();
    }
  }
};

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