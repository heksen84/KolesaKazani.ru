import './simple-grid.css'
import xcontainer from './_container'
import xrow from './_row'
import xcol from './_col'

const layout = {}

layout.install = function install (Vue) {
  Vue.component(xcontainer.name, xcontainer)
  Vue.component(xrow.name, xrow)
  Vue.component(xcol.name, xcol)
}

export {
  xcontainer,
  xrow,
  xcol
}

export default layout
