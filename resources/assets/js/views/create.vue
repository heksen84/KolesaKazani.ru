<template>
	<b-container fluid>
		<b-row>
		<b-col cols="12" sm="12" md="12" lg="5" xl="5" style="text-align:center;margin:auto;margin-top:40px;color:white">
		<h1 class="shadow_text">новое объявление</h1>
		<br>
			<b-form @submit="onSubmit">
			<b-form-group label="Заголовок:" label-for="title" class="shadow_text">
				<b-form-input id="title" type="text"
										 v-model="form.title"
										 required
										 placeholder="Введи заголовок">
				</b-form-input>
			</b-form-group>

			<b-form-group label="Описание:" label-for="text" class="shadow_text">
			 <b-form-textarea id="text" v-model="form.text"
										placeholder="Введите описание"
										:rows="10"
										:max-rows="10">
	 		 </b-form-textarea>
			</b-form-group>


			<!-- ЦЕНА -->
			<b-form-group label="цена:" label-for="price" class="shadow_text">
			 <b-form-textarea id="price" v-model="form.price" placeholder="Цена" style="width:100px;margin:auto"></b-form-textarea>
			</b-form-group>


			<b-form-group label="Категория:" label-for="categories" class="shadow_text">
				<b-form-select v-model="form.category" class="mb-3">
					 <option :value="null">-- Категория товара или услуги --</option>
					 <option v-for="item in items" :value="item.id">{{item.name}}</option>
				</b-form-select>
			</b-form-group>

		

			<b-form-group style="text-align:center">
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
			title: '',
			text: '',
			price: '',
			category: null
		}
	}
	},
	created() {
	},
	components: {},
  	methods: {
    	onSubmit(evt) {
    		evt.preventDefault();
    		post('/create', { "data": this.form }).then((res) => {
    			window.location.href = "/home/555";
    			//console.log(res.data);
    			//alert("created");
			}).catch((err) => {});
    	}
}
}
</script>
