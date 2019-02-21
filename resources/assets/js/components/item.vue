<template>
  <div class="item" @click="details">
    <b-img :src="'../storage/app/images/'+image" width="118" height="118" style="display:inline-block" v-if="image!=null"/>
    <b-img :src="'../public/images/_nofoto.jpg'" width="118" height="118" style="display:inline-block" v-if="image==null"/>
    <div class="item-content">      
        <b v-if="deal==0 && full">Куплю</b>
        <b v-if="deal==1 && full">Продам</b>
        <b v-if="deal==2 && full">Обменяю</b>
        <b v-if="deal==3 && full">Отдам даром</b>
        <b v-if="deal==4 && full">Сдам в аренду</b>
      <b>{{ title }}</b>
        <!-- не отображать цену в услугах (category_id==4) -->
        <div v-if="category_id!=4">Цена: {{ price }} тенге</div>
        <!-- сделать перенос на след. строку в услугах (category_id==4) -->
        <br v-if="category_id==4">
      <b-button style="margin-top:5px" size="sm" variant="outline-success">Подробнее</b-button>
    </div>
  </div>
</template>
<script>
export default {
props: [ "id", "image", "title", "price", "category_id", "deal", "full" ],
methods: {
    details(event) { window.location='/details/'+this.id;  
    }
  }
}
</script>
