<template>
<b-form inline>
<b-form-group label="Год выпуска:">
       <b-form-input placeholder="Введите год" type="number" v-model="release_date" class="mb-2 mr-sm-2 mb-sm-2" style="width:130px" :state="checkYear"></b-form-input>
    </b-form-group>

    <b-form-group label="Положение руля:">
        <b-form-select v-model="selected.helm_position" class="mb-2 mr-sm-2 mb-sm-2">
           <option :value="null">-- Выберите положение руля --</option>
           <option v-for="(index, item) in helm_position" :value="item.value" :key="index">{{item.text}}</option>
        </b-form-select>
    </b-form-group>

    <b-form-group label="Пробег(км):">
       <b-form-input type="number" v-model="mileage" class="mb-2 mr-sm-2 mb-sm-2" style="width:115px"></b-form-input>
    </b-form-group>

     <b-form-group label="Тип двигателя:">
        <b-form-select v-model="selected.fuel_type" class="mb-2 mr-sm-2 mb-sm-2">
           <option v-for="(index, item) in fuel_type" :value="item.value" :key="index">{{item.text}}</option>
        </b-form-select>
    </b-form-group>

    <b-form-group label="Растаможен:">
        <b-form-select v-model="selected.car_customs" class="mb-2 mr-sm-2 mb-sm-2">
           <option :value="1">Да</option>
           <option :value="0">Нет</option>
        </b-form-select>
    </b-form-group>

  </b-form>
</template>

<script>
export default {
  computed: {
    checkYear () {
      return (this.release_date.length > 3) && (this.release_date > 1930) ? true : null
    }
  },
  data () {
    return 	{

       selected: {
          type_transport: null,
          carmark: null,
          model: null,
          helm_position: null,
          fuel_type: 0,
          car_customs: 1
      },

      release_date: "",
      mileage: 0,

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
        ]
		}
	},
  created() {
  },
  components: {},
  methods: {
  }
}
</script>
