<template>
  <div class="item" @click="details">
    
    <h4 style="margin:15px;color:rgb(70,70,70)">{{ title }}</h4>
    <div style="margin:15px;color:rgb(70,70,70)">{{ text }}</div>
    <h6 style="margin:15px;color:rgb(70,70,70)">цена: {{ price }}</h6>  
    <!--<span v-for="(i,index) in images" :key="index">{{ i.image }}</span>-->
    <!--<b-img v-for="(i,index) in images" :key="index" :src="i.image" fluid :alt="i.image" width="100" height="100"/>-->
    
    <!--<b-img :src="images[0]" fluid :alt="images[0].image" width="100" height="100"/>-->

  </div>
</template>

<script>
import avatarka from "./avatarka"
export default {
  props: ['id', 'photo', 'title', 'text', 'price', "images"],
  data () {
    return 	{
		}
	},
  created() {

    console.log(this.images)
  },
  components: { avatarka },
  methods: {
    details(event) {
        window.location='/details/'+this.id;  
    }
  }
}
</script>
