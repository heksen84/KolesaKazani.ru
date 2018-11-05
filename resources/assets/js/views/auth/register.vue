<template>
  <b-container fluid class="mycontainer">
    <b-row>
      
     <!-- ALERT -->    
    <b-col cols="12" sm="12" md="12" lg="12" xl="12" v-if="$root.alert.show">    
      <b-alert variant="danger" show class="alert">{{ $root.alert.msg }}</b-alert>
    </b-col>

    <!-- ФОРМА -->
    <b-col cols="12" sm="12" md="12" lg="4" xl="4" class="standart_window">
    <div class="close_button" title="Закрыть страницу" @click="closeAndReturn">X</div>
    <h3 style="text-align:center;margin-top:10px;color:grey">регистрация</h3>
    <hr>
    <b-form @submit="onSubmit" style="width:99%">

      <!-- имя / логин -->
      <b-form-group label="Имя:" label-for="name">
        <b-form-input id="name"
                      type="text"
                      v-model="form.name"
                      required
                      placeholder="Введите имя">
        </b-form-input>
      </b-form-group>

      <!-- email -->
      <b-form-group label="Email адрес:" label-for="email">
        <b-form-input id="email"
                      type="email"
                      v-model="form.email"
                      required
                      placeholder="Введите email">
        </b-form-input>
      </b-form-group>

      <!-- пароль -->
      <b-form-group label="Ваш пароль:" label-for="password">
        <b-form-input id="password"
                      type="password"
                      v-model="form.password"
                      required
                      placeholder="Введите пароль">
        </b-form-input>
      </b-form-group>

      <!-- подтверждение пароля -->
      <b-form-group label="Подтверждение пароля:" label-for="password_confirm">
        <b-form-input id="password_confirm"
                      type="password"
                      v-model="form.password_confirmation"
                      required
                      placeholder="Подтвердите пароль">
        </b-form-input>
      </b-form-group>

      <br>
      <b-form-group style="text-align:center;margin-top:-15px">
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
    closeAndReturn() {
 		  window.history.back();
  	},
    onSubmit (evt) {
      evt.preventDefault();
      post('/register', 
      {
        "name": this.form.name,
        "email": this.form.email,
        "password": this.form.password,
        "password_confirmation": this.form.password_confirmation
      }
      ).then((res) => {
        console.log(res)
        window.location="home";
		  }).catch((err) => {

      console.log(err.response.data);
      
      // получаю ошибки
			if(err.response.status === 422) {
        this.$root.alert.show=true;

        if (err.response.data.errors.name)
          this.$root.alert.msg=err.response.data.errors.name[0];

        if (err.response.data.errors.email)
          this.$root.alert.msg=err.response.data.errors.email[0];

        if (err.response.data.errors.password)
          this.$root.alert.msg=err.response.data.errors.password[0];        
			}
  	});
    }
  }
}
</script>
