<template>
  <div>
	<b-form-group label="Вид недвижимости:" label-for="categories" style="width:310px">
        <b-form-select v-model="selected_type" class="mb-3">
           <option v-for="item in type" :value="item.value">{{item.text}}</option>
        </b-form-select>
  </b-form-group>
  </div>
</template>

<script>
export default {
  data () {
    return 	{
        type: 
        [
          { value: 0, text: 'Легковой автомобиль' },
          { value: 1, text: 'Грузовой автомобиль' },
          { value: 2, text: 'Мототехника' },
          { value: 3, text: 'Спецтехника' },
          { value: 4, text: 'Ретро-автомобиль' },
          { value: 5, text: 'Водный транспорт' },
          { value: 6, text: 'Велосипед' },
          { value: 7, text: 'Воздушный транспорт' }
        ],
        selected_type: 0
		}
	},
  created() {
  },
  components: {},
  methods: {
    details(event) {
    }
  }
}
</script>
