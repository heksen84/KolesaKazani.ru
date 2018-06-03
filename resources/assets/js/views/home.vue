<template>
	<b-container fluid>
	<b-row>
		<b-col cols="12" sm="12" md="9" lg="3" xl="3" style="text-align:center;margin:auto">
			<h2>личный кабинет</h2>
			<b-button variant="success" @click="logout">выйти</b-button>
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
    }
}
}
</script>
