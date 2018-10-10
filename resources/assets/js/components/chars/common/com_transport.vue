<template>
<b-form inline>

<!--
   <NumberInputSpinner
    :min="0"
    :max="10"
    :integerOnly="true"
    v-model="mileage"
  />-->
  
<!-- INPUT -->
<b-form-group label="Год выпуска:">
       <b-form-input placeholder="Введите год" type="number" v-model="release_date" class="mb-2 mr-sm-2 mb-sm-2" style="width:130px" :formatter="SetReleaseDate" required></b-form-input>
    </b-form-group>

    <b-form-group label="Положение руля:">
        <b-form-select v-model="selected.helm_position" class="mb-2 mr-sm-2 mb-sm-2" @change="SetHelmPosition">
           <option :value="null">-- Выберите положение руля --</option>
           <option v-for="item in helm_position" :value="item.value">{{item.text}}</option>
        </b-form-select>
    </b-form-group>


    <!-- INPUT -->
    <b-form-group label="Пробег(км):">
       <b-form-input type="number" v-model="mileage" class="mb-2 mr-sm-2 mb-sm-2" style="width:115px" :formatter="SetMileage" required></b-form-input>
    </b-form-group>

     <b-form-group label="Тип двигателя:">
        <b-form-select v-model="selected.fuel_type" class="mb-2 mr-sm-2 mb-sm-2" @change="SetFuelType">
           <option v-for="item in fuel_type" :value="item.value">{{item.text}}</option>
        </b-form-select>
    </b-form-group>

    <b-form-group label="Растаможен:">
        <b-form-select v-model="selected.transport_customs" class="mb-2 mr-sm-2 mb-sm-2" @change="SetTransportCustoms">
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

       selected: 
       {
          type_transport: null,
          carmark: null,
          model: null,
          helm_position: null,
          fuel_type: 0,
          transport_customs: 1
      },

      release_date: null,
      mileage: 0,

      helm_position: [
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
  
  created() 
  {
     this.transport_chars = this.$root.advert_data;
  },

  components: {},
  methods: {

     // положение руля
     SetHelmPosition(positon_id) {
  
        this.transport_chars.rule_position = positon_id;
        //console.log(this.transport_chars.rule_position);

     },

     // тип топлива
     SetFuelType(fuel_type) {
      
        this.transport_chars.fuel_type = fuel_type;
        //console.log(this.transport_chars.fuel_type );

     },
     
     // растаможка
     SetTransportCustoms(customs_id) {

        this.transport_chars.customs = customs_id;
        //console.log(this.transport_chars.customs);

     },

     // год выпуска
     SetReleaseDate(date) {

      if (date<0) return 0;

      this.transport_chars.release_date = date;
      //console.log(this.transport_chars.release_date);

      return date;
     },

     // пробег
     SetMileage(mileage) {

      if (mileage<0) return 0;

      this.transport_chars.mileage = mileage;
      //console.log(this.transport_chars.mileage);

      return mileage;
     }

  }
}
</script>
