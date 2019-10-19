<template>
  <div class="col-auto">
      <label for="selector">{{ label }}</label>
      <select id="selector" class="form-control form-group">
      <option v-bind:value="null">-- Выберите --</option>
      <option value="1">item1</option>
      <option value="2">item2</option>
      </select>
 </div>
</template>

<script>
export default {
  
  props: ["label", "data"],

/*
  data () {
    return 	{}
  },

  created() {},

*/
    
  // перехватчик
  computed: {
    
/*    valueInput: {
      // геттер
      get: function() { return this.value; },

      // сеттер
      set: function(newValue) {}   
    }*/
  },
  
  methods: {
    
    // --------------------
    // обработчик ввода
    // --------------------
    inputHandler(e) {}
  }
}
</script>
