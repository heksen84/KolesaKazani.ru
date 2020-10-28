<template>
<div>         
        <div class="row">        
          <div class="col-auto form-group">
            <label for="transport_type">Подкатегория:</label>
              <select id="transport_type" class="form-control" v-model="selected.type_transport" @change="selectTransportType">                          
                <option value="null" :key="null">-- Выберите подкатегорию --</option>
                <option v-for="item in type_transport" :value="item.id" :key="item.id">{{ item.name }}</option>
              </select>
          </div>                

          <div class="col-auto form-group" v-if="selected.type_transport==1 && carmarkLoaded">          
            <label for="mark_type">Марка автомобиля:</label>
              <select id="mark_type" class="form-control" v-model="selected.carmark" @change="selectMark">
                <option :value="null">-- Выберите марку --</option>
                <option v-for="item in carmark" :value="item.id_car_mark" :key="item.id_car_mark">{{ item.name }}</option>
              </select>          
          </div>

          <div class="col-auto form-group" v-if="selected.carmark!=null && selected.type_transport==1">
              <label for="mark_type">Модель:</label>
                <select id="mark_type" class="form-control" v-model="selected.model" @change="selectModel">                          
                  <option :value="null">-- Выберите модель --</option>
                  <option v-for="item in models" :value="item.id_car_model" :key="item.id_car_model">{{ item.name }}</option>
                </select>        
            </div>

          </div>      

          <div class="row">                        
            <div class="col-auto form-group" v-if="getComTransport && selected.type_transport!=3">
              <label for="helm_position">Положение руля:</label>
                <select id="helm_position" class="form-control" v-model="selected.helm_position" @change="SetHelmPosition">                                        
                  <option :value="null">-- Выберите положение руля --</option>
                  <option v-for="(item, index) in helm_position" :value="item.value" :key="index">{{ item.text }}</option>
                </select>
            </div>
          </div>

          <div class="row" v-if="getComTransport && selected.helm_position!=null">      
            <div class="col-auto form-group" >
              <label for="car_year">Год выпуска:</label>
                <superInput type="number" v-model="release_date" maxlength="4" id="car_year" @input="SetReleaseDate"></superInput>
            </div>
            <div class="col-auto form-group">
              <label for="car_mileage">Пробег(км):</label>
                <superInput type="number" v-model="mileage" maxlength="7" id="car_mileage" @input="SetMileage"></superInput>
            </div>
          
            <div class="col-auto form-group">
              <label for="fuel_type">Вид топлива:</label>
                <select id="fuel_type" class="form-control" v-model="selected.fuel_type" @change="SetFuelType">
                  <option :value="null">---</option>
                  <option v-for="(item, index) in fuel_type" :value="item.value" :key="index">{{ item.text }}</option>
                </select>        
            </div>

            <div class="col-auto form-group" v-if="getComTransport">
              <label for="car_customs">Растоможен:</label>
                <select id="car_customs" class="form-control" v-model="selected.car_customs" @change="SetTransportCustoms">
                  <option :value="null">---</option>
                  <option :value="1">Да</option>
                  <option :value="0">Нет</option>
                </select>
            </div>
          </div>
      </div>    
</template>

<script>

import { post, get, interceptors } from '../../../helpers/api'
import superInput from "../components/superInput.vue"

