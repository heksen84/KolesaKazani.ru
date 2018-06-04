<template>
	<b-container fluid>
		<b-row>
		<b-col cols="12" sm="12" md="9" lg="3" xl="3" style="text-align:center;margin:auto;margin-top:40px;color:grey">
		<h1 style="color:white">результаты</h1>
	</b-col>
	</b-row>

	<b-row style="margin-top:20px">
		<b-col cols="12" sm="12" md="7" lg="7" xl="7" style="margin:auto;margin-top:2px;color:grey" v-for="item in 150" :key="item">
			<div style="color:grey;background:white;padding:40px;border-radius:3px;width:100%"><h5>{{ item }}</h5></div>
		</b-col>
	</b-row>
	
</b-container>
</template>
<script>
export default {
	data () {
    return 	{}
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
