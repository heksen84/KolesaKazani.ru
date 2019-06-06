<template>
  <b-container fluid class="mycontainer">
    <b-row>
      
    <!-- ALERT -->    
    <b-col cols="12" v-if="$root.alert.show">    
      <b-alert variant="danger" show class="alert">{{ $root.alert.msg }}</b-alert>
    </b-col>

    <!-- ФОРМА -->
    <b-col cols="12" sm="12" md="12" lg="4" xl="4" class="form">    
    <div class="close_button" title="Закрыть страницу" @click="closeAndReturn">X</div>
    <h1 class="form_title">восстановление доступа</h1>    
    <hr>
    <b-form style="width:99%" @submit="sendEmail">
      <b-form-group label="Email адрес:" label-for="email">
        <b-form-input id="email"
                      type="email"
                      v-model="form.email"
                      required
                      placeholder="Введите свой email">
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
  props:["email"],
  data () {
    return {
      form: {
        email: this.email
      }
    }
  },
  methods: {
    closeAndReturn() {
 			  window.history.back();
    },

    /*----------------------------------------------------
       Асинхронная функция. Походу надо ставить в очередь
      ----------------------------------------------------*/
    sendEmail (evt) {
      evt.preventDefault();
      post('/password/email', { "email": this.form.email }).then((res) => {
        alert("Инструкция по восстановлению пароля отправлена на указанную почту.");
        window.location="/"; 
      }).catch((err) => 
      {
        alert("Ошибка отправки");
        console.log(err.response.data);
      });
    }
  }
}
</script>
