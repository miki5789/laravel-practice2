<template>
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-sm-6">
          <form @submit.prevent="submitForm">
            <div class="form-group row">
              <label for="id" class="col-sm-3 col-form-label">ID</label>
              <input type="text" class="col-sm-9 form-control-plaintext" readonly id="id" :value="taskId">
            </div>
            <div class="form-group row">
              <label for="title" class="col-sm-3 col-form-label">Title</label>
              <input type="text" class="col-sm-9 form-control" id="title" v-model="formData.title">
            </div>
            <div class="form-group row">
              <label for="content" class="col-sm-3 col-form-label">Content</label>
              <input type="text" class="col-sm-9 form-control" id="content" v-model="formData.content">
            </div>
            <div class="form-group row">
              <label for="person-in-charge" class="col-sm-3 col-form-label">Person In Charge</label>
              <input type="text" class="col-sm-9 form-control" id="person-in-charge" v-model="formData.personInCharge">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
          </form>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    props: {
      taskId: String
    },
    data() {
      return {
        formData: {
          title: '',
          content: '',
          personInCharge: ''
        }
      };
    },
    methods: {
      submitForm() {
        // フォームの送信処理を記述する
      }
    }
  };
  </script>
  
  <style scoped>
  /* ここにスタイルを記述 */
  </style>
  