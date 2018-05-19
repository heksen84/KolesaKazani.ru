<template>
  <b-navbar toggleable>
  <b-navbar-toggle target="nav_collapse"><b style="color:grey;position:relative;top:-1px">меню</b></b-navbar-toggle>
  <b-navbar-brand style="cursor:default"><span class="carefree-font" v-on:click="goWelcome">&nbsp;мир вокруг</span></b-navbar-brand>

  <b-collapse is-nav id="nav_collapse" v-if="!auth">
    <b-navbar-nav class="ml-auto">
 	 <b-navbar-nav>
	      <b-nav-item href="/login"><span style="color:black">Вход</span></b-nav-item>
	      <b-nav-item href="/register"><span style="color:black">Регистрация</span></b-nav-item>
	    </b-navbar-nav>
    </b-navbar-nav>
  </b-collapse>

  <b-collapse is-nav id="nav_collapse" v-if="auth">
    <b-navbar-nav class="ml-auto">
   <b-navbar-nav>
        <b-nav-item href="/logout"><span style="color:black">Выйти</span></b-nav-item>
      </b-navbar-nav>
    </b-navbar-nav>
  </b-collapse>
</b-navbar>
</template>

<script type="text/javascript">
import { post, interceptors } from './../helpers/api'
export default {
  props: ['auth'],
  data () {
    return 	{
        user: {
        }
			}
	},
  created() {
  },
  methods: {
    logout() {
      post('/api/logout').then((res) => {
        if(res.data.done) {
        }
		}).catch((err) => {
			console.log(err.response.data);
  	});
		},
		goWelcome() {
		    window.location="/";
		}
  },
  computed: {
}
}
</script>
