<template>
	<b-container fluid>
		<b-row>
			<b-col cols="12" sm="12" md="9" lg="3" xl="3" style="text-align:center;margin:auto;margin-top:40px;color:grey">
			<h1 style="color:white">результаты</h1>
			</b-col>
		</b-row>
	<br>
	<b-row style="margin-top:-2px" v-for="item in items">
		
		<b-col cols="12" sm="12" md="2" lg="2" xl="2" :key="item.id">
			<!--<item :id="item.id" :name="item.name"></item>-->
			<center>
				<h2>фотка</h2>
			</center>
		</b-col>

		<b-col cols="12" sm="12" md="10" lg="10" xl="10" :key="item.id">
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
