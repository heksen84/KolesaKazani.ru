<template>
<span>  
    <!--<div style="width:100%;margin-bottom:10px;text-decoration:underline" v-if="[0,1,2,4].indexOf(this.selected.type_transport) != -1 && this.selected.type_transport!=null">Характеристики:</div>-->
     <!-- <div class="form-row" style="width:260px">-->
        
        <div class="row">        
          <div class="col-md-5 form-group">
            <label for="transport_type">Вид транспорта:</label>
              <select id="transport_type" class="form-control" v-model="selected.type_transport" @change="selectTransportType">                          
                <option v-for="item in type_transport" :value="item.value" :key="item.value">{{ item.text }}</option>
              </select>
          </div>        
          <div class="col-md-6 form-group" v-if="selected.type_transport==0 && carmarkLoaded">          
            <label for="mark_type">Марка автомобиля:</label>
              <select id="mark_type" class="form-control" v-model="selected.carmark" @change="selectMark">
                <option :value="null">-- Выберите марку --</option>
                <option v-for="item in carmark" :value="item.id_car_mark" :key="item.id_car_mark">{{ item.name }}</option>
              </select>          
            </div>
          </div>

          <div class="row" v-if="selected.carmark!=null && selected.type_transport==0">
            <div class="col-md-5 form-group">
              <label for="mark_type">Модель:</label>
                <select id="mark_type" class="form-control" v-model="selected.model" @change="selectModel">                          
                  <option :value="null">-- Выберите модель --</option>
                  <option v-for="item in models" :value="item.id_car_model" :key="item.id_car_model">{{ item.name }}</option>
                </select>        
            </div>

            <div class="col-md-5 form-group" v-if="getComTransport && selected.type_transport!=2">
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
                <input id="car_year" class="form-control" style="width:120px"/>
            </div>
            <div class="col-auto form-group">
              <label for="car_mileage">Пробег(км):</label>
                <input id="car_mileage" class="form-control" type="number" v-model="mileage" style="width:145px" :formatter="SetMileage" required/>
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
          
      </span>    
  <!--</div>-->
<!--  <div class="form-inline" v-if="$store.state.deal_selected">
    <div style="width:100%;margin-bottom:10px;text-decoration:underline" v-if="[0,1,2,4].indexOf(this.selected.type_transport) != -1 && this.selected.type_transport!=null">Характеристики:</div>
    <b-form-group label="Вид транспорта:">
        <b-form-select v-model="selected.type_transport" class="mb-2 mr-sm-2 mb-sm-2"  @change="selectTransportType">
           <option v-for="item in type_transport" :value="item.value" :key="item.value">{{item.text}}</option>
        </b-form-select>
    </b-form-group>

    <b-form-group label="Марка автомобиля:" v-if="carmark && selected.type_transport==0">
        <b-form-select v-model="selected.carmark" class="mb-2 mr-sm-2 mb-sm-2" @change="selectMark">
           <option :value="null">-- Выберите марку автомобиля --</option>
           <option v-for="item in carmark" :value="item.id_car_mark" :key="item.id_car_mark">{{item.name}}</option>
        </b-form-select>
    </b-form-group>

    <b-form-group label="Модель:" v-if="selected.carmark!=null && selected.type_transport==0">
        <b-form-select v-model="selected.model" class="mb-2 mr-sm-2 mb-sm-2" @change="selectModel">
           <option :value="null">-- Выберите модель --</option>
           <option v-for="item in models" :value="item.id_car_model" :key="item.id_car_model">{{item.name}}</option>
        </b-form-select>
    </b-form-group>
  
   <b-form-group label="Год выпуска:" v-if="getComTransport">
       <b-form-input placeholder="Введите год" type="number" v-model="release_date" class="mb-2 mr-sm-2 mb-sm-2" style="width:130px" :formatter="SetReleaseDate" required></b-form-input>
   </b-form-group>

    <b-form-group label="Положение руля:" v-if="getComTransport && selected.type_transport!=2">
        <b-form-select v-model="selected.helm_position" class="mb-2 mr-sm-2 mb-sm-2" @change="SetHelmPosition">
           <option :value="null">-- Выберите положение руля --</option>
           <option v-for="(item, index) in helm_position" :value="item.value" :key="index">{{item.text}}</option>
        </b-form-select>
    </b-form-group>

    <b-form-group label="Пробег(км):" v-if="getComTransport">
       <b-form-input type="number" v-model="mileage" placeholder="Введите пробег" class="mb-2 mr-sm-2 mb-sm-2" style="width:145px" :formatter="SetMileage" required></b-form-input>
    </b-form-group>

     <b-form-group label="Вид топлива:" v-if="getComTransport">
        <b-form-select v-model="selected.fuel_type" class="mb-2 mr-sm-2 mb-sm-2" @change="SetFuelType">
           <option v-for="(item, index) in fuel_type" :value="item.value" :key="index">{{item.text}}</option>
        </b-form-select>
    </b-form-group>

    <b-form-group label="Растаможен:" v-if="getComTransport">
        <b-form-select style="width:100px" v-model="selected.car_customs" class="mb-2 mr-sm-2 mb-sm-2" @change="SetTransportCustoms">
           <option :value="1">Да</option>
           <option :value="0">Нет</option>
        </b-form-select>
    </b-form-group>
  </div>
-->
</template>

<script>
import { post, get, interceptors } from '../../../helpers/api'

