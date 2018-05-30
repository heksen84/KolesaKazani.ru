<template>
  <b-container fluid>
    <b-row>
    <b-col cols="12" sm="12" md="9" lg="3" xl="3" style="text-align:center;margin:auto;margin-top:40px;color:grey">
    <h1>вход</h1>
    <br>
    <b-form @submit="onSubmit" style="width:99%">
      <b-form-group label="Email адрес:" label-for="email">
        <b-form-input id="email"
                      type="email"
                      v-model="form.email"
                      required
                      placeholder="Введи email">
        </b-form-input>
      </b-form-group>
      <b-form-group label="Твой пароль:" label-for="password">
        <b-form-input id="password"
                      type="password"
                      v-model="form.password"
                      required
                      placeholder="Введи пароль">
        </b-form-input>
      </b-form-group>
      <b-form-group>
        <b-form-checkbox-group v-model="form.checked">
          <b-form-checkbox value="me">запомнить меня</b-form-checkbox>
        </b-form-checkbox-group>
      </b-form-group>
      <b-button type="submit" variant="primary">Войти</b-button>
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
        email: '',
        password: '',
        checked: true
      },
    }
  },
  methods: {
    onSubmit (evt) {
      evt.preventDefault();
      post('/login', { "email": this.form.email,"password": this.form.password }
      ).then((res) => {
        console.log(res)
        alert("good!");
      }).catch((err) => {
      console.log(err.response.data);
    });
    }
  }
}
</script>
