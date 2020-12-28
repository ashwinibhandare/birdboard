require('./bootstrap');

import Vue from 'vue';
import VModal from 'vue-js-modal';
import { InertiaApp } from '@inertiajs/inertia-vue';
import { InertiaForm } from 'laravel-jetstream';
import PortalVue from 'portal-vue';
import axios from 'axios'
import VueAxios from 'vue-axios'

//Vue.mixin({ methods: { route } });
Vue.use(InertiaApp);
Vue.use(InertiaForm);
Vue.use(PortalVue);
Vue.use(VModal);
Vue.use(VueAxios, axios);
Vue.component('new-project-model', require('./components/NewProjectModel.vue').default);
Vue.component('dropdown', require('./components/Dropdown.vue').default);
var app = new Vue({
    el: '#app',
    data: {
        message: 'Hello Vue!'
    }
})

// new Vue({
//     render: (h) =>
//         h(InertiaApp, {
//             props: {
//                 initialPage: JSON.parse(app.dataset.page),
//                 resolveComponent: (name) => require(`./Pages/${name}`).default,
//             },
//         }),
// }).$mount(app);


