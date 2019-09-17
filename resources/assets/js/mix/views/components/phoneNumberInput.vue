<template>
  <div>
     <input type='text' class='form-control phone_input'/><span style='margin-left:8px;cursor:pointer' @click='removePhone'>X</span>
 </div>
</template>

<script>
export default {
  data () {
    return 	{
		}
	},
  created() {
  },
  components: {},
  methods: {
    removePhone() {
      this.$store.commit("RemovePhoneNumber");
    }
  }
}
</script>
