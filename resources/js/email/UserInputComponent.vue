// EmailPreview.vue
<template>
  <div>
    <h1>{{ title }}</h1>
    <div v-html="emailContent"></div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      emailSubject: '', // 例: データベースから取得する件名
      emailContent: '', // 例: データベースから取得する本文
    };
  },
  mounted() {
    // メールテンプレートのデータを API から取得する
    fetch('/api/email-template/example')
      .then(response => response.json())
      .then(data => {
        this.emailSubject = data.subject;
        this.emailContent = data.content;
      });
  }
};
</script>
