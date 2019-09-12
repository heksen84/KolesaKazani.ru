<template>
<div class="container-fluid mycontainer_adv">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-10 col-xl-10 create_advert_col">
            <div class="close_button" title="Закрыть страницу" style="font-weight:bold" @click="closeAndReturn">X</div>
		    <h1 class="title_text" style="margin-top:12px">подать объявление</h1>
            <hr>
            <div class="form-group" style="width:260px">
                <label for="categories">Категория товара или услуги:</label>
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

methods: {

// Вернуться на предыдущую страницу
closeAndReturn() {
 	window.history.back();
}

}

}
</script>