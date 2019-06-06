import index from './views/index_ssr'

renderVueComponentToString(index, (err, res) => {
  print(res);
});
