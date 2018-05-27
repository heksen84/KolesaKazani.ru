<template>
	<b-container fluid>
		<b-row>
		<b-col cols="12" sm="12" md="9" lg="3" xl="3" style="text-align:center;margin:auto;margin-top:40px;color:grey">
		<h1 style="color:white">результаты</h1>
	</b-col>
	</b-row>

	<b-row>
		<b-col cols="12" sm="12" md="12" lg="12" xl="12" style="margin:auto;margin-top:3px;heigth:220px;color:grey" v-for="item in 100" :key="item">
			<div style="color:grey;background:white"><h3>{{ item }}</h3></div>
		</b-col>
	</b-row>
</b-container>
</template>
<script>
export default {
	data () {
    return 	{
			}
	},
	created() {
	},
components: { },
  methods: {
    hello() {
    }
}
}
</script>
