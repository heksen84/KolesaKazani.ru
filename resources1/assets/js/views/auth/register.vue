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
    <h1 class="form_title">регистрация</h1>
    <hr>
    <b-form @submit="onSubmit" style="width:99%">

      <!-- имя / логин -->
      <b-form-group label="Имя:" label-for="name">
        <b-form-input id="name"
                      type="text"
                      v-model="form.name"
                      required
                      placeholder="Ваше имя"
                      :state="name_state"
                      >
        </b-form-input>
      </b-form-group>

      <!-- email -->
      <b-form-group label="Email адрес:" label-for="email">
        <b-form-input id="email"
                      type="email"
                      v-model="form.email"
                      required
                      placeholder="Введите email"
                      :state="email_state"
                      >
        </b-form-input>
      </b-form-group>

      <!-- пароль -->
      <b-form-group label="Ваш пароль:" label-for="password">
        <b-form-input id="password"
                      type="password"
                      v-model="form.password"
                      required
                      placeholder="Введите пароль"
                      :state="password_state"
                      >
        </b-form-input>
      </b-form-group>

      <!-- подтверждение пароля -->
      <b-form-group label="Подтверждение пароля:" label-for="password_confirm">
        <b-form-input id="password_confirm"
                      type="password"
                      v-model="form.password_confirmation"
                      required
                      placeholder="Повторите пароль"
                      :state="confirm_password_state"
                      >
        </b-form-input>
      </b-form-group>

      <br>
      <b-form-group style="text-align:center;margin-top:-15px">
        <b-button type="submit" variant="primary">Продолжить</b-button>
      </b-form-group>
      <br>
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

      // состояния полей
      name_state: null,
      email_state: null,
      password_state: null,
      confirm_password_state: null,

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

      // сбрасываю состояния полей
      this.name_state=null,
      this.email_state=null,
      this.password_state=null,
      this.confirm_password_state=null,
      
      post('/register', {
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
      
      // -------------------------------
      // получаю ошибки
      // -------------------------------
			if(err.response.status === 422) {

        // показываю алерт
        this.$root.alert.show=true;

        // проверка имени
        if (err.response.data.errors.name) {
          this.$root.alert.msg=err.response.data.errors.name[0];
          this.name_state=false;
          return;
        }

        // проверка почты
        if (err.response.data.errors.email) {          
          this.$root.alert.msg=err.response.data.errors.email[0];
          this.email_state=false;
          return;
        }

        // проверка паролей
        var password = err.response.data.errors.password;
        if (password) {          
          this.$root.alert.msg=password[0];        
          if (password.length>1) 
            this.password_state=false;
          else
            this.confirm_password_state=false;
          return;
        }

			}
  	});
    }
  }
}
</script>
