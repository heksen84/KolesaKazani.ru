<template>
    <b-form inline style="margin-top:-18px;">
    <b-form-group label="Вид транспорта:">
        <b-form-select v-model="selected.type_transport" class="mb-2 mr-sm-2 mb-sm-2"  @change="selectTransportType">
           <option v-for="item in type_transport" :value="item.value" :key="item.value">{{item.text}}</option>
        </b-form-select>
    </b-form-group>

    <b-form-group label="Марка автомобиля:" v-if="carmark && selected.type_transport==1">
        <b-form-select v-model="selected.carmark" class="mb-2 mr-sm-2 mb-sm-2" @change="selectMark">
           <option :value="null">-- Выберите марку автомобиля --</option>
           <option v-for="item in carmark" :value="item.id_car_mark" :key="item.id_car_mark">{{item.name}}</option>
        </b-form-select>
    </b-form-group>

    <b-form-group label="Модель:" v-if="selected.carmark!=null && selected.type_transport==1">
    <!--<b-form-group label="Модель:" v-if="selected.type_transport==1">-->
        <b-form-select v-model="selected.model" class="mb-2 mr-sm-2 mb-sm-2" @change="selectModel">
           <option :value="null">-- Выберите модель --</option>
           <option v-for="item in models" :value="item.id_car_model" :key="item.id_car_model">{{item.name}}</option>
        </b-form-select>
    </b-form-group>

    <!-- общий компонент для транспорта -->
    <com-transport v-if="[1,2,5].indexOf(selected.type_transport) !== -1 && selected.type_transport!=null && this.$store.state.show_common_transport"></com-transport>
    
    </b-form>
</template>

<script>
import { post, get, interceptors } from '../../helpers/api'
import comtransport from './common/com_transport.vue';

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
        transport_chars:null,

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
    this.transport_chars = this.$root.advert_data;
  },

  components: {},
  methods: {

    /*
    -----------------------------------
      Вид транспорта
    -----------------------------------*/
    selectTransportType(transport_id) {

      /*if (transport_id)
        this.$store.commit("showOtherFields");
      else
        this.$store.commit("hideOtherFields");*/

      this.$store.commit("ShowCommonTransport", false);
      this.$store.commit("ShowOtherFields", false);

      this.transport_chars.transport_type = transport_id;

      switch(transport_id) {
        case 1: { 
          // автомобили
          this.carmark=[];

          get('/getCarsMarks').then((res) => {
            this.carmark = res.data;
            console.log(this.this.carmark);
          }).catch((err) => {});
          break;
       }
      }
    },

    // ------------------------
    // change марки
    // ------------------------
    selectMark(mark_id) {
      
      this.$store.commit("ShowCommonTransport", false);
      this.$store.commit("ShowOtherFields", false);

      this.transport_chars.mark_id = mark_id;

      console.log(this.transport_chars.mark_id);
      
      get('/getCarsModels?mark_id='+mark_id).then((res) => {

        this.models=[];
        this.models = res.data;
        this.selected.model=null;        
        
        }).catch((err) => 
        {
          console.log(err);
        });
    },

    // change модели
    selectModel(model_id) {

      this.transport_chars.model_id = model_id;
      console.log(this.transport_chars.model_id);
      this.$store.commit("ShowCommonTransport", true);
      this.$store.commit("ShowOtherFields", true);
      //this.$store.commit("hideOtherFields");

    }
  },
  components: { "com-transport": comtransport }
}
</script>
