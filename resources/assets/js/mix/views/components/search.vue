<template>  
  <form @submit="search">
      <input type="text" id="search_string" v-model="searchString" :placeholder="getPlaceholder()" required/>
      <button id="button_search" type="submit" title="Найти что требуется">найти</button>
  </form>  
</template>

<script>
export default {

  props: ["country", "lang", "searchlocation"],

  data () { return {
      searchString: ""
    }  
  },
  
  created() {    
  },
  
  methods: {

    getPlaceholder() {
      return "поиск по объявлениям "+this.searchlocation;
    },

    search(e) {

      e.preventDefault();

      if (this.searchString.length===0)
        return;
    
      if (this.searchString==="about::author")
        window.location = "https://moikrug.ru/heksen";    
      else
        window.location = "/search?str="+this.searchString+"&country="+this.country+"&lang="+this.lang;

    }

  }

}
</script>