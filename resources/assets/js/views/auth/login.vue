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
    <h3 class="form_title">вход</h3>    
    <hr>
    <b-form @submit="onSubmit" style="width:99%">
      <b-form-group label="Email адрес:" label-for="email">
        <b-form-input id="email"
                      type="email"
                      v-model="form.email"
                      required
                      placeholder="Введите email">
        </b-form-input>
      </b-form-group>
      <b-form-group label="Ваш пароль:" label-for="password">
        <b-form-input id="password"
                      type="password"
                      v-model="form.password"
                      required
                      placeholder="Введите пароль">
        </b-form-input>
      </b-form-group>
      <b-form-group>
        <b-form-checkbox-group v-model="form.checked">
          <b-form-checkbox value="me">запомнить меня</b-form-checkbox>
        </b-form-checkbox-group>
      </b-form-group>
      <b-form-group style="text-align:center">
          <b-button type="submit" variant="primary">Войти</b-button>
        <hr>
      </b-form-group>
      <b-form-group>
      <div style="text-align:center;margin-top:-20px">        
        Забыли пароль?&nbsp;<b-link style="color:grey;font-weight:bold" href="/password/reset"><br>Восстановить вход</b-link>
        <br>
        Ещё не зарегистрированы?&nbsp;<b-link style="color:grey;font-weight:bold" href="/register"><br>Регистрация</b-link>                        
      </div>
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
      form: {
        email: '',
        password: '',
        checked: true
      },
    }
  },
  methods: {
    closeAndReturn() {
 			  window.history.back();
  	},
    onSubmit (evt) {
      evt.preventDefault();
      post('/login', { "email": this.form.email, "password": this.form.password }
      ).then((res) => {
        window.location='/home';
      }).catch((err) => {
        this.$root.alert.show=true;
        //this.alert.msg=err.response.data.message;
        this.$root.alert.msg="Почта или пароль указаны неверно";
        console.log(err.response.data);
    });
    },
    register(evt) {
      window.location='/register';
    }
  }
}
</script>