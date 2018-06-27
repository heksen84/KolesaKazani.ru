<template>
	<b-container fluid>
	<b-row>
		<b-col cols="12" sm="12" md="4" lg="4" xl="4" style="text-align:center;margin: 3px auto">
			<h3><ins>FullInfo</ins></h3>
			<h5>{{ item[0].title }}</h5>
			<h5>{{ item[0].text }}</h5>
			<h5>{{ item[0].price }}</h5>



<yandex-map 
  :coords="[54.62896654088406, 39.731893822753904]"
  zoom="10"
  style="width: 450px; height: 450px"
  :behaviors="['ruler']"
  :controls="['trafficControl']"
  :placemarks="placemarks" 
  map-type="map"
  @map-was-initialized="initHandler"
>

</yandex-map>


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




    	 placemarks: [
      {
        coords: [54.8, 39.8],
        properties: {}, // define properties here
        options: {}, // define options here
        clusterName: "1"
      }
    ]


			}
	},
components: { },
  methods: {
    hello() {
    }
}
}
</script>
