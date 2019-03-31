<template>
	<b-container fluid>
		<b-row>
		<b-col cols="12" sm="12" md="9" lg="3" xl="3" class="form">
		<div class="close_button" title="Закрыть страницу" @click="closeAndReturn">X</div>
    <h2 class="form_title">модератор</h2>    
    <hr>
    <b-form @submit="onSubmit" style="width:99%">
		<b-form-input maxlength="12" placeholder="логин"></b-form-input>
		<b-form-input maxlength="12" placeholder="пароль"></b-form-input>
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
