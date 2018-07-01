<template>
  <div class="item" @click="details">
    <h5 style="margin:15px;color:rgb(70,70,70)">{{ title }}</h5>
    <div style="margin:15px;color:rgb(70,70,70)">{{ text }}</div>
    <h6 style="margin:15px;color:rgb(70,70,70)">цена: {{ price }}</h6>
  </div>
</template>

<script>
import avatarka from "./avatarka"
export default {
  props: ['id', 'photo', 'title', 'text', 'price'],
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
