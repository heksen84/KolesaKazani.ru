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
            <superInput type="number" v-model="input_floor" maxlength="3"></superInput>
          </div>

          <div class="col-auto form-group" v-if="selected_type!=null && selected_type!=1 && selected_type!=3 && selected_type!=5">
            <label>Кол-во комнат:</label>
              <superInput type="number" v-model="input_number_of_rooms" maxlength="2"></superInput>
          </div>

          <div class="col-auto form-group" v-if="selected_type!=null">
            <label>Площадь:</label>
              <superInput type="number" v-model="input_area" maxlength="3"></superInput>
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

  components: {
    superInput
  },

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
        selected_number_of_floors: 5,
        selected_property_rights: 0,
        selected_object_type: 0,

        // модели для инпутов
        input_floor: null,
        input_number_of_rooms: null,
        input_area: null,

        /*selected: {
          apartment:false,
          room:false,
          house_cottage:false,
          land_plot:false,
          garage:false,
          commercial_property:false,
          property_abroad:false
        }*/
		}
	},
  created() {

    this.realestate_chars = this.$root.advert_data; // указатель на массив объявления

    // значения недвижимости по умолчанию
    this.realestate_chars.property_type = 0;
    this.realestate_chars.type_of_building = 0, // дом
    this.realestate_chars.floor_num = 1;
    this.realestate_chars.number_of_floors = 5;
    this.realestate_chars.number_of_rooms = 1;
    this.realestate_chars.area_num = 0;
    this.realestate_chars.property_num = 0;
    this.realestate_chars.object_type = 0;
  },

  methods: {
  
    // тип строения: дом, дача, коттедж
    changeTypeOfBuilding(type) {
      this.realestate_chars.type_of_building = type;
    },

    // --------------------------------
    // изменения в недвижимости
    // --------------------------------
    changeProperyType(property_id) {

        //console.log("Вид недвижимости: "+property_id)
        
        this.realestate_chars.property_type = property_id;
        this.$store.commit("SetPlaceholderInfoText", "Введите текст объявления"); 
        this.$store.commit("SetPlaceholderInfoText", "Введите дополнительную информацию");
        this.$store.commit("SetRealEstateAreaLabelText", "default");
        this.$store.commit("ShowFinalFields", true); // показываю дополнительные поля
     
        switch(property_id) {
          case null: {
            this.$store.commit("ShowFinalFields", false);
            break;
          }
          case 0: {
            //this.selected.apartment=true;            
            break;
          }
          case 1: {
            break; 
          } 
          case 2: {
            break; 
          }
          case 3: {
              this.$store.commit("SetRealEstateAreaLabelText", "Площадь (сот.):");
              this.$store.commit("SetPlaceholderInfoText", "Введите текст объявления, например: Продам земельный участок"); 
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

      changeFloor(floor_num) {
        this.realestate_chars.floor_num = floor_num;
      },

      changeNumberOfFloors(number_of_floors) {        
        this.realestate_chars.number_of_floors = number_of_floors;
      },

      changeNumberOfRooms(number_of_rooms) {
        this.realestate_chars.number_of_rooms = number_of_rooms;
      },

      changeTotalArea(area_num) {

        if (area_num >= 10000000)
          return this.input_area;

        this.realestate_chars.area_num = area_num;
        return area_num;

      },

      changePropertyRights(property_num) {        
        this.realestate_chars.property_num = property_num;
      },

      changeObjectType(object_type) {
        this.realestate_chars.object_type = object_type;
      }
  }
}
</script>