export default {

  data () {
    return 	{

        placeholder_info_text: "Введите текст объявления, например: ",

        type_transport: [
          { value: null, text: '-- Выберите вид транспорта --' },
          { value: 0, text: 'Легковой автомобиль' },
          { value: 1, text: 'Грузовой автомобиль' },
          { value: 2, text: 'Мототехника' },
          { value: 3, text: 'Спецтехника' },
          { value: 4, text: 'Ретро-автомобиль' },
          { value: 5, text: 'Водный транспорт' },
          { value: 6, text: 'Велосипед' },
          { value: 7, text: 'Воздушный транспорт' }
        ],        

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
    this.transport_chars.release_date    = 0;
    this.transport_chars.mileage         = 0;

  },
  
  computed: {
    
    // категории транспорта
    getComTransport() { 
      return [0,1,2,4].indexOf(this.selected.type_transport) != -1 && this.selected.type_transport!=null && this.$store.state.show_common_transport;      
    }
  },
  
  methods: {
    
    /*
    -----------------------------------
      Вид транспорта
    -----------------------------------*/
    selectTransportType() {

      console.log("Тип транспорта :"+this.selected.type_transport)

      this.$store.commit("SetRequiredInfo", true);
      this.$store.commit("ResetField", "price");
      this.$store.commit("SetPlaceholderInfoText",  "default");
      this.$store.commit("SetInfoLabelDescription", "default");
            
      this.selected.model = null;
      this.selected.carmark = null;
      
      
      if (this.selected.type_transport==null) {
        this.$store.commit("ShowCommonTransport", false);
        this.$store.commit("ShowFinalFields", false);               
      }      
      else {
        this.$store.commit("ShowCommonTransport", true);
        this.$store.commit("ShowFinalFields", true);       
      }

      this.transport_chars.transport_type = this.selected.type_transport;
                
      switch(this.selected.type_transport) {
                
        // легковой транспорт
        case 0: {

          this.$store.commit("ShowCommonTransport", false);          
          this.$store.commit("ShowFinalFields", false);                                                  
          this.$store.commit("SetInfoLabelDescription", "Дополнительно");
          this.$store.commit("SetPlaceholderInfoText", "Введите дополнительную информацию");

          this.carmark=[];
                      
          // запрос: получить марки автомобилей
          get("/getCarsMarks").then((res) => {            
            this.carmark = res.data;
            //this.selected.carmark=1;
            this.carmarkLoaded=true;
            console.log(this.carmark);
          }).catch((err) => {
              console.log(err);
          });
          break;
       }

        // грузовой транспорт
        case 1: {
            this.$store.commit("SetPlaceholderInfoText", this.placeholder_info_text+"Продам Камаз 2009 г. в хорошем состоянии.");
          break;
       }

      // мототехника
       case 2: {
            this.$store.commit("SetPlaceholderInfoText", this.placeholder_info_text+"Продам мотоцикл Yamaha 2015 г. в отличном состоянии.");          
          break;
       }

      // спецтехника
       case 3: {
            this.$store.commit("SetPlaceholderInfoText", this.placeholder_info_text+"Продам прицеп.");          
          break;
       }

       // ретроавто
       case 4: {            
          break;
       }
      
      // водный транспорт
       case 5: {            
          this.$store.commit("SetPlaceholderInfoText", this.placeholder_info_text+"Продам моторную лодку в хорошем состоянии.");          
          break;
       }

      // велосипеды
       case 6: {            
          this.$store.commit("SetPlaceholderInfoText", this.placeholder_info_text+"Продам новый велосипед.");          
          break;
       }

      // воздушный транспорт
       case 7: {            
          this.$store.commit("SetPlaceholderInfoText", this.placeholder_info_text+"Продам двухместный самолёт.");          
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
      this.$store.commit("SetRequiredInfo", false);

      this.transport_chars.mark_id = this.selected.carmark;

      console.log(this.selected.carmark);
      
      // запрос
      get("/getCarsModels?mark_id="+this.selected.carmark).then((res) => {

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
      this.transport_chars.model_id = this.selected.model;
      console.log(this.transport_chars.model_id);
      this.$store.commit("ShowCommonTransport", true);      
    },

     // ---------------------------
     // положение руля
     // ---------------------------
     SetHelmPosition() {
        this.transport_chars.rule_position = this.selected.rule_position;
     },

     checkForFinalFields() {
        if (this.selected.fuel_type!=null && this.selected.car_customs!=null)
          this.$store.commit("ShowFinalFields", true);
        else
          this.$store.commit("ShowFinalFields", false);
     },

     // ---------------------------
     // тип топлива
     // ---------------------------
     SetFuelType() {
        this.transport_chars.fuel_type = this.selected.fuel_type;
        this.checkForFinalFields()
     },
     
     // ---------------------------
     // растаможка
     // ---------------------------
     SetTransportCustoms() {
        this.transport_chars.customs = this.selected.car_customs;
        this.checkForFinalFields()
     },

     // год выпуска
     SetReleaseDate(date) {
      var d = new Date();        
      if ( date < 0 || date > d.getFullYear() ) 
        return this.release_date;
        this.transport_chars.release_date = date;
        return date;
     },

     // пробег
     SetMileage(mileage) {        
        if (mileage<0 || mileage>10000000) 
          return this.transport_chars.mileage;          
          this.transport_chars.mileage = mileage;                  
        return mileage;
     }
  },
}
</script>