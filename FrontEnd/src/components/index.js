import Articles from './Articles'
import Navbar from './Navbar'
import Footer from './Footer'
import Popover from './Popover'
import Card from './Card'

const components = [
  Articles,
  Navbar,
  Footer,
  Popover,
  Card,
]

const install = function install(Vue) {
  if (install.installed) return

  components.forEach((component) => {
    Vue.component(component.name, component)
  })
}

export default {
  install,
}
