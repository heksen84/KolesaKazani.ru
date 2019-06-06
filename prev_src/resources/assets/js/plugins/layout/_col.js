export default {

  name: 'xcol',
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
	alert("col");
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
