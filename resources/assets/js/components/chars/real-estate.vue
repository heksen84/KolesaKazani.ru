<template>
  <div>
	<b-form-group label="Вид недвижимости:" label-for="categories" style="width:290px">
        <b-form-select v-model="selected_type" class="mb-3" @change="changeRealEstate">
           <option v-for="item in type" :value="item.value">{{item.text}}</option>
        </b-form-select>
  </b-form-group>
  </div>
</template>

<script>
export default {
  data () {
    return 	{
        type: 
        [
          { value: 0, text: 'Квартира' },
          { value: 1, text: 'Комната' },
          { value: 2, text: 'Дом, дача, коттедж' },
          { value: 3, text: 'Земельный участок' },
          { value: 5, text: 'Гараж или машиноместо' },
          { value: 6, text: 'Коммерческая недвижимость' },
          { value: 7, text: 'Недвижимость за рубежом' }
        ],
        selected_type: 0
		}
	},
  created() {
  },
  components: {},
  methods: {
    
    // изменения в недвижимости
    changeRealEstate(data) {
        switch(data) {
          case 0: {
            break;
          }
          case 1: {
              alert("ok-1");
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
