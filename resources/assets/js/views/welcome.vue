<template>
  <b-container fluid>
    <b-row>
        <b-col id="welcome_menu" v-show="auth" inline>

          <div class="auth_button" id="button_login" style="width:160px;text-align:center;position:relative;top:3px" @click="login">мои объявления</div>

          <!-- кнопка выбора региона -->
          <b-button size="sm" variant="primary" @click="locationDialog=true">Весь казахстан</b-button>
          
          <!-- окно выбоа региона и местоположения -->
          <b-modal v-model="locationDialog" size="lg" style="text-align:center;color:grey" hide-footer :title="locationDialogTitle">
            <button style="color:black;display:inline-block" v-for="i in regions" @click="selectRegion(i.region_id)">{{i.name}}
            </button>
          </b-modal>
        </b-col>

        <b-col style="text-align:center" v-show="!auth">
          <div class="auth_button" id="button_login" style="margin-top:3px" @click="login">Вход</div>
          <div class="auth_button" id="button_reg" style="margin-top:3px" @click="register">Регистрация</div>
        </b-col>
    </b-row>

    <b-row>
        <b-col cols="12" sm="12" md="12" lg="3" xl="3" style="text-align:center">
          <div id="logo_block">
            <div style="font-size:29px;letter-spacing:4px;font-weight:450;padding:7px;margin-top:-8px">АксуМаркет<span style="position:relative;top:-15px;left:-3px;font-size:12px;display:none">&reg</span></div>
            <div style="font-size:18px;color:yellow;margin-top:-14px;letter-spacing:2px;">сайт объявлений</div>
          </div>
        </b-col>
        <b-col cols="12" sm="12" md="12" lg="6" xl="6" style="text-align:center">
          <input type="text" id="search_string" placeholder="Поиск по сайту"/>
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
  props: ["items", "auth", "count", "regions"],
  data () {
    return {
      location: null,
      locationDialog: false,
      locationDialogTitle: "Выберите регион"
    }
  },
  created() {
  },
  methods: {
    login() {
      window.location='/login';
    },
    register() {
      window.location='/register';
    },
    search() {
      window.location='/search';
    },
    selectRegion(e) {
      this.regions=[];
      this.locationDialogTitle="Выберите расположение"
    }
  }
}
</script>
