<template>
  <div class="item" @click="details">
    <h2 style="margin:15px;color:rgb(70,70,70)">{{ name }}</h2>
  </div>
</template>

<script>
export default {
  props: ['id', 'photo', 'name', 'desc', 'price'],
  data () {
    return 	{
		}
	},
  created() {
  },
  methods: {
    details(event) {
        window.location='/details/'+this.id;  
    }
  }
}
</script>
