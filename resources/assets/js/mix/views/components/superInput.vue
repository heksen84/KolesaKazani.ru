<template>
  <div>
    <span class="mr-2" v-if="type=='phone'">+7</span>    
    <input type="number" :id="id" :placeholder="placeholder" :name="name" class='form-control phone_input' v-model="valueInput" @input.prevent="inputHandler" :maxlength="maxlength" v-if="type==='phone'" required/>
    <input type="number" :id="id" :placeholder="placeholder" :name="name" class='form-control number_input' v-model="valueInput" @input.prevent="inputHandler" :maxlength="maxlength" v-if="type==='number'" required/>
 </div>
</template>

<script>
export default {
  
  props: [
    "id",
    "index", 
    "value", 
    "name", 
    "type", 
    "placeholder", 
    "maxlength",     
  ],
    
  // перехватчик
  computed: {
    
    valueInput: {
      // геттер
      get: function() { return this.value; },
      // сеттер
      set: function(newValue) {}   
    }
  },
  
  methods: {
    
    // --------------------
    // обработчик ввода
    // --------------------
    inputHandler(e) {

      const newValue = e.target.value;
      const numericPattern = /^[0-9]*$/;

      switch(this.type) {

          // телефон
          case "phone": {                                                        
            
            if (!numericPattern.test(newValue)) 
              e.target.value = this.value;

            let x = newValue.replace(/\D/g, '').match(/(\d{0,3})(\d{0,3})(\d{0,4})/);            
            let val = !x[2] ? x[1] : '(' + x[1] + ') ' + x[2] + (x[3] ? '-' + x[3] : ''); 

            this.$emit('input', val)
            break;
          }
          
          // число          
          case "number": {      
            
            if (!numericPattern.test(newValue)) 
              e.target.value = this.value;
            else
              this.$emit('input', newValue)

            break;
          }
      }      			
    },

    // ------------------
    // телефон
    // ------------------
    removePhone() {
      this.$store.commit("RemovePhoneNumber", this.index);
    }
  }
}
</script>