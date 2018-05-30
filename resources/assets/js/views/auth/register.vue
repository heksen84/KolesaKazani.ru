<template>
  <b-container fluid>
    <b-row>
    <b-col cols="12" sm="12" md="9" lg="3" xl="3" style="text-align:center;margin:auto;margin-top:40px;color:grey">
    <h1>регистрация</h1>
    <br>
    <b-form @submit="onSubmit" style="width:99%">

      <!-- имя / логин -->
      <b-form-group label="Имя:" label-for="name">
        <b-form-input id="name"
                      type="text"
                      v-model="form.login"
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
      <br>
      <b-form-group>
        <b-button type="submit" variant="primary">Продолжить</b-button>
      </b-form-group>
    </b-form>
  </b-col>
  </b-row>
</b-container>
</template>

<script>
import { post, get, interceptors } from './../../helpers/api'
import { toMulipartedForm, objectToFormData } from './../../helpers/form'
export default {
  data () {
    return {
      form: {
        name: '',
        email: '',
        password: ''
      }
    }
  },
  methods: {
    onSubmit (evt) {
      evt.preventDefault();
      //alert(JSON.stringify(this.form));

      get('/register', objectToFormData(this.form)).then((res) => {
        console.log(res)
        //alert(res);
		  }).catch((err) => {
			console.log(err.response.data);
			if(err.response.status === 422) {
        alert("error");
			}
  	});

    }
  }
}
</script>
