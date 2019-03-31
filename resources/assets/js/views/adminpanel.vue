<template>
	<b-container fluid>
		<b-row>
		<b-col cols="12" sm="12" md="9" lg="3" xl="3" class="form">
		<div class="close_button" title="Закрыть страницу" @click="closeAndReturn">X</div>
    <h1 class="form_title">модератор</h1>    
    <hr>
    <b-form @submit="onSubmit">
			<b-form-input type="text" maxlength="12" placeholder="логин" class="mb-1 mr-sm-1 mb-sm-1"></b-form-input>
			<b-form-input type="password" maxlength="12" placeholder="пароль" class="mb-1 mr-sm-1 mb-sm-1"></b-form-input>
			<b-form-group style="text-align:center;margin:25px">
			<b-button type="onSubmit" variant="outline-primary" title="Опубликовать объявление">войти</b-button>
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
		}
	},
	created() {
	},
components: { },
  methods: {
    closeAndReturn() {
 			  window.history.back();
  	}
}
}
</script>