export default {

  components: {
    superInput
  },

  data () {
    return 	{
        
        type_transport: [],

        // марки автомобилей
        carmark: [],
        models: [],
        carmarkLoaded: false,
        transport_chars: null,

        selected: {
          type_transport: null,
          carmark: null,
          model: null,
          helm_position: null,
          fuel_type: null,
          car_customs: null
        },

        release_date: null,
        mileage: null,

        helm_position: [
          { value: 0, text: 'Слева' },
          { value: 1, text: 'Справа' }
        ],
        
        fuel_type: [
          { value: 0, text: 'Бензин' },
          { value: 1, text: 'Дизель' },
          { value: 2, text: 'Газ-бензин' },
          { value: 3, text: 'Газ' },
          { value: 4, text: 'Гибрид' },
          { value: 5, text: 'Электричество' }
        ]

		  }
	},

  // компонент создан
  created() {

    this.transport_chars = this.$root.advert_data;
    
    // значения по умолчанию    
    this.transport_chars.rule_position   = 0;
    this.transport_chars.fuel_type       = 0;
    this.transport_chars.customs         = 1;
    this.transport_chars.release_date    = null;
    this.transport_chars.mileage         = null;

    get("api/getSubCategoryNamesById?id=1").then((res) => {		 
        this.type_transport = res.data;
        console.log(res.data)
      }).catch((err) => {        
        console.log(err)
    });

  },
  
  computed: {
    
    // категории транспорта
    getComTransport() { 
      return [1,2,3,5].indexOf(this.selected.type_transport) != -1 && this.selected.type_transport!=null && this.$store.state.show_common_transport;      
    }

  },
  
  methods: {

    // сброс дополнительных полей
    resetFields() {
      this.selected.carmark = null;
      this.selected.model = null
      this.selected.helm_position = null;
      this.selected.fuel_type = null
      this.selected.car_customs = null;
      this.release_date =  null,
      this.mileage = null      
      this.transport_chars.rule_position = null;             
      this.transport_chars.fuel_type = null;     
      this.transport_chars.release_date = null;     
      this.transport_chars.mileage = null;     
      this.transport_chars.customs = null;
    },
    
    /*
    -----------------------------------
      Вид транспорта
    -----------------------------------*/
    selectTransportType() {

      console.log("Тип транспорта: "+this.selected.type_transport)

      this.transport_chars.adv_subcategory = this.selected.type_transport; // inner_id

      this.$store.commit("ResetField", "price");      
      this.$store.commit("SetInfoLabelDescription", "default");       
            
      this.resetFields();
      
      if (this.selected.type_transport==null) 
      {
        this.$store.commit("ShowCommonTransport", false);
        this.$store.commit("ShowFinalFields", false);               
      }      
      else 
      {
        this.$store.commit("ShowCommonTransport", true);
        this.$store.commit("ShowFinalFields", true);       
      }

      this.transport_chars.transport_type = this.selected.type_transport;

      this.$store.commit("SetInfoLabelDescription", "Дополнительно");      
      this.$store.commit("ShowFinalFields", false);                                                            
                
      switch(this.selected.type_transport) {
                
        // легковой транспорт
        case 1: {
          
          this.$store.commit("ShowCommonTransport", false);                    
          this.carmark=[];
                      
          // запрос: получить марки автомобилей
          get("api/getCarsMarks").then((res) => {            
            this.carmark = res.data;
            this.carmarkLoaded = true;
          }).catch((err) => { 
            console.log(err); 
          });

          break;
       }

      // грузовой транспорт
      case 2: {            
          break;
       }

      // мототехника
      case 3: {
          this.$store.commit("ShowFinalFields", true);                                                                          
          break;
       }

      // спецтехника
      case 4: {            
          this.$store.commit("ShowFinalFields", true);                                                              
          break;
       }

       // ретро авто
      case 5: {            
          break;
       }
      
      // водный транспорт
      case 6: {            
          this.$store.commit("ShowFinalFields", true);                                                                        
          break;
       }

      // велосипеды
      case 7: {            
          this.$store.commit("ShowFinalFields", true);                                                                             
          break;
       }

      // воздушный транспорт
      case 8: {            
          this.$store.commit("ShowFinalFields", true);                                                                                 
          break;
        }


      // запчасти
      case 74: {            
          this.$store.commit("ShowFinalFields", true);                                                                                 
          break;
        }
             
      }
    },

    // ------------------------------------------------
    // change марки
    // ------------------------------------------------
    selectMark() {
      
      this.$store.commit("ShowCommonTransport", false);
      this.$store.commit("ShowFinalFields", false);

      this.transport_chars.mark_id = this.selected.carmark;

      console.log(this.selected.carmark);
      
      // запрос
      get("api/getCarsModels?mark_id="+this.selected.carmark).then((res) => {

        this.models=[];
        this.models = res.data;
        this.selected.model=null;        
        
      }).catch((err) => {
          console.log(err);
      });
    },

    // ---------------------------
    // change модели
    // ---------------------------
    selectModel() {
      
      // сброс полей, что после
      this.selected.helm_position=null;
      this.release_date=null;
      this.mileage=null;
      this.selected.fuel_type=null;
      this.selected.car_customs=null;
      this.transport_chars.model_id = this.selected.model;      
      this.$store.commit("ShowCommonTransport", true);    
      
      console.log(this.transport_chars.model_id);
    },

    checkForFinalFields() {      

      if (this.selected.fuel_type!=null && this.selected.car_customs!=null && this.selected.helm_position!=null)
        this.$store.commit("ShowFinalFields", true);
      else
        this.$store.commit("ShowFinalFields", false);
        this.$store.commit("SetRequiredInfo", true);                                                              

     },

     // ---------------------------
     // положение руля
     // ---------------------------
     SetHelmPosition() {
        this.transport_chars.rule_position = this.selected.helm_position;
        this.checkForFinalFields()
     },

     // ---------------------------
     // тип топлива
     // ---------------------------
     SetFuelType() {
        this.transport_chars.fuel_type = this.selected.fuel_type;
        this.checkForFinalFields()
     },          

     // год выпуска
     SetReleaseDate() {      
        this.transport_chars.release_date = this.release_date;
     },

     // пробег
     SetMileage() {        
        this.transport_chars.mileage = this.mileage;
     },

     // ---------------------------
     // растаможка
     // ---------------------------
     SetTransportCustoms() {
        this.transport_chars.customs = this.selected.car_customs;
        this.checkForFinalFields()
     }
  },
}
</script>