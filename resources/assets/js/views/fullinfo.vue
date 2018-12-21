<template>
	<b-container fluid class="mycontainer">
	<b-row>
	  <b-col cols="12" sm="12" md="12" lg="8" xl="8" class="create_advert_col">
		  <div class="close_button" title="Закрыть страницу" @click="closeAndReturn">X</div>     
			<br>

			<!-- ТРАНСПОРТ -->
			<div v-if="category==1">				
				<!--<h1 style="font-size:190%">{{ item[0].deal_name_2 }} <b>{{ item[0].mark }} {{ item[0].model }}</b> {{ item[0].year}} года в</h1>-->
				<h1 style="font-size:190%"><b>{{ item[0].mark }} {{ item[0].model }}</b> {{ item[0].year}} года</h1>
			</div>

			<hr>

			<div v-if="category==2">Недвижимость</div>
			<div v-if="category==3">Бытовая техника</div>
			<div v-if="category==4">Работа и бизнес</div>
			<div v-if="category==5">Для дома и дачи</div>
			<div v-if="category==6">Личные вещи</div>			

			<h5>Дополнительно: {{ item[0].text }}</h5>
			<h5>Цена: {{ item[0].price }} тенге</h5>
			<h5>тел. : {{ item[0].contacts }}</h5>

			<span v-for="(i,index) in item[0].images" :key="index">{{ i }}</span>
			
		</b-col>
	</b-row>
</b-container>
</template>
<script>
export default {

	props: ["item", "images"],
	
	created() {
      
		this.category=this.item[0].category_id;
		
		console.log(this.category)
		console.log(this.item)
		console.log(this.images)

  },
	data() {
    return {
			category: null
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