<template>

  <div class="item" @click="details">
    <b-img :src="'storage/app/images/'+image" width="120%" height="120" style="display:inline-block" v-if="image!=null"/>
    <b-img width="0" height="120" style="display:inline-block;background:white" v-if="image==null"/>
    <div style="width:55%;position:relative;top:-115px;left:125px;overflow:hidden">      
        <div style="font-weight:bold">{{ title }}</div>
        <div>Цена: <b>{{ price }}</b> тенге</div>
      <br>
      <b-button size="sm" variant="outline-success">Подробнее</b-button>
    </div>
  </div>
    
</template>

<script>
import avatarka from "./avatarka"
export default {
  
  props: [ "id", "image", "title", "price", "year", "category_id" ],

  data () {
    return 	{}
	},
  
  created() {
    console.log(this.images)
  },

  components: { avatarka },
  methods: 
  {
    details(event) 
    {
        window.location='/details/'+this.id;  
    }
  }
}
</script>
