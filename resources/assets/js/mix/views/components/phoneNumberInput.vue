<template>
  <div>
    <input type='text' class='form-control phone_input' @keyup="input" v-model="cloneValue" /><span style='margin-left:8px;cursor:pointer' @click='removePhone'>X</span>
 </div>
</template>

<script>
export default {
  
  props: ["index", "value"],

  components: {},

  data () {
    return 	{
      cloneValue: this.value      
    }
	},
  created() {
    console.log("created index : "+this.index)
  },
  methods: {
    input() {
      console.log(this.cloneValue)
      //this.$store.state.phonesArr[this.index] = this
      this.$store.commit("SetPhoneNumber", this.index, "---");
    },
    removePhone() {
      this.$store.commit("RemovePhoneNumber", this.index);
    }
  }
}
</script>
