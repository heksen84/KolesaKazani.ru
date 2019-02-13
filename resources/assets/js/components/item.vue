<template>

  <div class="item" @click="details">
    <b-img :src="'../storage/app/images/'+image" width="118" height="118" style="display:inline-block" v-if="image!=null"/>
    <b-img :src="'../public/images/_nofoto.jpg'" width="118" height="118" style="display:inline-block" v-if="image==null"/>

    <div class="item-content">      
        <b>{{ title }}</b>
        <div>Цена: {{ price }} тенге</div>
        <b-button style="margin-top:5px" size="sm" variant="outline-success">Подробнее</b-button>
    </div>
  </div>
    
</template>

<script>
export default {
  props: [ "id", "image", "title", "price", "category_id" ],

  data () {
    return 	{}
	},
  
  created() {
    console.log("картинка :"+this.image)
  },

  methods: {
    details(event) { window.location='/details/'+this.id;  
    }
  }
}
</script>
