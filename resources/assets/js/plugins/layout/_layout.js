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
  },

  watch: {
    dark () {
    }
  },

  render (h) {
  var div = document.createElement('div');
  div.innerHTML = "Здрасти.";
  document.body.appendChild(div);
  }
}
