<template>
	<b-container fluid>
		<b-row>
		<b-col cols="12" sm="12" md="12" lg="12" xl="12" style="text-align:center;margin:auto;margin-top:40px;color:grey">
		<h1>новое объявление</h1>
		<br>
		<b-form @submit="onSubmit" @reset="onReset" style="width:50%;margin:auto;text-align:left">
			<b-form-group label="Заголовок:" label-for="title">
				<b-form-input id="title"
											type="text"
											v-model="form.title"
											required
											placeholder="Введи заголовок">
				</b-form-input>
			</b-form-group>
			<b-form-group label="Описание:" label-for="desc">
			 	<b-form-textarea id="desc"
										v-model="form.desc"
										placeholder="Введите описание"
										:rows="10"
										:max-rows="10">
	 		 </b-form-textarea>
			</b-form-group>

			<b-form-group label="Категория:" label-for="categories">
				<b-form-select v-model="selected" :options="options" class="mb-3" size="sm" id="categories"/>
			</b-form-group>

			<b-form-group style="text-align:center">
				<b-button type="submit" variant="primary">Создать</b-button>
			</b-form-group>
		</b-form>



	</b-col>
	</b-row>
</b-container>
</template>
<script>
export default {
	data () {
    return 	{
			form: {
				title: '',
				desc:  ''
			},
			selected: null,
			options: [
			{ value: null, text: 'Please select an option' },
			{ value: 'a', text: 'This is First option' },
			{ value: 'b', text: 'Selected Option' },
			{ value: {'C': '3PO'}, text: 'This is an option with object value' },
			{ value: 'd', text: 'This one is disabled', disabled: true }
		]
		}
	},
	created() {
	},
components: { },
  methods: {
    hello() {
    }
}
}
</script>
