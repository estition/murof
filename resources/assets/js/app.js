
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import flash from './components/Flash.vue';
import paginator from './components/Paginator.vue';
import notifications from './components/UserNotifications.vue';
import avatarform from './components/AvatarForm.vue';
import wysiwyg from './components/Wysiwyg.vue';
import threadview from './pages/Threads.vue';


Vue.component('flash', flash);
Vue.component('paginator', paginator);
Vue.component('user-notifications', notifications);
Vue.component('avatar-form', avatarform);
Vue.component('wysiwyg', wysiwyg);

Vue.component('thread-view', threadview);

const app = new Vue({
    el: '#app'
});