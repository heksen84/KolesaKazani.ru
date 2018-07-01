<template>
	<b-container fluid>
		<b-row>
		<b-col cols="12" sm="12" md="12" lg="7" xl="7" style="text-align:left;margin:0px auto;color:black;background:white;opacity:1">
		<h3 style="color:rgb(130,130,130);margin-top:5px"><ins>новое объявление</ins></h3>
		<br>
			<b-form @submit="onSubmit">
			<b-form-group label="Вид сделки:" label-for="default_group" style="width:270px">
				 <b-form-radio-group id="deal_group" stacked v-model="form.deal_selected" :options="this.$root.options_sdelka" name="radioOpenions"></b-form-radio-group>
			</b-form-group>

			<b-form-group label="Категория товара или услуги:" label-for="categories" style="margin-top:30px;width:310px">
				<b-form-select v-model="form.category" class="mb-3" @change="changeCategory">
					 <option :value=null>-- Выберите категорию --</option>
					 <option v-for="item in items" :value="item.id">{{item.name}}</option>
				</b-form-select>
			</b-form-group>
			
			<!-- КАТЕГОРИИ -->
			<div v-if="root"></div>
			<transport v-else-if="transport"/>
			<realestate v-else-if="real_estate"/>
			<h1 v-else-if="appliances"></h1>
			

			<b-form-group label="Описание:" label-for="text">
			 <b-form-textarea id="text" v-model="form.text"
										placeholder="Введите описание"
										:rows="6"
										:max-rows="6" style="background:rgb(240,240,250)">
	 		 </b-form-textarea>
			</b-form-group>


			<!-- ЦЕНА -->
			<b-form-group label="цена:" label-for="price">
			 	<b-form-input id="price" v-model="form.price" placeholder="Цена" style="width:130px;margin:auto;font-size:20px;text-align:center"></b-form-input>
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
import transport from '../components/characteristics/transport';
import realestate from '../components/characteristics/real-estate';

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
		root:false,
		transport:false,
		real_estate:false,
		appliances:false
	}
	},
	created() {
	},
	components: { transport, realestate },
  	methods: {
  		resetCategories(data) {
  			this.root=false;
  			this.transport=false;
  			this.real_estate=false;
  			this.appliances=false;
  		},
  		changeCategory(data) {
  			switch(data) {
  				case null: {
  					this.resetCategories(data); 
  					this.root=true; 
  					break;
  				}
  				case 1: { 
  					this.resetCategories(data); 
  					this.transport=true; 
  					break; 
  				} 
  				case 2: { 
  					this.resetCategories(data); 
  					this.real_estate=true; 
  					break; 
  				}
  				case 3: { 
  					this.resetCategories(data); 
  					this.appliances=true; 
  					break; 
  				}  
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
