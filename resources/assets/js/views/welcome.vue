<template>
  <b-container fluid>
    <b-row>
        <b-col style="text-align:center">
          <div class="auth_button" id="button_login" @click="login">Вход</div>
          <div class="auth_button" id="button_reg" @click="register">Регистрация</div>
        </b-col>
    </b-row>
    <b-row>
        <b-col cols="12" sm="12" md="12" lg="3" xl="3" style="text-align:center">
          <div id="logo_block">
          <div style="font-size:36px;text-decoration:underline">АксуМаркет</div>
          <div style="font-size:20px;color:yellow">доска объявлений г. Аксу</div>
        </div>
        </b-col>
        <b-col cols="12" sm="12" md="12" lg="6" xl="6" style="text-align:center">
          <input type="text" style="text-align:center;margin-top:25px;font-size:19px;padding:5px;width:80%;border:1px solid grey;border-radius:8px;color:rgb(50,50,50)" placeholder="Строка поиска"></input>
          <button style="margin:5px;padding:10px;background:rgb(100,100,200);color:white;letter-spacing:2px;font-weight:bold;font-size:16px;border:1px solid white;border-radius:5px">найти</button>
        </b-col>
        <b-col cols="12" sm="12" md="12" lg="3" xl="3" style="text-align:center">
        <div id="new_advert_block">
          <h2>Разместить объявление</h2>
        </div>
        </b-col>
    </b-row>

    <b-row style="margin-top:50px"></b-row>
    <!-- категории -->
    <b-row v-for="i in Math.ceil(Object.keys(categories).length / 4)" v-bind:key=i>
      <b-col cols="12" sm="12" md="12" lg="3" xl="3" v-for="item in categories.slice((i - 1) * 4, i * 4)" v-bind:key=item.name>
        <div class="category_item" v-on:click="redirect">{{ item.name }}</div>
      </b-col>
    </b-row>

</b-container>
</template>

<script>
import { post, get, interceptors } from './../helpers/api'

export default {
  data () {
    return {
      categories: []
    }
  },
  created() {
    this.categories={};
    get("/categories").then((res) => {
        this.categories=res.data;
        console.log(this.categories);
    }).catch((err) => {
      console.log(err.response.data);
      if(err.response.status === 422) {
      }
    });
  },
  methods: {
    login(event) {
      window.location='/login';
    },
    register(event) {
      window.location='/register';
    }
  }
}
</script>
