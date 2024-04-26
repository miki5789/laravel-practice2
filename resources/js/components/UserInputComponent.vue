<template>

  <div class="container mt-3">
    <div class="row">
      <div>
        <h2>お届け先の情報を入力してください。</h2>
      </div>
      <div v-if="errorMessage" class="alert alert-danger">
        <div v-for="(error, index) in errorMessage" :key="index" class="col-md-3 mb-4">
          - {{ error }}
        </div>
      </div>
      <div class="label">
        <label for="surname">姓</label>
        <label for="given_name">名</label>
      </div>
      <div class="input-row">
        <input type="text" id="surname" v-model="surname">
        <input type="text" id="given_name" v-model="given_name">
      </div>

      <div class="label">
        <label for="surname_kana">セイ</label>
        <label for="given_name_kana">メイ</label>
      </div>
      <div class="input-row">
        <input type="text" id="surname_kana" v-model="surname_kana">
        <input type="text" id="given_name_kana" v-model="given_name_kana">
      </div>

      <div class="label">
        <label for="post_code">〒（ハイフンなし・半角数字のみ）</label>
      </div>

      <div class="input-row">
        <input type="text" v-model="post_code">
        <button @click="fetchAddress" class="btn btn-secondary">
          住所自動入力
        </button>
      </div>

      <div class="label">
        <label for="prefecture">都道府県</label>
        <label for="city">市町村</label>
      </div>
      <div class="input-row d-flex">
        <select v-if="prefectures" class="form-select" v-model="prefecture">
          <option :value="default">-</option>
          <option v-for="prefecture in prefectures" :key="prefecture.prefecture_code" :value="prefecture.prefecture_name">{{ prefecture.prefecture_name }}</option>
        </select>
        <input type="text" v-model="city">
      </div>

      <div class="label">
        <label for="street">番地</label>
        <label for="room">建物名・部屋番号</label>
      </div>
      <div class="input-row">
        <input type="text" v-model="street">
        <input type="text" v-model="room">
      </div>

      <div class="label">
        <label for="email">メールアドレス</label>
      </div>
      <div class="input-row">
        <input type="text" v-model="email">
      </div>
      
      <div class="d-flex justify-content-end mt-3">
        <router-link to="/cart" class="btn btn-link me-3">戻る</router-link>
        <button class="btn btn-primary" @click="validate">進む</button>
      </div>

      <input name="postcode" @change="fetchAddress">
      <input name="address">
    </div>
  </div>
</template>

<script setup>
    import { Core as YubinBangoCore } from "yubinbango-core2";

// 数字を文字に変換 第１引数が郵便番号
// 第２がコールバックで引数に住所
const fetchAddress = () => {
    new YubinBangoCore(String(form.postcode), (value) => {
    form.address = value.region + value.locality + value.street
    })
}
</script>
<script>
export default {

  data() {
    return {
      prefectures: [],
      prefecture: '',
      surname: '',
      given_name: '',
      surname_kana: '',
      given_name_kana: '',
      post_code: '',
      errorMessage: [],
      email: '',
    };
  },
  mounted() {
    this.getPrefectures();
    
  },
  methods: {
    getPrefectures() {
      axios.get('/api/user/input')
        .then((res) => {
          this.prefectures = res.data;
          //console.log("test", this.prefectures[0].prefecture_name)
      }).catch((e) => console.log(e));
    },
    
    fetchAddress() {
    axios.get(`/api/user/post_code/search/${this.post_code}`)
      .then(response => {
        // 成功した場合の処理
        console.log('Address data:', response.data);
      })
      .catch(error => {
        // エラー処理
        console.error('API error:', error);
      });
  },
    validate() {
      let valid = true;
      let errors = [];

      // 姓と名のバリデーション
      if (!this.surname || !this.given_name) {
        console.log(this.surname);
        console.log(this.given_name);
        errors.push('姓と名は必須です。');
        valid = false;
      }

      // セイとメイ validate
      const katakanaRegex = /^[ァ-ンヴー]+$/;
      if (!katakanaRegex.test(this.surname_kana) || !katakanaRegex.test(this.given_name_kana)) {
        errors.push('セイとメイはカタカナで入力してください。');
        valid = false;
      }

      // 郵便番号validate
      const postcodeRegex = /^\d{7}$/;
      if (!postcodeRegex.test(this.post_code)) {
        errors.push('有効な郵便番号を半角・ハイフンなしで入力してください。');
        valid = false;
      }
      if (!this.city ||  !this.street || this.prefecture == "-") {
        errors.push('住所が入力されていません。');
        valid = false;
      }
      
      if (!this.email) {
        errors.push('メールアドレスが入力されていません。');
        valid = false;
      }


      // バリデーション結果の処理
      if (valid) {
        // バリデーションが通れば次の処理へ
        this.goToNextStep();
      } else {
        // エラーを表示
        this.errorMessage = errors;
      }
      console.log(this.errorMessage);
    },
  goToNextStep() {
    // 例: 次のページへのルーティングなど
      this.$router.push('/next');
  },
  validatePostCode(post_code) {
    console.log(post_result);
    axios.get(`/api/user/post_code/search`)
      .then((res) => {
        this.post_result = res.data;
        console.log(this.post_result);
      }).catch((e) => console.log(e));
    },
  async searchPostCode(post_code) {
  console.log(post_result);
  axios.get(`/api/user/post_code/search`)
    .then((res) => {
      this.post_result = res.data;
      console.log(this.post_result);
    }).catch((e) => console.log(e));
  },


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