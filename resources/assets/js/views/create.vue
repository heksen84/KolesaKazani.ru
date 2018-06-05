<template>
	<b-container fluid>
		<b-row>
		<b-col cols="12" sm="12" md="12" lg="5" xl="5" style="text-align:center;margin:auto;margin-top:40px;color:grey">
		<h1>новое объявление</h1>
		<br>
			<b-form-group label="Заголовок:" label-for="title">
				<b-form-input id="title"	type="text"
											v-model="form.title"
											required
											placeholder="Введи заголовок">
				</b-form-input>
			</b-form-group>
			<b-form-group label="Описание:" label-for="desc">
			 <b-form-textarea id="desc" v-model="form.desc"
										placeholder="Введите описание"
										:rows="10"
										:max-rows="10">
	 		 </b-form-textarea>
			</b-form-group>

			<b-form-group label="Категория:" label-for="categories">
				<b-form-select v-model="selected" class="mb-3">
					 <option :value="null">--- Выберите категорию товара или услуги ---</option>
					 <option v-for="item in items "value="item.id">{{item.name}}</option>
				</b-form-select>
			</b-form-group>

			<b-form-group style="text-align:center">
				<b-button @click="onSubmit" variant="primary">Создать</b-button>
			</b-form-group>
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
			desc: ''
		},
		selected: null
	}
	},
	created() {
	},
	components: {},
  	methods: {
    	onSubmit() {
    		post('/create').then((res) => {
    			window.location.href = "/";
			}).catch((err) => {});
    	}
}
}
</script>
