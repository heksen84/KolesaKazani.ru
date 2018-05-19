import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

const store = new Vuex.Store({
  state: {
    user: {
      name: "",
      auth: false,
      api_token: ""
    }
  },
  mutations: {
		setAuth (state, value) {
			state.user.auth=value;
		},
    setUserName (state, name) {
      state.user.name=name
		},
    setToken (state, token) {
      state.user.api_token=token;
		}
  }
})

export default store
