<template>
  <b-container fluid>
    <b-row>
        <b-col style="text-align:center">
        Вход
        </b-col>
    </b-row>
    <b-row>
        <b-col cols="12" sm="12" md="12" lg="2" xl="2" style="text-align:center">
          <div style="font-size:36px;margin-top:10px;text-decoration:underline">АксуМаркет</div>
          <div style="font-size:18px">доска объявлений</div>
        </b-col>
        <b-col cols="12" sm="12" md="12" lg="8" xl="8" style="text-align:center">
          <input type="text" style="margin-top:35px;font-size:22px;width:70%"></input>
          <button>найти</button>
        </b-col>
        <b-col cols="12" sm="12" md="12" lg="2" xl="2" style="text-align:center">
        <h2>Разместить объявление</h2>
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
