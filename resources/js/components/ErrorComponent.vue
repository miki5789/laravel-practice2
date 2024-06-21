
<template>
  <div>
    <h1 v-if="errorData">{{errorData.data.status_code}}:{{errorData.data.message }}</h1>
    <p v-if="errorData">エラーID: {{ errorData.data.error_id}}</p>
  </div>
</template>

<script>
import { computed } from 'vue';
import { useStore } from 'vuex';

export default {
  name: 'ErrorComponent',
  setup() {
    const store = useStore();
    const errorData = computed(() => store.state.errorData);

    return {
      errorData
    };
  },
  beforeRouteLeave(to, from, next) {
    // エラーデータをクリア
    this.$store.commit('clearErrorData');
    next();
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

  /* 以下のスタイルはオプショナルで、各商品のコンテナの高さを統一 */
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

