require('./bootstrap');

import { createApp } from 'vue'



const app = createApp({});

// registers our HelloWorld component globally
app.component('home-component', require('./component/home/HomeComponent.vue').default);
app.component('chat-component', require('./component/chat/chatComponent.vue').default);
app.component('login-component', require('./component/login/LoginComponent.vue').default);
app.component('signup-component', require('./component/signup/SignupComponent.vue').default);


// mount the app to the DOM
app.mount('#app');