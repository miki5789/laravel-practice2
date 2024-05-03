<template>
  <div class="container mt-3">
    <div class="row">
      <div>
        <h1>ご注文内容確認</h1>
        <hr> <!-- 区切り線 -->
      </div>
      <div v-if="cart.length">
        <div v-for="(item, index) in cart" :key="index">
          <div class="row align-items-center mb-3"> <!-- 各アイテムを囲む行 -->
            <div class="col-md-6">
              <img :src="(item) ? item.productDetails.product_image_master[0].image_path1 : '/images/default.png'" alt="product_image" class="img-fluid">
            </div>
            <div class="col-md-6">
              <p> {{ item.productDetails.product_master.product_name }}&nbsp;&nbsp;{{ item.productDetails.color }}&nbsp;</p>
              <p>¥{{ formatPrice(item.productDetails.price) }} </p>

              <!-- プルダウンメニュー -->
              <div class="d-flex align-items-center">
                <span>数量：{{ item.selectedQuantity }}</span>
              </div>
            </div>
          </div>
          <hr> <!-- 区切り線 -->
        </div>
      </div>

      <div class="row justify-content-end">
          <div v-if="cart.length" class="col-md-4 text-right">
            <h4>小計: ¥{{ formatPrice(subtotal) }}</h4>
          </div>
      </div>

      <div class="d-flex justify-content-end mt-3">
        <button class="btn btn-primary" @click="goToCart">修正</button>
        <button class="btn btn-primary" @click="purchase">購入</button>
      </div>
    </div>
  </div>
</template>


<script>
export default {
  data() {
    return {
      cart: [],
      cartItem: null,
    };
  },
  computed: {
    subtotal() {
      return this.cart.reduce((acc, item) => acc + item.productDetails.price * item.selectedQuantity, 0);
    }
  },
  mounted() {
    this.loadCart();
  },
  methods: {
    loadCart() { //カート追加
      const cartData = sessionStorage.getItem('cart');
      //cartDataがあればjsonよみこみ
      this.cart = cartData ? JSON.parse(cartData) : [];
      console.log(cartData);
    // カートデータが配列でない場合は空の配列にリセット
      if (!Array.isArray(this.cart)) {
        this.cart = []; 
      }
    },
    formatPrice(value) {
      return Number(value).toLocaleString();
    },
    goToCart(){
      this.$router.push('/product/cart');
    },
    purchase(){
      // Vue.jsコンポーネント内
    axios.post('/api/product/order/confirm', {
      userData: JSON.parse(sessionStorage.getItem('userData')),
      cartData: this.cart
    })
    .then(response => {
        console.log("response:",response.data);
    })
    .catch(error => {
        console.error("error:",error);
    });
      //this.$router.push('/user/complete');
    }
  }
}
</script>


<style>

.img-fluid {
  max-height: 250px; /* 画像の最大高さを150pxに設定 */
  width: auto; /* 幅は自動調整 */
  display: block; /* 画像をブロック要素として表示 */
  margin: 0 auto; /* 左右のマージンを自動で設定し、画像を中央に配置 */
}

/* 以下のスタイルはオプショナルで、各商品のコンテナの高さを統一し、整ったレイアウトにします */

.img-button:hover {
  transform: scale(1.05); /* ホバー時に画像を少し大きくする */
}

.col-md-6 {
  display: flex;
  flex-direction: column;
  justify-content: space-between; /* 内容を均等に分布させる */
}


</style>