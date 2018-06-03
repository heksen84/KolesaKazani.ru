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
			<b-button variant="error" @click="createAdvert">разместить объявление</b-button>
		</b-col>

		<b-table striped hover :items="items"></b-table>

	</b-row>
</b-container>
</template>
<script>

const items = [
  { isActive: true, age: 40, first_name: 'Dickerson', last_name: 'Macdonald' },
  { isActive: false, age: 21, first_name: 'Larsen', last_name: 'Shaw' },
  { isActive: false, age: 89, first_name: 'Geneva', last_name: 'Wilson' },
  { isActive: true, age: 38, first_name: 'Jami', last_name: 'Carney' }
]

import { get } from './../helpers/api'
export default {
	data () {
    return 	{
    	items: items
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
    },
    createAdvert() {
    	window.location='/create';
    }
}
}
</script>
