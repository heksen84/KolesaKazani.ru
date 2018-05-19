export default {

  name: 'my_row',
  mixins: [],

  directives: {
  },

  props: {
    id: String
  },

  computed: {
    classes () {
      return {
      }
    }
  },

  mounted () {
	   alert("row");
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
