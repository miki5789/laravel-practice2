<template>
  <div class="container mt-3">
    <div class="row">

      <div>
        <h1>ご注文内容確認</h1>
        <hr> <!-- 区切り線 -->
      </div>
      <div v-if="topPageMessage" class="alert alert-info">
        {{ topPageMessage }}
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

              <div v-if="item.errorMessage">
                <p>{{item.errorMessage}}</p>
                <button class="btn btn-info" @click="confirmError(index, item.errorMessage)">確認</button>
              </div>
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
        <button class="btn btn-primary" :disabled="isPurchaseDisabled" @click="checkInventory">購入</button>
      </div>
    </div>
</template>


<script>
import { EventBus } from '../eventBus';
export default {
  data() {
    return {
      cart: [],
      errorMessage: '',
      cartItem: null,
      orderResponse: 0,
      isPurchaseDisabled: false,
      $inventoryError: [],
      topPageMessage: '',
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
    formatPrice(value) {
      return Number(value).toLocaleString();
    },
    goToCart(){
      this.$router.push('/product/cart');
    },
    updateCart() {
      sessionStorage.setItem('cart', JSON.stringify(this.cart));
      const totalQuantity = this.cart.reduce((sum, item) => sum + item.selectedQuantity, 0);
      EventBus.emit('updateCartItemCount', totalQuantity);
    },
    async checkInventory() {
      const response = await this.$http.post('/api/product/check_inventory', {
        cart: JSON.parse(sessionStorage.getItem('cart'))
      });
      console.log(response);

      if(response.data.isStockAvailable) {
          this.purchase();
      } else {
        this.isPurchaseDisabled = true;

        this.cart.forEach(item => {
          if (item.productDetails.product_id === response.data.product_id) {
            
            item.selectedQuantity = response.data.remainingStock;
  
            if(response.data.remainingStock >= 1){
              item.errorMessage = `申し訳ありません、他のお客様が購入されたため、残りの在庫数が${response.data.remainingStock}点になりました。`;
            }else if(response.data.remainingStock == 0){
              item.errorMessage = `申し訳ありません、他のお客様が購入されたため、この商品はご購入いただけません。`;
            }
   
          }
        });
      }//複数の在庫が切れた場合の対応
      //在庫が0個になったときの対応
      
    },
    confirmError(index, errorMessage) {
      console.log('confirmErrorIn');
      console.log(this.cart[index].productDetails.quantity);
      if (errorMessage == '申し訳ありません、他のお客様が購入されたため、この商品はご購入いただけません。') {
        this.cart.splice(index, 1);
      }

      if (this.cart.length > 0) {
        this.isPurchaseDisabled = false;
      } else { // カートの商品が0の場合
        this.isPurchacseDisabled = true;
        this.showTopPageMessage();
      }
    },
    showTopPageMessage() {
      // メッセージを表示するための変数を追加
      this.topPageMessage = "TOPページに遷移します...";
      // 3秒後にTOPページに遷移
      setTimeout(() => {
        this.topPageMessage = ""; // メッセージをクリア
        this.$router.push('/index'); // TOPページに遷移
      }, 3000); // 3000ミリ秒（3秒）後に遷移
    },
    async purchase(){
      // Vue.jsコンポーネント内
      const response = await this.$http.post('/api/product/order/confirm', {
        userData: JSON.parse(sessionStorage.getItem('userData')),
        cartData: JSON.parse(sessionStorage.getItem('cart'))
      })
      if(response){
        sessionStorage.setItem('order', JSON.stringify({ order_id: response.data }));
        console.log("response:", response.data);
        
        this.$router.push('/user/complete');        
      }
    },

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