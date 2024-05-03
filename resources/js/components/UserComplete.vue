<template>

<div class="container mt-3">
    <div class="row">
      <div>
        <h1>お届け先確認</h1>
      </div>
      
      <div v-if="userData">
        <hr> <!-- 区切り線 -->
          <div class="col-md-6">
            <p>complete!</p>
          </div>
        <hr> <!-- 区切り線 -->
      </div>
    </div>
  </div>
</template>


<script>
export default {

  data() {
    return {
      userData: null
    };
  },
  mounted() {
    //this.surname = localStorage.getItem('userData');
    
    console.log(this.userData);
  },
  methods: {
    loadUserData() { //カート追加
      const userData = sessionStorage.getItem('userData');
      //userDataDataがあればjsonよみこみ
      this.userData = userData ? JSON.parse(userData) : [];
      console.log("userdata:", this.userData);
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
    goToPreviousPage(){
    this.$router.push('../input');
    },
    goToNextPage(){
    this.$router.push('/product/order/confirm');
    }
  }
  
}
</script>


<style>


.input-row {
  display: flex;
  align-items: center; /* 中央揃え */
  margin-bottom: 20px; /* 下マージン */
}

label {
  margin-right: 200px; /* ラベルの右マージン */
  white-space: nowrap; /* ラベルが折り返さないように設定 */
}

input[type="text"], input[type="number"] {
  margin-right: 20px; /* 入力ボックスの右マージン */
}

.form-select {
  width: 150px; /* 幅を指定 */
  padding: 0.25rem 0.5rem; /* パディングを調整 */
  font-size: 0.875rem; /* フォントサイズを小さく */
  margin-right: 20px; /* ラベルの右マージン */
}

</style>