<template>
	<b-container fluid>
		<b-row>
			<b-col cols="12" sm="12" md="9" lg="3" xl="3" style="text-align:center;margin:auto;margin-top:40px;color:grey">
			<h1 style="color:white">результаты</h1>
			</b-col>
		</b-row>

	<b-row style="margin-top:20px">
		<b-col cols="12" sm="12" md="8" lg="8" xl="8" v-for="item in items" :key="item" style="margin:auto">
			<item :id="item.id" :name="item.name"></item>
		</b-col>
	</b-row>
	
</b-container>
</template>
<script>
import item from "../components/item"
export default {
	props: ["items"],
	data () {
    return 	{
   	  slide: 0,
      sliding: null
    }
	},
	created() {
	},
	components: { item },
  		methods: {
	}
}
</script>
