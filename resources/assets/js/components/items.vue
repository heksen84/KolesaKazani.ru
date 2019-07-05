<template>
  <div>
    <div class="row" v-for="i in 100" :key="i">    
      <div class="col-sm-12 col-md-12 col-lg-8 col-xl-8 margin-auto">
        <div class="card mb-1">
            <div class="card-body">              
              <h5 class="card-title">{{ items }}</h5>
                <p class="card-text">Цена: 2233 тнг.</p>
                <a href="#" class="btn btn-success btn-sm">Подробнее</a>
            </div>
          </div>
        </div>
      </div>
    </div>
</template>

<script>
export default {
  data () {
    return 	{}
	},
  created() {},
  
  components: {},

  props: ["items"],

  methods: {
    details(event) {
    }
  }
}
</script>
