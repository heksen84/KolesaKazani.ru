<template>
  <b-container fluid class="mycontainer">
    <b-row>
    <b-col cols="12" sm="12" md="12" lg="4" xl="4" style="text-align:left;margin: 50px auto;color:black;background:white">
    <h3 style="text-align:center;margin-top:10px;color:grey">Вход</h3>
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
      <b-form-group style="text-align:center">
        <b-button type="submit" variant="primary">Войти</b-button>
      </b-form-group>
      <b-form-group>
      <br>Ещё не зарегистрированы?
       <b-link href="/register">Зарегистрироваться</b-link>
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
        window.location='/home';
      }).catch((err) => {
      console.log(err.response.data);
    });
    },
    register(evt) {
      window.location='/register';
    }
  }
}
</script>
