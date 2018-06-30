<template>
  <div>
        <b-form-select v-model="selected_item" class="mb-3" style="width:200px">
           <option v-for="item in items" :value="item.id">{{item.text}}</option>
        </b-form-select>
  </div>
</template>

<script>
export default {
  data () {
    return 	{
       items: [
        { value: 0, text: 'Правый руль' },
        { value: 1, text: 'Левый руль' },
    ],
    selected_item:1
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
