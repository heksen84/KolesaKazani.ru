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
          { value: 1, text: 'Дом' }
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
