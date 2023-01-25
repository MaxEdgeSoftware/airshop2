require('./bootstrap');

window.Vue = require('vue').default;
const moment = require('moment');
Vue.use(moment)

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('recent-chats', require('./components/RecentChats.vue').default);
Vue.component('chat-with', require('./components/ChatWith.vue').default);


const app = new Vue({
    el: '#app',
});
