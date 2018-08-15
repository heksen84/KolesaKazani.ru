<template>
  <b-container fluid>
    <b-row>
        <b-col style="text-align:center" v-show="auth">
          <div class="auth_button" id="button_login" style="width:160px" @click="login">мои объявления</div>
        </b-col>

        <b-col style="text-align:center" v-show="!auth">
          <div class="auth_button" id="button_login" @click="login">Вход</div>
          <div class="auth_button" id="button_reg" @click="register">Регистрация</div>
        </b-col>
    </b-row>
    <b-row>
        <b-col cols="12" sm="12" md="12" lg="3" xl="3" style="text-align:center">
          <div id="logo_block">
            <div style="font-size:28px;letter-spacing:4px;font-weight:450;padding:6px;margin-top:-9px">FlyMart24<span style="position:relative;top:-15px;left:-3px;font-size:12px;display:none">&reg</span></div>
            <div style="font-size:18px;color:yellow;margin-top:-12px;letter-spacing:2px;">сайт объявлений</div>
          </div>
        </b-col>
        <b-col cols="12" sm="12" md="12" lg="6" xl="6" style="text-align:center">
          <input type="text" id="search_string" placeholder="Что ищем?"/>
          <button id="button_search" @click="search">найти</button>
        </b-col>
        <b-col cols="12" sm="12" md="12" lg="3" xl="3" style="text-align:center">
        <a href="/new"><div id="new_advert_block"><b>+&nbsp;</b>добавить объявление</div></a>
        </b-col>
    </b-row>

    <b-row id="categories_row"></b-row>

    <!-- категории -->
    <b-row v-for="i in Math.ceil(Object.keys(items).length / 4)" v-bind:key=i>
      <b-col cols="12" sm="12" md="12" lg="3" xl="3" v-for="item in items.slice((i - 1) * 4, i * 4)"  v-bind:key=item.id>
        <a :href="item.link">
        <div class="category_item">{{ item.name }}<span style="font-size:13px;color:rgb(155,255,155);float:right;margin-top:3px" :id="item.id">| {{ 555 }} </span></div></a>
      </b-col>
    </b-row>

</b-container>
</template>
<script>
import { post, get, interceptors } from './../helpers/api'
export default {
  props: ["items", "auth", "count"],
  data () {
    return {
    }
  },
  created() {
   // alert(this.count);
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
    }
  }
}
</script>
