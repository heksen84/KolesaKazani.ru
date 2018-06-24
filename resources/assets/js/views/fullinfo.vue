<template>
	<b-container fluid>
	<b-row>
		<b-col cols="12" sm="12" md="4" lg="4" xl="4" style="text-align:center;margin: 3px auto">
			<h3>FullInfo</h3>
			<h5>{{ item[0].title }}</h5>
			<h5>{{ item[0].text }}</h5>
			<h5>{{ item[0].price }}</h5>
		</b-col>
	</b-row>
</b-container>
</template>
</template>
<script>
export default {
	props: ["item"],
	created() {
  	},
	data () {
    return 	{
			}
	},
components: { },
  methods: {
    hello() {
    }
}
}
</script>
