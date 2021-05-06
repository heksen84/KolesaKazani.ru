<template>
  <div>
    <span class="mr-2" v-if="type=='phone'">+7</span>    
    <input type="tel" :id="id" :placeholder="placeholder" :name="name" class='form-control phone_input' v-model="valueInput" @input.prevent="inputHandler" :maxlength="maxlength" v-if="type==='phone'" required  @keyup.enter.stop="$event.target.blur()"/>
    <input type="number" :id="id" :placeholder="placeholder" :name="name" class='form-control number_input' v-model="valueInput" @input.prevent="inputHandler" :maxlength="maxlength" v-if="type==='number'" required  @keyup.enter.stop="$event.target.blur()"/>
 </div>
</template>

<script>

let lastValue = "";

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
      get: function() {                         
        return this.value;        
      },      
      set: function(newValue) {
      }   
    }
  },

  /*<input name="somename"
        oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
        type = "number"
        maxlength = "6"
     />*/
  
  methods: {    
    // обработчик ввода
    inputHandler(e) {

      const newValue = e.target.value;
      const numericPattern = /^[0-9]*$/;            

      if (newValue.length > this.maxlength) {        
        this.$emit('input', null)
        return;
      }
      

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
      }
    }
}
</script>