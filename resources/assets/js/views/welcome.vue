<template>
  <b-container fluid>
    <b-row>
        <b-col cols="12" sm="12" md="2" lg="2" xl="2" style="text-align:center">
        <h1>АксуМаркет</h1>
        </b-col>
        <b-col cols="12" sm="12" md="8" lg="8" xl="8" style="text-align:center">Variable width content</b-col>
        <b-col cols="12" sm="12" md="2" lg="2" xl="2" style="text-align:center">
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
