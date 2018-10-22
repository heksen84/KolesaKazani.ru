<template>
  <b-container fluid class="mycontainer">
    <b-row>
    <b-col cols="12" sm="12" md="12" lg="4" xl="4" class="standart_window">    
    <div class="close_button" title="Закрыть страницу" @click="closeAndReturn">X</div>
    <h3 style="text-align:center;margin-top:10px;color:grey">восстановление пароля</h3>    
    <hr>
    <b-form @submit="onSubmit" style="width:99%">
      <b-form-group label="Email адрес:" label-for="email">
        <b-form-input id="email"
                      type="email"
                      v-model="form.email"
                      required
                      placeholder="Введи email">
        </b-form-input>
      </b-form-group>
      </b-form-group>
      <b-form-group>
      </b-form-group>
      <b-form-group style="text-align:center">
        <b-button type="submit" variant="primary">Восстановить</b-button>
      </b-form-group>
      <b-form-group>
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
        email: ''
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
      console.log(err.response.data);
    });
    }
  }
}
</script>
