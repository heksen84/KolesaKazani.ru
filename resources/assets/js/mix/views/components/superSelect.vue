<template>
  <div class="col-auto">
      <label for="selector">{{ label }}</label>
        <!--<select id="selector" class="form-control form-group" @change="changeRegion" v-model="regions_model">            -->
          <select id="selector" class="form-control form-group">
          <option v-bind:value="null">-- Выберите --</option>
          <!--<option v-for="item in regions" :value="item.region_id" :key="item.name">{{ item.name }}</option>-->
        </select>
 </div>
</template>

<script>
export default {
  
  props: ["label"],

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
