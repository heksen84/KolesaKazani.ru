<template>
	<b-container fluid>
		<b-row>
		<b-col cols="12" sm="12" md="12" lg="12" xl="12" style="text-align:center;margin:auto;margin-top:40px;color:grey">
		<h1>новое объявление</h1>
		<br>

		<b-form @submit="onSubmit" @reset="onReset" style="width:50%;margin:auto">
			<b-form-group label="Описание:" label-for="exampleInput1">
				<b-form-input id="exampleInput1"
											type="text"
											v-model="form.title"
											required
											placeholder="Введи заголовок">
				</b-form-input>
			</b-form-group>
			<b-form-group label="Описание:" label-for="textarea1">
			 	<b-form-textarea id="textarea1"
										v-model="form.desc"
										placeholder="Enter something"
										:rows="10"
										:max-rows="10">
	 		 </b-form-textarea>
			</b-form-group>

			<b-button type="submit" variant="primary">Войти</b-button>
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
			}
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
