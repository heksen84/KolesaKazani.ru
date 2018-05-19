export default {

  name: 'contaner',
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
