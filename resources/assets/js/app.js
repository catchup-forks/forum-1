
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

window.events = new Vue();

window.flash = function(message) {
    window.events.$emit('flash', message);
};

window.lang = window.Vue.prototype.lang = require( '../../lang/sv.json' );

window.Vue.prototype.authorize = function(handler) {
    // Additional admin priviledges for example. If returning true, the user is authorized.

    let user = window.forum.user;

    return user ? handler(user) : false;
};

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('flash', require('./components/Flash.vue'));
Vue.component('reply', require('./components/Reply.vue'));
Vue.component('replies', require('./components/Replies.vue'));
Vue.component('favorite', require('./components/Favorite.vue'));
Vue.component('paginator', require('./components/Paginator.vue'));
Vue.component('avatar-form', require('./components/AvatarForm.vue'));
Vue.component('create-workout', require('./components/CreateWorkout.vue'));
Vue.component('get-my-position', require('./components/GetMyPosition.vue'));
Vue.component('subscribe-button', require('./components/SubscribeButton.vue'));
Vue.component('user-notifications', require('./components/UserNotifications.vue'));

Vue.component('thread-view', require('./pages/Thread.vue'));

const app = new Vue({
    el: '#app'
});
