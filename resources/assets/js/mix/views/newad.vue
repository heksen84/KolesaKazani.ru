<template>
<div class="container-fluid mycontainer_adv">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-10 col-xl-10 create_advert_col">
            <div class="close_button" title="Закрыть страницу" style="font-weight:bold" @click="closeAndReturn">X</div>
		    <h1 class="title_text" style="margin-top:12px">подать объявление</h1>
            <hr>
            <div class="form-group" style="width:260px">
                <label for="categories">Категория товара или услуги:</label>
                <select class="form-control" v-model="category" @change="changeCategory">            
                    <option v-bind:value="null">-- Выберите категорию --</option>
                    <option v-for="(item, index) in categories" :key="index" v-bind:value="item.id">{{ item.name }}</option>
                </select>                
            </div>

            <div v-if="category!=null" style="margin-bottom:10px">
            <label style="width:270px">Вид сделки:</label>            
            <div class="form-check" style="width:260px">
                <div v-for="(item,index) in dealtypes" :key="index">
                    <input class="form-check-input" :id="item.id" type="radio" name="inlineRadioOptions" v-bind:value="item.id" v-model="sdelka" @change="setDeal">
                    <label class="form-check-label" :for="item.id">{{ item.deal_name_1 }}</label>
                </div>
            </div>
            </div>

        </div>
    </div>
</div>
</template>
<script>
// Логика

export default {

// Входящие данные
props: ["categories", "dealtypes", "regions"],

data () {
    return 	{
        category: null,
        sdelka: null,
        advert_data: {}, // Объект объявления который пойдёт на сервер      
        deal_id: null,
    }
},

methods: {

// Вернуться на предыдущую страницу
closeAndReturn() {
 	window.history.back();
},

// --------------------------------------
// Выбрать сделку
// --------------------------------------
setDeal(deal_id) {    
    this.advert_data.adv_deal=deal_id;
    this.deal_id=deal_id;
    this.$store.commit("SetDealSelected", true);
},

// --------------------------------------
// Изменения в категориях
// --------------------------------------
changeCategory() {    
    let category = this.category;    
}

}

}
</script>