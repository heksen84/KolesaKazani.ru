<template>
  <b-container fluid>
    <b-row>
    <b-col cols="12" sm="12" md="12" lg="4" xl="4" style="text-align:left;margin: 50px auto;color:black;background:white">
    <h2 style="text-align:center">регистрация</h2>
    <br>
    <b-form @submit="onSubmit" style="width:99%">

      <!-- имя / логин -->
      <b-form-group label="Имя:" label-for="name">
        <b-form-input id="name"
                      type="text"
                      v-model="form.name"
                      required
                      placeholder="Введи имя">
        </b-form-input>
      </b-form-group>

      <!-- email -->
      <b-form-group label="Email адрес:" label-for="email">
        <b-form-input id="email"
                      type="email"
                      v-model="form.email"
                      required
                      placeholder="Введи email">
        </b-form-input>
      </b-form-group>

      <!-- пароль -->
      <b-form-group label="Твой пароль:" label-for="password">
        <b-form-input id="password"
                      type="password"
                      v-model="form.password"
                      required
                      placeholder="Введи пароль">
        </b-form-input>
      </b-form-group>

      <!-- пароль -->
      <b-form-group label="Твой пароль:" label-for="password_confirm">
        <b-form-input id="password_confirm"
                      type="password"
                      v-model="form.password_confirmation"
                      required
                      placeholder="Введи пароль">
        </b-form-input>
      </b-form-group>

      <br>
      <b-form-group style="text-align:center">
        <b-button type="submit" variant="primary">Продолжить</b-button>
      </b-form-group>
    </b-form>
  </b-col>
  </b-row>
</b-container>
</template>

<script>
import { post } from './../../helpers/api'
export default {
  data () {
    return {
      form: {
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
      }
    }
  },
  methods: {
    onSubmit (evt) {
      evt.preventDefault();
      post('/register', {
        "name": this.form.name,
        "email": this.form.email,
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
