<template>
  <div>
    <span style="margin-right:10px" v-if="type==='phone'">+7</span>
    <!--<input type="tel" :name="name" maxlength="14" autocomplete="tel" pattern="[(][0-9]{3}[)] [0-9]{3}-[0-9]{4}" class='form-control phone_input' v-model="valueInput" required/><span style='margin-left:10px;cursor:pointer' @click='removePhone' title="удалить номер">X</span>-->
    <input type="text" :placeholder="placeholder" :name="name" :maxlength="maxlength" class='form-control phone_input' v-model="valueInput" @input.prevent="inputHandler" required/>
 </div>
</template>

<script>
export default {
  
  props: ["index", "value", "name", "type", "placeholder", "maxlength"],

  
  data () {
    return 	{}
  },

  created() {},
    
  // перехватчик
  computed: {
    
    valueInput: {

      // геттер
      get: function() {
        return this.value;
      },

      // сеттер
      set: function(newValue) {

        //this.$emit("update:value", newValue)
        //this.$emit('change', newValue, oldValue);
        //this.$refs.input.value = newValue;
        //this.$emit('change', newValue, 0);          
        //this.$emit("update:value", val)
        //this.$store.commit("SetPhoneNumber", [ this.index, val ]);

        switch(this.type) {

          // телефон
          case "phone": {                                            
            this.lastValue = newValue;
            let x = newValue.replace(/\D/g, '').match(/(\d{0,3})(\d{0,3})(\d{0,4})/);            
            let val = !x[2] ? x[1] : '(' + x[1] + ') ' + x[2] + (x[3] ? '-' + x[3] : '');            
            this.$emit('input', val)
            break;
          }
        }

      }   
    }
  },
  methods: {
    
    inputHandler(e) {
      const newValue = e.target.value;
      const numericPattern = /^-{0,1}\d*(\.\d*)*$/i;      
			if (!numericPattern.test(newValue)) e.target.value = this.value;
    },

    removePhone() {
      this.$store.commit("RemovePhoneNumber", this.index);
    }
  }
}
</script>
