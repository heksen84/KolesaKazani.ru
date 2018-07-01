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
          { value: 0, text: 'Квартира' },
          { value: 1, text: 'Комната' },
          { value: 2, text: 'Дом, дача, коттедж' },
          { value: 3, text: 'Земельный участок' },
          { value: 5, text: 'Гараж или машиноместо' },
          { value: 6, text: 'Коммерческая недвижимость' },
          { value: 7, text: 'Недвижимость за рубежом' }
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
