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
          <div style="font-size:20px;color:yellow;margin-top:-7px">доска объявлений г. Аксу</div>
        </div>
        </b-col>
        <b-col cols="12" sm="12" md="12" lg="6" xl="6" style="text-align:center">
          <input type="text" style="text-align:center;margin-top:25px;font-size:19px;padding:5px;width:80%;border:1px solid grey;border-radius:8px;color:rgb(50,50,50)" placeholder="Строка поиска"/>
          <button id="button_search" @click="search">найти</button>
        </b-col>
        <b-col cols="12" sm="12" md="12" lg="3" xl="3" style="text-align:center">
        <div id="new_advert_block" @click="createAdvert">
          <h3>разместить объявление</h3>
        </div>
        </b-col>
    </b-row>

    <b-row style="margin-top:50px"></b-row>
    <!-- категории -->
    <b-row v-for="i in Math.ceil(Object.keys(categories).length / 4)" v-bind:key=i>
      <b-col cols="12" sm="12" md="12" lg="3" xl="3" v-for="item in categories.slice((i - 1) * 4, i * 4)"  v-bind:key=item.id>
        <div class="category_item" @click="searchInCategory" :id="item.id">{{ item.name }}</div>
      </b-col>
    </b-row>

</b-container>
</template>

<script>
import { post, get, interceptors } from './../helpers/api'

export default {
  props: ["items"],
  data () {
    return {
      categories: []
    }
  },
  created() {

    alert(this.items);

    //alert("приветик!");

    /*this.categories={};
    get("/categories").then((res) => {
        this.categories=res.data;
        console.log(this.categories);
    }).catch((err) => {
      console.log(err.response.data);
      if(err.response.status === 422) {
      }
    });*/
  },
  methods: {
    login(event) {
      window.location='/login';
    },
    register(event) {
      window.location='/register';
    },
    search(event) {
      window.location='/search';
    },
    createAdvert(event) {
      window.location='/create';
    },
    searchInCategory(event) {
      window.location='/category/'+event.target.id;
    }
  }
}
</script>
