<template>
  <div class="item" @click="details">
    <!--<avatarka></avatarka>-->
    <h3 style="margin:15px;color:rgb(70,70,70)">{{ name }}</h3>
    <div style="margin:15px;color:rgb(70,70,70)">{{ text }}</div>
    <h5 style="margin:15px;color:rgb(70,70,70)">цена: {{ price }}</h5>
  </div>
</template>

<script>
import avatarka from "./avatarka"
export default {
  props: ['id', 'photo', 'name', 'text', 'price'],
  data () {
    return 	{
		}
	},
  created() {
  },
  components: { avatarka },
  methods: {
    details(event) {
        window.location='/details/'+this.id;  
    }
  }
}
</script>
