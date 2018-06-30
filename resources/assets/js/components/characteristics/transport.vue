<template>
  <div>
        <b-form-select v-model="selected_item" class="mb-3" style="width:230px">
           <option v-for="item in items" :value="item.value">{{item.text}}</option>
        </b-form-select>
  </div>
</template>

<script>
export default {
  data () {
    return 	{
       items: [
          { value: null, text: '-- раположение руля --' },
          { value: 0, text: 'Правый руль' },
          { value: 1, text: 'Левый руль' }
        ],
    selected_item: null
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
