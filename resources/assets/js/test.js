import test from './test.vue';

renderVueComponentToString(test, (err, res) => {
  print(res);
});
