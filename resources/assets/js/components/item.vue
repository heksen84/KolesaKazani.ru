<template>
  <div class="item" @click="details">
    <!--<avatarka></avatarka>-->
    <h2 style="margin:15px;color:rgb(70,70,70)">{{ name }}</h2>
  </div>
</template>

<script>
import avatarka from "./avatarka"
export default {
  props: ['id', 'photo', 'name', 'desc', 'price'],
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
