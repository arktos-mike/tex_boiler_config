import 'viewerjs/dist/viewer.css';
import Viewer from 'v-viewer';
import Vue from 'vue';
  Vue.use(Viewer);
  Viewer.setDefaults({
    button: true,
    toolbar: true,
    interval: 3000,
    rotatable: true,
    scalable: false,
    loading: true
  })
export default ({
  });