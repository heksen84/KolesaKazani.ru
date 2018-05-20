<template>
  <b-container fluid>
    <b-row>
        <b-col style="text-align:center;padding:5px">
        Вход
        </b-col>
    </b-row>
    <b-row>
        <b-col cols="12" sm="12" md="12" lg="3" xl="3" style="text-align:center">
          <div id="logo_block">
          <div style="font-size:36px;margin-top:10px;text-decoration:underline">АксуМаркет</div>
          <div style="font-size:20px;color:yellow">доска объявлений</div>
        </div>
        </b-col>
        <b-col cols="12" sm="12" md="12" lg="6" xl="6" style="text-align:center">
          <input type="text" style="text-align:center;margin-top:28px;font-size:20px;padding:5px;width:91%;border:none;border-radius:10px" placeholder="Строка поиска"></input>
          <button>найти</button>
        </b-col>
        <b-col cols="12" sm="12" md="12" lg="3" xl="3" style="text-align:center">
        <div id="new_advert_block">
          <h2>Разместить объявление</h2>
      </div>
        </b-col>
    </b-row>
</b-container>
</template>

<script>
const items = [
  { isActive: true, age: 40, first_name: 'Dickerson', last_name: 'Macdonald' },
  { isActive: false, age: 21, first_name: 'Larsen', last_name: 'Shaw' },
  { isActive: false, age: 89, first_name: 'Geneva', last_name: 'Wilson' },
  { isActive: true, age: 38, first_name: 'Jami', last_name: 'Carney' }
]

export default {
  data () {
    return {
      items: items
    }
  }
}
</script>
