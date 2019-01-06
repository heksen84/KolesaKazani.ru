<template>
<b-form inline>

<!-- INPUT -->
<b-form-group label="Год выпуска:">
       <b-form-input placeholder="Введите год" type="number" v-model="release_date" class="mb-2 mr-sm-2 mb-sm-2" style="width:130px" :formatter="SetReleaseDate" required></b-form-input>
    </b-form-group>

    <b-form-group label="Положение руля:">
        <b-form-select v-model="selected.helm_position" class="mb-2 mr-sm-2 mb-sm-2" @change="SetHelmPosition">
           <option :value="null">-- Выберите положение руля --</option>
           <option v-for="(item, index) in helm_position" :value="item.value" :key="index">{{item.text}}</option>
        </b-form-select>
    </b-form-group>


    <!-- INPUT -->
    <b-form-group label="Пробег(км):">
       <b-form-input type="number" v-model="mileage" placeholder="Введите пробег" class="mb-2 mr-sm-2 mb-sm-2" style="width:145px" :formatter="SetMileage" required></b-form-input>
    </b-form-group>

     <b-form-group label="Вид топлива:">
        <b-form-select v-model="selected.fuel_type" class="mb-2 mr-sm-2 mb-sm-2" @change="SetFuelType">
           <option v-for="(item, index) in fuel_type" :value="item.value" :key="index">{{item.text}}</option>
        </b-form-select>
    </b-form-group>

    <b-form-group label="Растаможен:">
        <b-form-select style="width:100px" v-model="selected.transport_customs" class="mb-2 mr-sm-2 mb-sm-2" @change="SetTransportCustoms">
           <option :value="1">Да</option>
           <option :value="0">Нет</option>
        </b-form-select>
    </b-form-group>

  </b-form>
</template>

<script>
export default {
  data () {
    return 	{

       selected: {
          type_transport: null,
          carmark: null,
          model: null,
          helm_position: null,
          fuel_type: 0,
          transport_customs: 1
      },

      release_date: null,
      mileage: null,

      helm_position: [
        { value: 0, text: 'Слева' },
        { value: 1, text: 'Справа' }
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

     this.transport_chars = this.$root.advert_data; // получаю ссылку на массив данных объявления
     
     // значения по умолчанию
     this.transport_chars.rule_position = 0;
     this.transport_chars.fuel_type = 0;
     this.transport_chars.customs = 0;
     this.transport_chars.release_date = 0;
     this.transport_chars.mileage = 0;
  },

  components: {},
  methods: {

     // положение руля
     SetHelmPosition(position_id) {
        this.transport_chars.rule_position = position_id;
     },

     // тип топлива
     SetFuelType(fuel_type) {
        this.transport_chars.fuel_type = fuel_type;
     },
     
     // растаможка
     SetTransportCustoms(customs_id) {
        this.transport_chars.customs = customs_id;
     },

     // год выпуска
     SetReleaseDate(date) {
        var d = new Date();
        if (date<0 || date>d.getFullYear()) return;
        this.transport_chars.release_date = date;
        return date;
     },

     // пробег
     SetMileage(mileage) {
        if (mileage<0 || mileage>10000000) return;
        this.transport_chars.mileage = mileage;
        return mileage;
     }
  }
}
</script>
