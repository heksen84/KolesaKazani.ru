<template>
  <b-form inline style="margin-top:-18px;">

	<b-form-group label="Вид недвижимости:">
        <b-form-select v-model="selected_type" class="mb-2 mr-sm-2 mb-sm-2" @change="changeRealEstate">
           <option v-for="item in type" :value="item.value">{{item.text}}</option>
        </b-form-select>
  </b-form-group>

<b-form-group label="Этаж:" v-if="selected.apartment && selected_type==0 || selected_type==1">
         <b-form-select v-model="selected_room_count" class="mb-2 mr-sm-2 mb-sm-2" @change="changeRealEstate">
           <option v-for="i in 60" :value="i">{{ i }}</option>
        </b-form-select>
</b-form-group>

<b-form-group label="Этажей в доме:" v-if="selected.apartment && selected_type==0 || selected_type==1">
         <b-form-select v-model="selected_room_count" class="mb-2 mr-sm-2 mb-sm-2" @change="changeRealEstate" style="width:120px">
           <option v-for="i in 60" :value="i">{{ i }}</option>
        </b-form-select>
</b-form-group>

<b-form-group label="Количество комнат:" v-if="selected.apartment && selected_type==0 || selected_type==1">
         <b-form-select v-model="selected_room_count" class="mb-2 mr-sm-2 mb-sm-2" @change="changeRealEstate" style="width:152px">
           <option v-for="i in 7" :value="i">{{ i }}</option>
        </b-form-select>
</b-form-group>

<b-form-group label="Общая площадь:" v-if="selected.apartment && selected_type==0 || selected_type==1">
        <b-form-input type="number" v-model="area" class="mb-2 mr-sm-2 mb-sm-2" style="width:140px"></b-form-input>
</b-form-group>


<b-form-group label="Право собственности:" v-if="selected_type!=null">
        <b-form-select v-model="selected_property_rights" class="mb-2 mr-sm-2 mb-sm-2" @change="changeRealEstate" style="width:175px">
           <option v-for="item in property_rights" :value="item.value">{{item.text}}</option>
        </b-form-select>
</b-form-group>


<b-form-group label="Вид объекта:" v-if="selected_type!=null">
        <b-form-select v-model="selected_object_type" class="mb-2 mr-sm-2 mb-sm-2" @change="changeRealEstate" style="width:175px">
           <option v-for="item in object_type" :value="item.value">{{item.text}}</option>
        </b-form-select>
</b-form-group>

</b-form>
</template>

<script>
export default {
  data () {
    return 	{
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

        area: 0,

        selected_type: null,
        selected_property_rights: 0,
        selected_room_count: 1,
        selected_object_type:0,

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
  },
  components: {},
  methods: {

    // --------------------------------
    // изменения в недвижимости
    // --------------------------------
    changeRealEstate(data) {

        // показываю дополнительные поля
        this.$store.commit('showOtherFields');
     
        switch(data) {
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
      }
  }
}
</script>
