
import axios from 'axios';
import router from '../../resources/js/app.js';
import store from '../../resources/js/store.js';

const http = axios.create({
  baseURL: 'http://localhost', // APIのベースURLを設定
  timeout: 5000,
  
  headers: {
    'Content-Type': 'application/json'
  }
  
});


// リクエストエラー時の共通処理
http.interceptors.request.use(
  /*
  console.log('requestIn:'),
  response => response,
  config => {
    // リクエスト送信前の共通処理
    return config;
  },
  error => {
    return Promise.reject(error);
  }*/
  response => response,
  console.log('requestIn:'),
  error => {
    console.log('httpIn');
    console.log(error.response);
      
    if (error.response && error.response.status >= 400) {
      axios.post('/api/error', error)
      // エラーページにリダイレクト
      //router.push({ name: 'error.check', params: { error: error.response }});
      .then(response => {
        console.log(response);
        store.commit('setErrorData', response);
        router.push({ name: 'error.result' });
      });
    }
    console.log('before return');
    return Promise.reject(response);
  }
);

// レスポンスエラー時の共通処理
http.interceptors.response.use(
  
    response => response,
    console.log('response:'),
    error => {
      console.log('httpIn');
      console.log(error.response);
        
      if (error.response && error.response.status >= 400) {
        axios.post('/api/error', error)
        // エラーページにリダイレクト
        //router.push({ name: 'error.check', params: { error: error.response }});
        .then(response => {
          console.log(response);
          store.commit('setErrorData', response);
          router.push({ name: 'error.result' });
        });
      }
      console.log('before return');
      return Promise.reject(response);
    }
  );

export default http;


/*
import axios from 'axios';
import { errorCheck } = '../../app/Http/Controllers/Cotroller.php'; // コントローラーから関数をインポート

//axios.interceptors.response.use(handleSuccess, 
axios.interceptors.response.use(function (response) {
    // 成功時の処理
    return response;
  }, function(error)
  }, errorCheck(error.response));  
  console.log('intercepterIn');  
  console.log(error.response);

  export default axiosErrorHandler;
  */