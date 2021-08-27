

 require('./bootstrap');


window.Vue = require('vue');

import CKEditor from 'ckeditor4-vue';

Vue.use( CKEditor );
import 'vue-search-select/dist/VueSearchSelect.css';
import { ModelListSelect } from 'vue-search-select'
Vue.component('ModelListSelect', ModelListSelect);
Vue.component('example-component', require('./components/ExampleComponent.vue').default);



// const app = new Vue({
//     el: '#app',
// });
