export default {

  name: 'col',
  mixins: [],

  directives: {
  },

  props: {
  },

  computed: {
    classes () {
      return {
      }
    }
  },

  mounted () {
	//alert("mounted");
  },

  watch: {
    dark () {
    }
  },

  render (h) {
  var div = document.createElement('div');
  div.innerHTML = "col";
  document.body.appendChild(div);
  }
}
