import Timeline from './src/Timeline'

Timeline.install = function install(Vue) {
  Vue.component(Timeline.name, Timeline)
}

export default Timeline
