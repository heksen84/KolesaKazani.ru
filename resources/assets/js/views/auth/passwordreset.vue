<template>
  <b-container fluid class="mycontainer">
    <b-row>
    <!-- ALERT -->    
    <b-col cols="12" class="alert" v-if="$root.alert.show">    
      <b-alert variant="danger" show style="margin:auto;width:300px">{{ $root.alert.msg }}</b-alert>
    </b-col>

    <!-- ФОРМА -->
    <b-col cols="12" sm="12" md="12" lg="4" xl="4" class="standart_window">    
    <div class="close_button" title="Закрыть страницу" @click="closeAndReturn">X</div>
    <h4 style="text-align:center;margin-top:12px;color:grey">восстановление пароля</h4>    
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
    sendEmail (evt) {
      evt.preventDefault();
      post('/password/email', { "email": this.form.email }
      ).then((res) => {
        window.location='/home';
      }).catch((err) => {
      console.log(err.response.data);
    });
    }
  }
}
</script>
