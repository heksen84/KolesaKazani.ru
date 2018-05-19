import './simple-grid.css'
import container from './_container'
import row      from './_row'
import col      from './_col'

layout.install = function install (Vue) {
  Vue.component(container.name, container)
  Vue.component(row .name, row)
  Vue.component(col.name, col)
}

export default layout
