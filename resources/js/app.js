/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
window.axios = require('axios');

window.axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').getAttribute('content')
};

Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue').default
);

Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue').default
);

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue').default
);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
import Datepicker from 'vuejs-datepicker';
import Toasted from 'vue-toasted';
import BootstrapVue from 'bootstrap-vue'
import VueRouter from 'vue-router'
import Multiselect from 'vue-multiselect'

//import './custom.scss'

Vue.use(BootstrapVue)
Vue.use(Toasted)
Vue.use(VueRouter)

Vue.component('plan-component', require('./components/PlanComponent.vue').default);
Vue.component('workout-component', require('./components/WorkoutComponent.vue').default);
Vue.component('subscribe-component', require('./components/SubscribeComponent.vue').default);
Vue.component('mark-complete-component', require('./components/MarkCompleteComponent.vue').default);
Vue.component('profile', require('./components/Profile.vue').default);
Vue.component('password', require('./components/Password.vue').default);
Vue.component('plan-workout', require('./components/PlanWorkoutComponent.vue').default);
Vue.component('multiselect', Multiselect);
Vue.component('account', require('./components/Account.vue').default);

Vue.toasted.register('error', message => message, {
    position : 'bottom-center',
    duration : 1000
})

const router = new VueRouter({
  routes: [
    // {
    //   path: '/',
    //   component: Home
    // },
    // {
    //   path: '/workouts/create',
    //   component: CreateWorkout
    // }
  ]
});
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router: router
});

