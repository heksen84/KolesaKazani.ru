<template>
  <div>
    <b-form-group label="Расположение руля:">
        <b-form-select v-model="selected_item" class="mb-3" style="width:230px">
           <option v-for="item in items" :value="item.value">{{item.text}}</option>
        </b-form-select>
      </b-form-group>
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
