import { createStore } from 'vuex';

const store = createStore({
  state: {
    error: null
  },
  mutations: {
    setErrorData(state, errorData) {
      state.errorData = errorData;
    },
    clearErrorData(state) {
      state.errorData = null;
    }
  }
});

export default store;
