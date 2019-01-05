<template>
	<b-container fluid class="mycontainer">
	<b-row>
	  <b-col cols="12" sm="12" md="12" lg="10" xl="10" class="create_advert_col">
		  <div class="close_button" title="Закрыть страницу" @click="closeAndReturn">X</div>     
			<br>

			<b>{{ item[0].region_name }}, {{ item[0].city_name }}</b>

			<!-- ТРАНСПОРТ -->
			<div v-if="category==1">
				<h1 style="font-size:190%"><b>{{ item[0].mark }} {{ item[0].model }}, {{ item[0].year}} года</b></h1>
				<hr>
				<h5>Год выпуска: <b>{{ item[0].year }}</b> г.</h5>
				<h5>Вид топлива:
					<b v-if="item[0].engine_type==0">бензин</b>
					<b v-if="item[0].engine_type==1">дизель</b>
					<b v-if="item[0].engine_type==2">газ-бензин</b>
					<b v-if="item[0].engine_type==3">газ</b>
					<b v-if="item[0].engine_type==4">гибрид</b>
					<b v-if="item[0].engine_type==5">электричество</b>
				</h5>
				<h5>Пробег: <b>{{ item[0].mileage }}</b> км.</h5>
				<h5>Положение руля: 
					<b v-if="item[0].steering_position==0">слева</b>
					<b v-else>справа</b>
				</h5>

				<h5>Растоможен: 
					<b v-if="item[0].customs==0">да</b>
					<b v-else>нет</b>
				</h5>

			</div>

			<hr>
				<h5>Дополнительно: <b>{{ item[0].text }}</b></h5>
			<hr>

			<!-- НЕДВИЖИМОСТЬ -->
			<div v-if="category==2">Недвижимость</div>
			<div v-if="category==3">Бытовая техника</div>
			<div v-if="category==4">Работа и бизнес</div>
			<div v-if="category==5">Для дома и дачи</div>
			<div v-if="category==6">Личные вещи</div>			

			<h5>Цена: <b>{{ item[0].price }}</b> тенге</h5>
			<h5>
				тел: <b v-if="item[0].contacts!=null">{{ item[0].contacts }}</b>
				<b v-else>не указан</b>
			</h5>

			<hr v-if="images.length>0">
			
			<div v-if="images.length<=0" style="text-align:center">
				<hr>
				<h5>Без фото</h5>
			</div>

			<div style="text-align:center" v-if="images.length>0">							
				<b-img :src="'../storage/app/images/'+images[image_index].image" fluid style="margin-bottom:5px"/>
				<div>
					<b-img v-for="(i,index) in images" :key="index" :src="'../storage/app/images/'+i.image" style="margin:1px;margin-bottom:8px" width="80" height="80" @click="selectImage(index)"/>					
				</div>
			</div>

			<div style="text-align:center;margin-bottom:20px">							
				<hr>
				<b-button variant="primary" @click="closeAndReturn">закрыть</b-button>
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
		console.log(this.item)		
  	},
	data() {
    return {
			category: null,
			image_index: 0
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