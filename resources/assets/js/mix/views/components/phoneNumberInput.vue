<template>
  <div>
    <input type='text' class='form-control phone_input' v-model="valueInput"/><span style='margin-left:8px;cursor:pointer' @click='removePhone'>X</span>    
 </div>
</template>

<script>
export default {
  
  props: ["index", "value"],
  
  // перехватчик
  computed: {
    valueInput: {
      get: function(){
        return this.value;
      },
      set: function(newValue){                
        this.$emit("update:value", newValue)
        this.$store.commit("SetPhoneNumber", [ this.index, newValue ]);
      }   
    }
  },
  methods: {    
    removePhone() {
      this.$store.commit("RemovePhoneNumber", this.index);
    }
  }
}
</script>
