import './bootstrap';
import { createApp } from 'vue';
// import Dashboard from './components/admin/Dashboard.vue'
import LoginForm from './components/auth/Loginview.vue';
// import Sidebar from '/components/components/Sidebar.vue';
// createApp(App).mount('#app');

createApp(LoginForm).mount('#app');
