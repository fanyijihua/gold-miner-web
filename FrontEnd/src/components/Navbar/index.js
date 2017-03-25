import Navbar from './src/Navbar'

Navbar.install = function install(Vue) {
  Vue.component(Navbar.name, Navbar)
}

export default Navbar
