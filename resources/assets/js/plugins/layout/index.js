import './simple-grid.css'
import my_container from './_container'
import my_row       from './_row'
import my_col       from './_col'


export {
  my_container,
  my_row,
  my_col
}

const layout = {}


layout.install = function install (Vue) {
  Vue.component(my_container.name, my_container)
  Vue.component(my_row.name, my_row)
  Vue.component(my_col.name, my_col)
}

export default layout
