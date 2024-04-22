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
              <img :src="(item) ? item.productDetails.product_image_master[0].image_path1 : '/images/default.png'" alt="product_image" class="img-fluid">
            </div>
            <div class="col-md-6">
              <p> {{ item.productDetails.product_master.product_name }}&nbsp;&nbsp;{{ item.productDetails.color }}&nbsp;</p>
              <p>¥{{ formatPrice(item.productDetails.price) }} </p>

              <!-- プルダウンメニュー -->
              <div class="d-flex align-items-center">
                <span>数量：</span>
                <select v-if="item.selectedQuantity > 0" class="form-select" v-model="item.selectedQuantity">
                  <option v-for="n in (item.productDetails.quantity > 9 ? 9 : item.productDetails.quantity)" :key="n" :value="n">{{ n }}</option>
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
        <p>カートに商品がありません。</p>
      </div>


      <div class="d-flex justify-content-end mt-3">
        <router-link to="/index" class="btn btn-link me-3">買い物を続ける</router-link>
        <button class="btn btn-primary" @click="goToShipping">配送情報入力</button>
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
      errorMessage: '',
    };
  },
  mounted() {
    this.loadCart();
  },
  methods: {
    addToCart(productToAdd) {
    const existingItem = this.cart.find(item => item.productDetails.product_id === productToAdd.product_id);

    if (existingItem) {
      const newQuantity = existingItem.selectedQuantity + productToAdd.selectedQuantity;
      if (newQuantity > productToAdd.productDetails.quantity) {
        existingItem.selectedQuantity = productToAdd.productDetails.quantity;
        this.errorMessage = `最大選択できる個数は${productToAdd.productDetails.quantity}個です。`;
      } else {
        existingItem.selectedQuantity = newQuantity;
      }
      } else {
        if (productToAdd.selectedQuantity > productToAdd.productDetails.quantity) {
          productToAdd.selectedQuantity = productToAdd.productDetails.quantity;
          alert(`最大選択できる個数は${productToAdd.productDetails.quantity}個です。`);
        }
        this.cart.push(productToAdd);
      }
      sessionStorage.setItem('cart', JSON.stringify(this.cart));
    },
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
    removeItem(index, event) {
      event.preventDefault(); //デフォルト動作防止
      this.cart.splice(index, 1);
      sessionStorage.setItem('cart', JSON.stringify(this.cart));
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