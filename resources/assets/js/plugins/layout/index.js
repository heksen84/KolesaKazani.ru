import layout from './_layout'
import row    from './_row'
import col    from './_col'

layout.install = function install (Vue) {
  Vue.component(layout.name, layout)
}

export default layout
