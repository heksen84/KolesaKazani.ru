<template>
	<b-container fluid>
	<b-row>
		<b-col cols="12" sm="12" md="12" lg="12" xl="12" style="text-align:center;margin:auto">
			<h2>личный кабинет</h2>
		</b-col>
		<b-col cols="12" sm="12" md="4" lg="4" xl="4" style="text-align:center;margin:auto">
			<b-button variant="success" @click="logout">выйти</b-button>
		</b-col>
		<b-col cols="12" sm="12" md="4" lg="4" xl="4" style="text-align:center;margin:auto">
			<b-button variant="warning" @click="goHome">вернуться на главную страницу</b-button>
		</b-col>
		<b-col cols="12" sm="12" md="4" lg="4" xl="4" style="text-align:center;margin:auto">
			<b-button variant="error" @click="goHome">разместить объявление</b-button>
		</b-col>
	</b-row>
</b-container>
</template>
<script>
import { get } from './../helpers/api'
export default {
	data () {
    return 	{
	}
},
	created() {
},
components: { },
  methods: {
    logout() {
		get('/logout').then((res) => {
			localStorage.setItem("am_userAuth", false);
			window.location='/';
		}).catch((err) => {});
    },
    goHome() {
    	window.location='/';
    }
}
}
</script>
