<template>
  <div>
    <b-form inline style="margin-top:-18px;">

    <b-form-group label="Вид транспорта:">
        <b-form-select v-model="selected.type_transport" class="mb-2 mr-sm-2 mb-sm-2"  @change="selectTransportType">
           <option v-for="item in type_transport" :value="item.value">{{item.text}}</option>
        </b-form-select>
    </b-form-group>


    <b-form-group label="Марка автомобиля:" v-if="carmark && selected.type_transport==1">
        <b-form-select v-model="selected.carmark" class="mb-2 mr-sm-2 mb-sm-2" @change="selectMark">
           <option :value="null">-- Выберите марку автомобиля --</option>
           <option v-for="item in carmark" :value="item.id_car_mark">{{item.name}}</option>
        </b-form-select>
    </b-form-group>


    <b-form-group label="Модель:" v-if="selected.carmark!=null && selected.type_transport==1">
        <b-form-select v-model="selected.model" class="mb-2 mr-sm-2 mb-sm-2">
           <option :value="null">-- Выберите модель --</option>
           <option v-for="item in models" :value="item.id_car_model">{{item.name}}</option>
        </b-form-select>
    </b-form-group>

<!--

    <b-form-group label="Год выпуска:" v-if="selected.carmark!=null && selected.type_transport==1">
       <b-form-input placeholder="Введите год" type="number" v-model="release_date" class="mb-2 mr-sm-2 mb-sm-2" style="width:130px" :state="checkYear"></b-form-input>
    </b-form-group>

    <b-form-group label="Положение руля:" v-if="selected.carmark!=null && selected.type_transport==1">
        <b-form-select v-model="selected.helm_position" class="mb-2 mr-sm-2 mb-sm-2">
           <option :value="null">-- Выберите положение руля --</option>
           <option v-for="item in helm_position" :value="item.value">{{item.text}}</option>
        </b-form-select>
    </b-form-group>

    <b-form-group label="Пробег(км):" v-if="selected.carmark!=null && selected.type_transport==1">
       <b-form-input type="number" v-model="mileage" class="mb-2 mr-sm-2 mb-sm-2" style="width:115px"></b-form-input>
    </b-form-group>

     <b-form-group label="Тип двигателя:" v-if="selected.carmark!=null && selected.type_transport==1">
        <b-form-select v-model="selected.fuel_type" class="mb-2 mr-sm-2 mb-sm-2">
           <option v-for="item in fuel_type" :value="item.value">{{item.text}}</option>
        </b-form-select>
    </b-form-group>


    <b-form-group label="Растаможен:" v-if="selected.carmark!=null && selected.type_transport==1">
        <b-form-select v-model="selected.car_customs" class="mb-2 mr-sm-2 mb-sm-2">
           <option :value="1">Да</option>
           <option :value="0">Нет</option>
        </b-form-select>
    </b-form-group>


  -->

    <!-- общий компонент для транспорта -->
    <com-transport v-if="[1,2,5].indexOf(selected.type_transport) !== -1 && selected.type_transport!=null"></com-transport>

  </b-form>

  </div>
</template>

<script>

import { post, get, interceptors } from '../../helpers/api'
import comtransport from './com_transport.vue';

export default {
  computed: {
    checkYear () {
      return (this.release_date.length > 3) && (this.release_date > 1930) ? true : null
    }
  },
  data () {
    return 	{
        type_transport: 
        [
          { value: null, text: '-- Выберите вид транспорта --' },
          { value: 1, text: 'Легковой автомобиль' },
          { value: 2, text: 'Грузовой автомобиль' },
          { value: 3, text: 'Мототехника' },
          { value: 4, text: 'Спецтехника' },
          { value: 5, text: 'Ретро-автомобиль' },
          { value: 6, text: 'Водный транспорт' },
          { value: 7, text: 'Велосипед' },
          { value: 8, text: 'Воздушный транспорт' }
        ],

        // марки автомобилей
        carmark:[],
        models:[],
        release_date: "",
        mileage: 0,
        
        selected: {
          type_transport: null,
          carmark: null,
          model: null,
          helm_position: null,
          fuel_type: 0,
          car_customs: 1
      }
		}
	},
  created() {
  },
  components: {},
  methods: {

    /*
    -----------------------------
      Вид транспорта
    -----------------------------*/
    selectTransportType(ttype) {
      switch(ttype) {
        case 1: {  // автомобили
          this.carmark=[];
          get('/getCarsMarks').then((res) => {
            this.carmark = res.data;
            console.log(this.this.carmark);
        }).catch((err) => {});
        break;
       }
      }
    },

    // change марки
    selectMark(markType) {
          get('/getCarsModels?mark_id='+markType).then((res) => {
            this.models=[];
            this.models = res.data;
            this.selected.model=null;
        }).catch((err) => {
          console.log(err);
        });
    },
  },
   components: { "com-transport": comtransport }
}
</script>
