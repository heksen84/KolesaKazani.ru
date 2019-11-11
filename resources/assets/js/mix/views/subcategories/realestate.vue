<template>
  <div>
    <div class="row">
          <div class="col-auto form-group">
            <label for="selected_type">Вид недвижимости:</label>
              <select id="selected_type" class="form-control" v-model="selected_type" @change="changeProperyType">                          
                <option v-for="item in type" :value="item.value" :key="item.value">{{item.text}}</option>
              </select>
          </div>

          <div class="col-auto form-group" v-if="selected_type!=null && selected_type!=0 && selected_type!=1 && selected_type!=3 && selected_type!=5">
            <label for="type_of_building">Вид строения:</label>
              <select id="type_of_building" class="form-control" v-model="selected_type_of_building" @change="changeTypeOfBuilding">                          
                <option v-for="item in type_of_building" :value="item.value" :key="item.value">{{ item.text }}</option>
              </select>
          </div>

          <div class="col-auto form-group" v-if="selected_type!=null && selected_type!=2 && selected_type!=3 && selected_type!=5">
            <label>Этаж:</label>
            <superInput type="number" v-model="input_floor" maxlength="3" @input="changeFloor"></superInput>
          </div>

          <div class="col-auto form-group" v-if="selected_type!=null && selected_type!=2 && selected_type!=2 && selected_type!=3 && selected_type!=5">
            <label>Кол-во этажей:</label>
            <superInput type="number" v-model="input_number_of_floors" maxlength="3" @input="changeNumberOfFloors"></superInput>
          </div>

          <div class="col-auto form-group" v-if="selected_type!=null && selected_type!=1 && selected_type!=3 && selected_type!=5">
            <label>Кол-во комнат:</label>
              <superInput type="number" v-model="input_number_of_rooms" maxlength="2" @input="changeNumberOfRooms"></superInput>
          </div>

          <div class="col-auto form-group" v-if="selected_type!=null">
            <label>Площадь:</label>
              <superInput type="number" v-model="input_area" maxlength="3" @input="changeTotalArea"></superInput>
          </div>

          <div class="col-auto form-group" v-if="selected_type!=null">
            <label>Право собственности:</label>
              <select class="form-control" v-model="selected_property_rights" @change="changePropertyRights">                          
                <option v-for="item in property_rights" :value="item.value" :key="item.value">{{ item.text }}</option>
              </select>
          </div>

          <div class="col-auto form-group" v-if="selected_type!=null && selected_type!=1 && selected_type!=3 && selected_type!=5">
            <label>Вид объекта:</label>
              <select class="form-control" v-model="selected_object_type" @change="changeObjectType">                          
                <option v-for="item in object_type" :value="item.value" :key="item.value">{{ item.text }}</option>
              </select>
          </div>
      </div>
  </div>
</template>

<script>

import superInput from "../components/superInput.vue"

export default {

  components: { superInput },

  data () {
    return 	{

        realestate_chars: null,

        type_of_building: [
          { value: 0, text: 'Дом' },
          { value: 1, text: 'Дача' },
          { value: 2, text: 'Коттедж' },
          { value: 3, text: 'Другое' }         
        ],

        object_type: [
          { value: 0, text: 'Вторичка' },
          { value: 1, text: 'Новостройка' },
         
        ],

        property_rights: [
          { value: 0, text: 'Собственник' },
          { value: 1, text: 'Посредник' },
         
        ],

        type: [
          { value: null, text: '-- Выберите вид недвижимости --' },
          { value: 0, text: 'Квартира' },
          { value: 1, text: 'Комната' },
          { value: 2, text: 'Дом, дача, коттедж' },
          { value: 3, text: 'Земельный участок' },
          { value: 5, text: 'Гараж или машиноместо' },
          { value: 6, text: 'Коммерческая недвижимость' },
          { value: 7, text: 'Недвижимость за рубежом' }
        ],

        // модели для селектов
        selected_type_of_building: 0,
        selected_type: null,
        selected_property_rights: 0,
        selected_object_type: 0,

        // модели для инпутов
        input_floor: null,
        input_number_of_floors: null,
        input_number_of_rooms: null,
        input_area: null
		}
  },
  
  // компонент создан
  created() {

    this.realestate_chars = this.$root.advert_data; // указатель на массив объявления
    
    // значения недвижимости по умолчанию
    this.selected_type = null;
    this.realestate_chars.property_type = null;

    this.resetData();

  },

  methods: {

    // сброс содержимого полей
    resetData() {
      
      this.selected_property_rights = 0;
      this.selected_object_type = 0;

      // модели для инпутов
      this.input_floor = null;
      this.input_number_of_floors = null;
      this.input_number_of_rooms = null;
      this.input_area = null,

      this.realestate_chars.type_of_building = 0, // дом
      this.realestate_chars.floor_num = null;
      this.realestate_chars.number_of_floors = null;
      this.realestate_chars.number_of_rooms = null;
      this.realestate_chars.area_num = null;
      this.realestate_chars.property_num = 0;
      this.realestate_chars.object_type = 0;

    },
  
    // тип строения: дом, дача, коттедж
    changeTypeOfBuilding() {        
        this.realestate_chars.type_of_building = this.selected_type_of_building;
    },

    // --------------------------------
    // изменения в недвижимости
    // --------------------------------
    changeProperyType() {

        console.log("Вид недвижимости: " + this.selected_type)

        this.resetData(); // обнуляю поля
        
        this.realestate_chars.property_type = this.selected_type;
        
        this.$store.commit("SetRealEstateAreaLabelText", "default");
        this.$store.commit("ShowFinalFields", true); // показываю дополнительные поля
     
        switch(this.selected_type) {
          
          case null: {
            this.$store.commit("ShowFinalFields", false);
            break;
          }
          case 0: {          
            break;
          }
          case 1: {
            break; 
          } 
          case 2: {
            break; 
          }
          case 3: {
            break; 
          }
          case 4: { 
            break; 
          }
          case 5: { 
            break; 
          }
          case 6: { 
            break; 
          }
          case 7: { 
            break; 
          }
          case 8: { 
            break; 
          }
        }
      },

      changeFloor() {

        //console.log(this.input_floor)

        /*if (this.input_floor>this.input_number_of_floors)
          this.input_floor=this.input_number_of_floors*/

        this.realestate_chars.floor_num = this.input_floor;
      },

      changeNumberOfFloors() {                

        /*if (this.input_number_of_floors<this.input_floor)
          this.input_floor=this.input_number_of_floors*/

        this.realestate_chars.number_of_floors = this.input_number_of_floors;
      },

      changeNumberOfRooms() {
        this.realestate_chars.number_of_rooms = this.input_number_of_rooms;
      },

      changeTotalArea() {
        this.realestate_chars.area_num = this.input_area;
      },

      changePropertyRights() {        
        this.realestate_chars.property_num = this.selected_property_rights;
      },

      changeObjectType() {
        this.realestate_chars.object_type = this.selected_object_type;
      }
  }
}
</script>
