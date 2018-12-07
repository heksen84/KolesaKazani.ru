<template>
	<b-container fluid class="mycontainer">
	<b-row>
	  <b-col cols="12" sm="12" md="12" lg="10" xl="10" class="create_advert_col">
		  <div class="close_button" title="Закрыть страницу" @click="closeAndReturn">X</div>     
			<br>
			<h1>{{ item[0].text }}</h1>
			<h2>{{ item[0].price }} тенге</h2>
			<h5>тел. : {{ item[0].contacts }}</h5>
			
			-----------------------------------------------------------------
			{{ string }}
		</b-col>
	</b-row>
</b-container>
</template>
<script>
export default {
	props: ["item", "string"],
	created() {
  
    console.log(this.item)
  
  },
	data() {
    return {    
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
