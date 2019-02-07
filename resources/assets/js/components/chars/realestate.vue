<template>
  <b-form inline style="margin-top:-18px;">

	<b-form-group label="Вид недвижимости:">
        <b-form-select v-model="selected_type" class="mb-2 mr-sm-2 mb-sm-2" @change="changeProperyType">
           <option v-for="item in type" :value="item.value" :key="item.value">{{item.text}}</option>
        </b-form-select>
  </b-form-group>

<b-form-group label="Этаж:" v-if="selected.apartment && selected_type==0 || selected_type==1">
         <b-form-select v-model="selected_floor" class="mb-2 mr-sm-2 mb-sm-2" @change="changeFloor">
           <option v-for="i in 60" :value="i" :key="i">{{ i }}</option>
        </b-form-select>
</b-form-group>

<b-form-group label="Этажей в доме:" v-if="selected.apartment && selected_type==0 || selected_type==1">
         <b-form-select v-model="selected_number_of_floors" class="mb-2 mr-sm-2 mb-sm-2" @change="changeNumberOfFloors" style="width:120px">
           <option v-for="i in 100" :value="i" :key="i">{{ i }}</option>
        </b-form-select>
</b-form-group>

<b-form-group label="Количество комнат:" v-if="selected.apartment && selected_type==0 || selected_type==1">
         <b-form-select v-model="selected_number_of_rooms" class="mb-2 mr-sm-2 mb-sm-2" @change="changeNumberOfRooms" style="width:152px">
           <option v-for="i in 10" :value="i" :key="i">{{ i }}</option>
        </b-form-select>
</b-form-group>

<b-form-group label="Общая площадь:" v-if="selected.apartment && selected_type==0 || selected_type==1">
        <b-form-input type="number" v-model="input_area" class="mb-2 mr-sm-2 mb-sm-2" @input="changeTotalArea" style="width:160px" placeholder="Введите площадь"></b-form-input>
</b-form-group>

<b-form-group label="Право собственности:" v-if="selected_type!=null">
        <b-form-select v-model="selected_property_rights" class="mb-2 mr-sm-2 mb-sm-2" @change="changePropertyRights" style="width:175px">
           <option v-for="item in property_rights" :value="item.value" :key="item.value">{{item.text}}</option>
        </b-form-select>
</b-form-group>

<b-form-group label="Вид объекта:" v-if="selected_type!=null">
        <b-form-select v-model="selected_object_type" class="mb-2 mr-sm-2 mb-sm-2" @change="changeObjectType" style="width:175px">
           <option v-for="item in object_type" :value="item.value" :key="item.value">{{item.text}}</option>
        </b-form-select>
</b-form-group>

</b-form>
</template>

<script>
export default {
  data () {
    return 	{

        realestate_chars: null,

        object_type: 
        [
          { value: 0, text: 'Вторичка' },
          { value: 1, text: 'Новостройка' },
         
        ],
        property_rights: 
        [
          { value: 0, text: 'Собственник' },
          { value: 1, text: 'Посредник' },
         
        ],
        type: 
        [
          { value: null, text: '-- Выберите вид недвижимости --' },
          { value: 0, text: 'Квартира' },
          { value: 1, text: 'Комната' },
          { value: 2, text: 'Дом, дача, коттедж' },
          { value: 3, text: 'Земельный участок' },
          { value: 5, text: 'Гараж или машиноместо' },
          { value: 6, text: 'Коммерческая недвижимость' },
          { value: 7, text: 'Недвижимость за рубежом' }
        ],
        
        selected_type: null,
        selected_floor: 1,
        selected_number_of_floors: 5,
        selected_number_of_rooms: 1,
        input_area: null,
        selected_property_rights: 0,
        selected_object_type: 0,

        selected: {
          apartment:false,
          room:false,
          house_cottage:false,
          land_plot:false,
          garage:false,
          commercial_property:false,
          property_abroad:false
        }
		}
	},
  created() {

    this.realestate_chars = this.$root.advert_data; // указатель на массив объявления

    // значения недвижимости по умолчанию
    this.realestate_chars.property_type = 0;
    this.realestate_chars.floor_num = 1;
    this.realestate_chars.number_of_floors = 5;
    this.realestate_chars.number_of_rooms = 1;
    this.realestate_chars.property_num = 0;
    this.realestate_chars.object_type = 0;
  },
  components: {},
  methods: {

    // --------------------------------
    // изменения в недвижимости
    // --------------------------------
    changeProperyType(property_id) {

        console.log("Вид недвижимости: "+property_id)

        this.realestate_chars.property_type = property_id;

        // показываю дополнительные поля
        this.$store.commit("ShowOtherFields", true);
     
        switch(property_id) {
          case null: {
            this.$store.commit("ShowOtherFields", false);
            break;
          }
          case 0: {
            this.selected.apartment=true;
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

      changeFloor(floor_num) {
        console.log("Этаж :"+floor_num)
        this.realestate_chars.floor_num = floor_num;
      },

      changeNumberOfFloors(number_of_floors) {
        console.log("Этажей :"+number_of_floors)
        this.realestate_chars.number_of_floors = number_of_floors;
      },

      changeNumberOfRooms(number_of_rooms) {
        console.log("Комнат :"+number_of_rooms)
        this.realestate_chars.number_of_rooms = number_of_rooms;
      },

      changeTotalArea(area_num) {
        console.log("Этажей :"+area_num)
        this.realestate_chars.area_num = area_num;
      },

      changePropertyRights(property_num) {
        console.log("Собственность :"+property_num)
        this.realestate_chars.property_num = property_num;
      },

      changeObjectType(object_type) {
        console.log("Вид объекта :"+object_type)
        this.realestate_chars.object_type = object_type;
      }

  }
}
</script>
