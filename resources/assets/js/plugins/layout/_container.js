export default {

  name: 'xcontainer',
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
    	alert("container");
  },

  watch: {
    dark () {
    }
  },

  render (h) {
  var div = document.createElement('div');
  div.innerHTML = "container";
  document.body.appendChild(div);
  }
}
