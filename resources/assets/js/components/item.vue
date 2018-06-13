<template>
  <div class="item" @click="details">
    <h3 style="margin-left:5px">{{ name }}</h3>
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
