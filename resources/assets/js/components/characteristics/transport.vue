<template>
  <div>
    <b-form inline style="margin-top:-12px;">


    <b-form-group label="Вид транспорта:">
        <b-form-select v-model="form.selected_type_transport" class="mb-2 mr-sm-2 mb-sm-2" style="width:298px" @change="selectTransportType">
           <option v-for="item in type_transport" :value="item.value">{{item.text}}</option>
        </b-form-select>
    </b-form-group>


    <b-form-group label="Марка автомобиля:" v-if="carmark && form.selected_type_transport==1">
        <b-form-select v-model="form.selected_carmark" class="mb-2 mr-sm-2 mb-sm-2" style="width:298px" @change="selectMark">
           <option :value="null">-- Выберите марку автомобиля --</option>
           <option v-for="item in carmark" :value="item.id_car_mark">{{item.name_rus}}</option>
        </b-form-select>
    </b-form-group>


    <b-form-group label="Модель:" v-if="carmark && form.selected_type_transport==1">
        <b-form-select v-model="form.selected_model" class="mb-2 mr-sm-2 mb-sm-2" style="width:298px">
           <option :value="null">-- Выберите модель --</option>
           <option v-for="item in models" :value="item.id_car_model">{{item.name_rus}}</option>
        </b-form-select>
    </b-form-group>

  <!--  <b-form-group label="Расположение руля:">
        <b-form-select v-model="selected_helm_position" class="mb-2 mr-sm-2 mb-sm-0" style="width:295px">
           <option v-for="item in helm_position" :value="item.value">{{item.text}}</option>
        </b-form-select>
    </b-form-group>

     <b-form-group label="Тип двигателя:" style="margin-top:8px">
        <b-form-select v-model="selected_fuel_type" class="mb-2 mr-sm-2 mb-sm-0" style="width:295px">
           <option v-for="item in fuel_type" :value="item.value">{{item.text}}</option>
        </b-form-select>
    </b-form-group>-->


    </b-form>
  </div>
</template>

<script>
import { post, get, interceptors } from '../../helpers/api'
export default {
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

        form: {
        selected_type_transport: null,
        selected_carmark: null,
        selected_model: null,
        selected_helm_position: 0,
        selected_fuel_type: 0
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
            this.form.selected_model=null;
        }).catch((err) => {
          console.log(err);
        });
    },
  }
}
</script>
