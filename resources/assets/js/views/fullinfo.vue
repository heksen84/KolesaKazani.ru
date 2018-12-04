<template>
	<b-container fluid class="mycontainer">
	<b-row>
	  <b-col cols="12" sm="12" md="12" lg="10" xl="10" class="create_advert_col">
		  <div class="close_button" title="Закрыть страницу" @click="closeAndReturn">X</div>
      {{ item.text }}
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
