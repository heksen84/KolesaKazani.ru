<template>
	<b-container fluid>
		<b-row>
		<b-col cols="12" sm="12" md="12" lg="5" xl="5" style="text-align:left;margin:auto;margin-top:40px;color:black">
		<h2 style="text-align:center"><ins>новое объявление</ins></h2>
		<br>
			<b-form @submit="onSubmit">


			<b-form-group label="Вид сделки:" label-for="default_group" style="width:270px">
				 <b-form-radio-group id="deal_group" stacked v-model="form.deal_selected" :options="this.$root.options_sdelka" name="radioOpenions"></b-form-radio-group>
			</b-form-group>

			<b-form-group label="Категория товара или услуги:" label-for="categories" style="margin-top:30px">
				<b-form-select v-model="form.category" class="mb-3" @change="changeCategory">
					 <option :value=null>-- Выберите категорию --</option>
					 <option v-for="item in items" :value="item.id">{{item.name}}</option>
				</b-form-select>
			</b-form-group>

			<h1 v-if="cars">CARS</h1>
			<h1 v-if="home">HOME</h1>

			<b-form-group label="Описание:" label-for="text">
			 <b-form-textarea id="text" v-model="form.text"
										placeholder="Введите описание"
										:rows="6"
										:max-rows="6">
	 		 </b-form-textarea>
			</b-form-group>


			<!-- ЦЕНА -->
			<b-form-group label="цена:" label-for="price">
			 <b-form-textarea id="price" v-model="form.price" placeholder="Цена" style="width:130px;margin:auto;font-size:20px;text-align:center"></b-form-textarea>
			</b-form-group>

			<b-form-group style="text-align:center;margin:30px">
				<b-button type="onSubmit" variant="primary">Создать</b-button>
			</b-form-group>
		</b-form>
	</b-col>
	</b-row>
</b-container>
</template>
<script>
import { post } from './../helpers/api'
export default {
	props: ["items"],
	data () {
    return 	{
		form: {
			deal_selected: 0,
			category: null,
			title: '',
			text: '',
			price: '',
		},

		cars:false,
		home:false
	}
	},
	created() {
	},
	components: {},
  	methods: {
  		changeCategory(data) {
  			switch(data) {
  				case null: this.cars=false; break;
  				case 1: this.cars=true; break;
  				case 2: this.home=true; break;
  			}
  		},
    	onSubmit(evt) {
    		evt.preventDefault();
    		post('/create', { "data": this.form }).then((res) => {
    			window.location.href = "/home/555";
			}).catch((err) => {});
    	}
}
}
</script>
