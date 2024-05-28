<template>
  
<div class="container mt-3">
  <div class="row align-items-center">
    <div class="col-md-6">
      <img :src="(selectedDetail) ? selectedDetail.product_image_master[0].image_path1 : '/images/default.png'" alt="product_image" class="img-fluid">
    </div>
    <div class="col-md-6">
      <h1>{{ selectedDetail ? selectedDetail.product_master.product_name : 'Product details not available' }}</h1>
      <h3>{{ selectedDetail ? selectedDetail.color : 'Product color is not available' }}</h3>
      <h2 v-if="selectedDetail">¥{{ formatPrice(selectedDetail.price) }}</h2>

      <div class="row">
        <div v-for="(detail, index) in details" :key="index" class="col-md-3 mb-4">
          <img :src="detail.product_image_master[0].image_path1" :alt="detail.color" :title="detail.color" class="img-button" @click="selectDetailByProductId(detail.product_id)">
        </div>
      </div>

      <div class="row">
        <p v-if="selectedDetail.quantity <= 0">在庫なし</p>
        <!-- プルダウンメニュー -->
        <select v-if="selectedDetail.quantity > 0" class="form-select" v-model="selectedQuantity">
          個数：<option v-for="n in Math.min(parseInt(selectedDetail.quantity), 10)" :key="n" :value="n">{{ n }}</option>
        </select>
        <!-- カートに入れるボタン -->
        <button class="btn btn-primary" @click="addToCart">カートに入れる</button>
      </div>      

    </div>
  </div>
</div>

</template>


<script>
import { EventBus } from '../eventBus';
export default {
  data() {
    return {
      //プルダウン選択個数デフォルト値
      selectedQuantity: 1,
      details: [],
      
      //選択カラーデフォルト値
      selectedDetail: {
        product_id: 0,
        product_master_id: 0,
        color: '',
        price: 0,
        quantity: 0,

        product_master:{
          product_master_id: 0,
          product_name: '',
        },
        product_image_master:[{
          product_id: 0,
          image_path1: '',
          image_path2: '',
          image_path3: '',
        }]
      },
      errorMessage: ''
    }
  },
  methods: {
    async getDetails() {
      // Vue Routerからパラメータを取得
      const product_master_id = this.$route.params.product_master_id;
      const res = await this.$http.get(`/api/product/detail/${product_master_id}`)
        if(res){
          this.details = res.data;
          this.selectDetail();
          console.log('GetDetails:OK');
        }
    },
    selectDetail() {
    // product_id に基づいて該当する詳細を検索
      console.log("Searching for product_id:", this.details[0].product_id); // デバッグ: 探しているproduct_idの表示
      this.selectedDetail = this.details.find(detail => detail.product_id === this.details[0].product_id);
      console.log("Selected quantity:", this.selectedDetail.quantity);
      console.log("Selected detail:", this.selectedDetail);
    },
    selectDetailByProductId(productId) {
      this.selectedDetail = this.details.find(detail => detail.product_id === productId);
      console.log("selected product_id:", this.selectedDetail.product_id);
      console.log("selected color:", this.selectedDetail.color);
      console.log("selected productquantity:", this.selectedDetail.quantity);
    },
    // 価格をフォーマットするメソッドを追加
    formatPrice(value) {
      // toLocaleStringを使用して価格をフォーマット
      return Number(value).toLocaleString();
    },
    addToCart() {
      const newItem = {
        productDetails: this.selectedDetail,
        selectedQuantity: this.selectedQuantity
      };
      // セッションストレージから現在のカートを取得
      const cartData = sessionStorage.getItem('cart');
      //ブロックスコープのローカル変数を宣言
      //let で宣言された変数は、その変数が宣言されたブロック、式、または文の中でのみアクセス可能
      let cart = cartData ? JSON.parse(cartData) : [];

      // 既存の商品を探す
      const existingItemIndex = cart.findIndex(item => item.productDetails.product_id === this.selectedDetail.product_id);

      if (existingItemIndex !== -1) {
        // 既存の商品の数量を更新
        const existingItem = cart[existingItemIndex];
        let newQuantity = existingItem.selectedQuantity + this.selectedQuantity;
        
        if (newQuantity > this.selectedDetail.quantity) {
          existingItem.selectedQuantity = this.selectedDetail.quantity; // 在庫数に合わせる
          this.errorMessage = `最大選択できる個数は${this.selectedDetail.quantity}個です。`; // エラーメッセージを設定
        } else {
          existingItem.selectedQuantity = newQuantity;
        }
      } else {
        // 新しい商品をカートに追加
        cart.push(newItem);
      }

      // カートを更新してセッションストレージに保存
      sessionStorage.setItem('cart', JSON.stringify(cart));
      //エラーメッセージがあれば、セッションストレージに保存
      if (this.errorMessage) {
        sessionStorage.setItem('cartError', this.errorMessage);
      }
      //カート点数表記を更新
      const totalQuantity = cart.reduce((sum, item) => sum + item.selectedQuantity, 0);
      EventBus.emit('updateCartItemCount', totalQuantity);
      // カートページへナビゲート
      this.$router.push({ name: 'cart' });
    },
  },
  async mounted() {
    console.log('Received product_id on mount:', this.product_id);
    await this.getDetails();
    
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
.col-md-3 {
  display: flex;
  flex-direction: column;
  justify-content: space-between; /* 内容を均等に分布させる */
}

.img-button {
  width: 60%; /* コンテナの幅に合わせて調整 */
  cursor: pointer; /* マウスカーソルをポインターに変更 */
  transition: transform 0.3s ease; /* クリック時の視覚効果 */
}

.img-button:hover {
  transform: scale(1.05); /* ホバー時に画像を少し大きくする */
}
</style>