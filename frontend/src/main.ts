import './assets/main.css'

import { createApp } from 'vue'
import { createPinia } from 'pinia'
import Toast, { type PluginOptions, POSITION } from "vue-toastification";
import { useSessionStore } from '@/stores/session';

import App from './App.vue'
import router from './router'

const app = createApp(App)
const pinia = createPinia()

const toastOptions: PluginOptions = {
  position: POSITION.TOP_RIGHT,
};
app.use(Toast, toastOptions);
app.use(pinia)
app.use(router)

const sessionStore = useSessionStore();
sessionStore.initSession();

app.mount('#app')
