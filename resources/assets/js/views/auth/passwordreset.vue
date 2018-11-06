<template>
  <b-container fluid class="mycontainer">
    <b-row>
      
    <!-- ALERT -->    
    <b-col cols="12" sm="12" md="12" lg="12" xl="12" v-if="$root.alert.show">    
      <b-alert variant="danger" show class="alert">{{ $root.alert.msg }}</b-alert>
    </b-col>

    <!-- ФОРМА -->
    <b-col cols="12" sm="12" md="12" lg="4" xl="4" class="form">
    <div class="close_button" title="Закрыть страницу" @click="closeAndReturn">X</div>
    <h3 class="form_title">сброс пароля</h3>
    <hr>
    <b-form @submit="onSubmit" style="width:99%">
      
      <!-- пароль -->
      <b-form-group label="Новый пароль:" label-for="password">
        <b-form-input id="password"
                      type="password"
                      v-model="form.password"
                      required
                      placeholder="Введите новый пароль">
        </b-form-input>
      </b-form-group>

      <!-- подтверждение пароля -->
      <b-form-group label="Подтверждение пароля:" label-for="password_confirm">
        <b-form-input id="password_confirm"
                      type="password"
                      v-model="form.password_confirmation"
                      required
                      placeholder="Подтвердите новый пароль">
        </b-form-input>
      </b-form-group>

      <br>
      <b-form-group style="text-align:center">
        <b-button type="submit" variant="primary">Сохранить</b-button>
      </b-form-group>
    </b-form>
  </b-col>
  </b-row>
</b-container>
</template>

<script>
import { post } from './../../helpers/api'
export default {
  props: ["token"],
  data () {
    return {
      form: {
        password: '',
        password_confirmation: '',
      }
    }
  },
  methods: {
    closeAndReturn() {
 		  window.location="/login";
  	},
    onSubmit (evt) {
      evt.preventDefault();
      post('/register', {
        "password": this.form.password,
        "password_confirmation": this.form.password_confirmation
      }
      ).then((res) => {
        console.log(res)
        alert("good!");
		  }).catch((err) => {
			console.log(err.response.data);
			if(err.response.status === 422) {
        if (err.response.data.errors.password)
        alert(err.response.data.errors.password);
			}
  	});
    }
  }
}
</script>
