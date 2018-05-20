<template>
  <b-container fluid>
    <b-row>
        <b-col style="text-align:center">
          <div class="auth_button" id="button_login">Вход</div>
          <div class="auth_button" id="button_reg">Регистрация</div>
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
          <input type="text" style="text-align:center;margin-top:25px;font-size:18px;padding:5px;width:87%;border:1px solid grey;border-radius:8px;color:rgb(50,50,50)" placeholder="Строка поиска"></input>
          <button style="margin:3px;padding:7px;background:rgb(100,100,200);color:white;letter-spacing:2px;font-weight:bold;font-size:16px;border:1px solid white;border-radius:3px">найти</button>
        </b-col>
        <b-col cols="12" sm="12" md="12" lg="3" xl="3" style="text-align:center">
        <div id="new_advert_block">
          <h2>Разместить объявление</h2>
        </div>
        </b-col>
    </b-row>

    <!-- категории -->
    <b-row>
        <b-col v-for="(item, index) in items" :key="index" cols="12" sm="12" md="12" lg="4" xl="4" style="text-align:center">
            <div class="auth_button">{{ item.name }}</div>
        </b-col>
    </b-row>

</b-container>
</template>

<script>
const items = [
  { name: "транспорт"},
  { name: "недвижимость"},
  { name: "бытовая техника"},
  { name: "работа и бизнес"},
  { name: "для дома и дачи"},
  { name: "личные вещи"},
  { name: "животные"},
  { name: "хобби и отдых"},
  { name: "услуги"},
  { name: "другое"}
]

export default {
  data () {
    return {
      items: items
    }
  }
}
</script>
