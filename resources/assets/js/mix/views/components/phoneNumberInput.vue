<template>
  <div>
    <span ><span>+7</span></span>
    <input type="tel" :name="name" maxlength="14" autocomplete="tel" pattern="[(][0-9]{3}[)] [0-9]{3}-[0-9]{4}" class='form-control phone_input' v-model="valueInput" required/><span style='margin-left:10px;cursor:pointer' @click='removePhone' title="удалить номер">X</span>    
 </div>
</template>

<script>
export default {
  
  props: ["index", "value", "name"],
  created() {
  //document.getElementsByTagName("input")[0].setAttribute("name", index);
  },
  
  // перехватчик
  computed: {
    valueInput: {
      get: function(){
        return this.value;
      },
      set: function(newValue){                
        
        let x = newValue.replace(/\D/g, '').match(/(\d{0,3})(\d{0,3})(\d{0,4})/);        
        let val = !x[2] ? x[1] : '(' + x[1] + ') ' + x[2] + (x[3] ? '-' + x[3] : '');                

        this.$emit("update:value", val)
        this.$store.commit("SetPhoneNumber", [ this.index, val ]);
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
