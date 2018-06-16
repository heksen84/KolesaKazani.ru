<template>
  <div class="item" @click="details">
    <!--<avatarka></avatarka>-->
    <h1 style="margin:15px;color:rgb(70,70,70)">{{ name }}</h1>
    <h3 style="margin:15px;color:rgb(70,70,70)">{{ text }}</h3>
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
