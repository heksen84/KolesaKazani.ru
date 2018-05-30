<template>
	<b-button variant="success" @click="logout">выйти</b-button>
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
			get('/logout').then((res) => {}).catch((err) => {});
    }
}
}
</script>
