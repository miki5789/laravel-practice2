<template>
  <div class="container mt-3">
    <div class="row">
      <div>
        <h1>ショッピングカート</h1>
      </div>
      <div v-if="cart.length">
        <div v-for="(item, index) in cart" :key="index">
          <div class="row align-items-center mb-3"> <!-- 各アイテムを囲む行 -->
            <div class="col-md-6">
              <router-link :to="{name: 'product.detail', params: {product_master_id: item.productDetails.product_master_id}}" class="product-link">
                <img :src="(item) ? item.productDetails.product_image_master[0].image_path1 : '/images/default.png'" alt="product_image" class="img-fluid">
              </router-link>
            </div>
            <div class="col-md-6">
              <p> {{ item.productDetails.product_master.product_name }}&nbsp;&nbsp;{{ item.productDetails.color }}&nbsp;</p>
              <p>¥{{ formatPrice(item.productDetails.price) }} </p>

              <!-- プルダウンメニュー -->
              <div class="d-flex align-items-center">
                <span>数量：</span>
                <select v-if="item.selectedQuantity > 0" class="form-select" v-model="item.selectedQuantity">
                  <option v-for="n in (item.productDetails.quantity > 10 ? 10 : item.productDetails.quantity)" :key="n" :value="n">{{ n }}</option>
                </select>
                <a href="#" @click="removeItem(index, $event)">削除</a>
              </div>
              <div v-if="errorMessage" class="alert alert-danger">
                {{ errorMessage }}
              </div>
            </div>
          </div>
          <hr> <!-- 区切り線 -->
        </div>
      </div>
      <div v-else>
        <h2>カートに商品がありません。</h2>
      </div>

      <div class="row justify-content-end">
          <div v-if="cart.length" class="col-md-4 text-right">
            <h4>小計: ¥{{ formatPrice(subtotal) }}</h4>
          </div>
      </div>

      <div class="d-flex justify-content-end mt-3">
        <router-link to="/index" class="btn btn-link me-3">買い物を続ける</router-link>
        <router-link v-if="cart.length"  to="/user/input" class="btn btn-primary">
          配送情報入力
        </router-link>
      </div>
    </div>
  </div>
</template>


<script>
import { EventBus } from '../eventBus';
export default {
  data() {
    return {
      cart: [],
      cartItem: null,
      errorMessage: '',
    };
  },
  computed: {
    subtotal() {
      return this.cart.reduce((acc, item) => acc + item.productDetails.price * item.selectedQuantity, 0);
    }
  },
  mounted() {
    this.loadCart();
    this.loadErrorMessage();
  },
  watch: { //cart配列の変更を監視、変更がある度にセッションストレージを更新
    cart: {
      handler() {
        this.updateCart();
      },
      deep: true
    }
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
    loadErrorMessage() {
      const errorMessage = sessionStorage.getItem('cartError');
      if (errorMessage) {
        this.errorMessage = errorMessage;
        sessionStorage.removeItem('cartError');  // メッセージ表示後は削除
      }
      console.log(errorMessage);
    },
    formatPrice(value) {
      return Number(value).toLocaleString();
    },
    removeItem(index, event) {
      event.preventDefault(); //デフォルト動作防止
      this.cart.splice(index, 1);
      sessionStorage.setItem('cart', JSON.stringify(this.cart));
  },
  updateCart() {
      sessionStorage.setItem('cart', JSON.stringify(this.cart));
      const totalQuantity = this.cart.reduce((sum, item) => sum + item.selectedQuantity, 0);
      EventBus.emit('updateCartItemCount', totalQuantity);
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