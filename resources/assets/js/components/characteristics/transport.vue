<template>
  <div>
    <b-form inline>
    <b-form-group label="Расположение руля:" style="border:1px grey">
        <b-form-select v-model="selected_helm_position" class="mb-2 mr-sm-2 mb-sm-0" style="width:310px">
           <option v-for="item in helm_position" :value="item.value">{{item.text}}</option>
        </b-form-select>
    </b-form-group>

     <b-form-group label="Тип двигателя:" style="border:1px grey">
        <b-form-select v-model="selected_fuel_type" class="mb-2 mr-sm-2 mb-sm-0" style="width:310px">
           <option v-for="item in fuel_type" :value="item.value">{{item.text}}</option>
        </b-form-select>
    </b-form-group>
    </b-form>

  </div>
</template>

<script>
export default {
  data () {
    return 	{
       helm_position: 
        [
          { value: 0, text: 'Справа' },
          { value: 1, text: 'Слева' }
        ],
        fuel_type: 
        [
          { value: 0, text: 'Бензин' },
          { value: 1, text: 'Дизель' },
          { value: 2, text: 'Газ-бензин' },
          { value: 3, text: 'Газ' },
          { value: 4, text: 'Гибрид' },
          { value: 5, text: 'Электричество' }
        ],
        selected_helm_position: 0,
        selected_fuel_type: 0,
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
