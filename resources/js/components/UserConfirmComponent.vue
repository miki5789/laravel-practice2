<template>

<div class="container mt-3">
    <div class="row">
      <div>
        <h1>お届け先確認</h1>
      </div>
      
      <div v-if="userData">
        <hr> <!-- 区切り線 -->
          <div class="col-md-6">
            <p>〒{{ userData.postcode.slice(0, 3) }}-{{ userData.postcode.slice(3) }}<br>
            {{ userData.prefecture }}{{ userData.city }}{{ userData.street }}<br>
            {{ userData.room }}</p>
            <p> {{ userData.surname }}&nbsp;&nbsp;{{ userData.given_name }}<br>
            {{ userData.surname_kana }}&nbsp;&nbsp;{{ userData.given_name_kana }}</p>
            <p> {{ userData.email }}</p>
          </div>
        <hr> <!-- 区切り線 -->
        <div class="d-flex justify-content-end mt-3">
        <button class="btn btn-primary" @click="goToPreviousPage">戻る</button>
        <button class="btn btn-primary" @click="goToNextPage">進む</button>
      </div>
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
    this.loadUserData();
  },
  methods: {
    loadUserData() { //カート追加
      const userData = sessionStorage.getItem('userData');
      //userDataDataがあればjsonよみこみ
      this.userData = userData ? JSON.parse(userData) : [];
      console.log("userdata:", this.userData);
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