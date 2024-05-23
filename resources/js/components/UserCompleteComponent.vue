<template>

<div class="container mt-3 centered-content">
    <div class="centered-content">
      <h1>Thank You!</h1>
      <img :src="'/images/icon/track.svg'" alt="track" class="center"/>
    </div>
      
      <div v-if="orderData">
        <div class="centered-content">
            <p>ご購入いただきありがとうございます。</p>
            <p>  ご注文番号：{{ this.order.order_id }}</p>

            <p>ご注文明細メールを
              メールアドレスにお送りしました。
            </p>
          </div>

      </div>

</div>
</template>


<script>
export default {

  data() {
    return {
      orderData: [],
      order: [],
      order_id: 0
    };
  },
  async mounted() {
    this.loadCart();
    await this.loadOrderData();
  },
  beforeUnmount() { // コンポーネントが破棄される直前に呼び出される
    this.clearSessionData();
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
    loadOrderData() { //カート追加
      const orderData = sessionStorage.getItem('order');
      //userDataDataがあればjsonよみこみ
      this.order = orderData ? JSON.parse(orderData) : [];
      console.log("orderData:", this.order);
    },
    updateCart() {
      sessionStorage.setItem('cart', JSON.stringify(this.cart));
      const totalQuantity = this.cart.reduce((sum, item) => sum + item.selectedQuantity, 0);
      EventBus.emit('updateCartItemCount', totalQuantity);
    },
    clearSessionData() {
      // 注文データをセッションストレージから削除
      sessionStorage.removeItem('order');
      console.log("Session data has been cleared");
    },
        // ユーザーデータの削除
    clearUserData() {
      sessionStorage.removeItem('userData');
      this.userData = []; // ローカルデータもリセット
      console.log("userData has been cleared");
    },
    clearCart() { // カートデータの削除
      sessionStorage.removeItem('cart');
      this.cart = []; // ローカルデータもリセット
      console.log("cartData has been cleared");
    }

  },
  
}
</script>


<style>
h1 {
  font-size: 2.5rem; /* タイトルのフォントサイズを増やす */
  margin-bottom: 20px;
}
p {
  font-size: 1.25rem; /* 段落のフォントサイズを増やす */
  margin: 10px 0; /* 各段落の間に適度なスペースを追加 */
}
/* 親コンテナのスタイル */
.centered-content {
  display: flex;
  flex-direction: column; /* コンテンツを縦に配置 */
  align-items: center; /* 水平方向に中央揃え */
  justify-content: center; /* 垂直方向に中央揃え */
  text-align: center; /* テキストを中央揃え */
  margin-top: 20px;
}
.center {
  display: block;
  margin-left: auto;
  margin-right: auto;
  width: 70%; /* 画像の幅を拡大 */
}

</style>