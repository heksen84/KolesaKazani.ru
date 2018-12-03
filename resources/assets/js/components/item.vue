<template>

  <div class="item" @click="details">
    <b-img src="https://picsum.photos/300/150/?image=41" width="120%" height="120" style="display:inline-block"/>
    <div style="width:55%;position:relative;top:-115px;left:125px;overflow:hidden">
      <div style="font-weight:bold">{{ title }} {{ text }} <span style="font-weight:normal">{{ year }}г.</span></div>
      <div>Цена: <b>{{ price }}</b></div>
      <br>
      <b-button size="sm" variant="outline-success">Подробнее</b-button>
    </div>
  </div>
    
</template>

<script>
import avatarka from "./avatarka"
export default {

  props: ['id', 'photo', 'title', 'text', 'price', "images", "year"],

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
