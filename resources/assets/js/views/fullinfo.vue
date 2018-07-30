<template>
	<b-container fluid>
	<b-row>
	<b-col cols="12" sm="12" md="12" lg="8" xl="8" style="text-align:left;margin: auto;color:black;background:white">

    <div class="close_button" title="Закрыть страницу" @click="closeAndReturn">X</div>

    <center style="margin-top:10px">
			<h5>{{ item[0].title }}</h5>
			<h5>{{ item[0].text }}</h5>
			<h5>{{ item[0].price }}</h5>
    </center>

  <center style="margin:50px">
    <yandex-map 
    :coords="[54.62896654088406, 39.731893822753904]"
      zoom="10"
      style="width: 300px; height: 300px"
      :behaviors="['ruler']"
      :controls="['trafficControl']"
     :placemarks="placemarks" 
      map-type="map"
      @map-was-initialized="initHandler">
    </yandex-map>

  </center>


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

      placemarks: [{
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
    closeAndReturn() {
      window.history.back();
    }
}
}
</script>
