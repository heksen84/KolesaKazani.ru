import index from './index'

//index.data = "123123";
renderVueComponentToString(index, (err, res) => {
  print(res);
});
