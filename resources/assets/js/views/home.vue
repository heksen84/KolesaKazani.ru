<template>
	<b-container fluid>
	<b-row>
		<b-col cols="12" sm="12" md="12" lg="12" xl="12" style="text-align:center;margin:auto">
			<br>
		</b-col>
		<b-col cols="12" sm="12" md="4" lg="4" xl="4" style="text-align:center;margin:auto">
			<b-button variant="success" @click="logout">выйти</b-button>
		</b-col>
		<b-col cols="12" sm="12" md="4" lg="4" xl="4" style="text-align:center;margin:auto">
			<b-button variant="primary" @click="goHome">вернуться на главную страницу</b-button>
		</b-col>
		<b-col cols="12" sm="12" md="4" lg="4" xl="4" style="text-align:center;margin:auto">
			<b-button variant="secondary" @click="createAdvert">разместить объявление</b-button>
		</b-col>
		<b-col cols="12" sm="12" md="12" lg="12" xl="12" style="text-align:center;margin:auto">
			<br>
			<h3>мои объявления</h3>
		</b-col>
		<b-col cols="12" sm="12" md="8" lg="8" xl="8" style="text-align:center;margin:auto">
			<br>
			<b-table striped hover :items="items" style="background:white;color:black"></b-table>
		</b-col>
	</b-row>
</b-container>
</template>
<script>

import { get } from './../helpers/api'
export default {
	props: ["items"],
	data () {
    return 	{
    	items: items
	}
},
	created() {
},
components: {},
  methods: {
    logout() {
		get('/logout').then((res) => {
			window.location='/';
		}).catch((err) => {});
    },
    goHome() {
    	window.location='/';
    },
    createAdvert() {
    	window.location='/create';
    }
}
}
</script>
