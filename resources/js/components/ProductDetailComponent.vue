<template>

    <div class="container mt-3">
      

      <div class="row">
        <div v-for="(detail, index) in details" :key="index" class="col-md-3 mb-4">
          
            <button class="btn btn-primary">{{ detail.color }}</button>
          
        </div>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    props: {
      product_master_id: Number
    },
    data() {
      return {
        details: []
      }
    },
    methods: {
      getDetails() {
        // Vue Routerからパラメータを取得
        const productMasterId = this.$route.params.product_master_id;
        axios.get(`/api/detail/1`)
                .then((res) => {
                    this.details = res.data;
                    console.log(this.details);
                }).catch((e) => console.log(e));
      },
      // 価格をフォーマットするメソッドを追加
      formatPrice(value) {
        // toLocaleStringを使用して価格をフォーマット
        return Number(value).toLocaleString();
      }
    },
    mounted() {
      this.getDetails();
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