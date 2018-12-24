<template>
	<b-container fluid class="mycontainer">
	<b-row>
	  <b-col cols="12" sm="12" md="12" lg="10" xl="10" class="create_advert_col">
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

			<hr>

			<div style="text-align:center" v-if="images.length>0">							
				<b-img :src="'../storage/app/images/'+images[image_index].image" fluid style="margin-bottom:5px"/>
				<div>
					<b-img v-for="(i,index) in images" :key="index" :src="'../storage/app/images/'+i.image" style="margin:1px;margin-bottom:8px" width="80" height="80" @click="selectImage(index)"/>					
				</div>
			</div>

			<div style="text-align:center;margin-bottom:20px">							
				<b-button variant="primary">закрыть</b-button>
			</div>
			
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
			category: null,
			image_index: 1
    }
	},
components: { },
  methods: {
		selectImage(index) {
      this.image_index=index;
    },
    closeAndReturn() {
      window.history.back();
    }
}
}
</script>