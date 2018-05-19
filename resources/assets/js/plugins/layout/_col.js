export default {

  name: 'layout',
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
  div.innerHTML = "Приветики, хули.";
  document.body.appendChild(div);
  }
}
