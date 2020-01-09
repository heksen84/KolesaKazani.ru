<template>

    <div class="modal" id="authModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">

            <h5 class="modal-title grey">Требуется авторизация</h5>            
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>          
          </div>

          <div class="modal-body">
            <div class="col-md-12 text-center">
                <span>Логин:</span>                      
                <superInput type="number" v-model="price" :maxlength="12" @input="setPrice" style="width:400px"></superInput>
            </div>
            <div class="col-md-12 text-center">
                <span>Пароль:</span>                      
                <superInput type="number" v-model="price" :maxlength="12" @input="setPrice" style="width:400px"></superInput>
                <a href="/register">регистрация</a>
            </div>
          </div>

          <div class="modal-footer">          
            <button type="button" class="btn btn-primary margin-auto" @click="setCoords">Войти</button>          
          </div>
        </div>
      </div>
    </div>        

</template>

<script>

import superInput from "../superInput"

export default { 

  components: { superInput },

  data () {
    return 	{}
  },

  created() {},
      
  methods: {
    inputHandler(e) {}
  }
}
</script>
