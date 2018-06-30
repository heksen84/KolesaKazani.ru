<template>
  <div>
    <b-form inline>
    <b-form-group label="Расположение руля:" style="border:1px grey">
        <b-form-select v-model="selected_item" class="mb-2 mr-sm-2 mb-sm-0" style="width:260px">
           <option v-for="item in items" :value="item.value">{{item.text}}</option>
        </b-form-select>
    </b-form-group>

     <b-form-group label="Тип двигателя:" style="border:1px grey">
        <b-form-select v-model="selected_item" class="mb-2 mr-sm-2 mb-sm-0" style="width:260px">
           <option v-for="item in items" :value="item.value">{{item.text}}</option>
        </b-form-select>
    </b-form-group>
    </b-form>

  </div>
</template>

<script>
export default {
  data () {
    return 	{
       items: [
          { value: 0, text: 'Справа' },
          { value: 1, text: 'Слева' }
        ],
    selected_item: 0
		}
	},
  created() {
  },
  components: {},
  methods: {
    details(event) {
    }
  }
}
</script>
