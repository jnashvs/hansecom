import './assets/main.css'

import { createApp } from 'vue'
import { createPinia } from 'pinia'
import Toast, { type PluginOptions, POSITION } from "vue-toastification";

import App from './App.vue'
import router from './router'

const app = createApp(App)

const toastOptions: PluginOptions = {
  position: POSITION.TOP_RIGHT,
};
app.use(Toast, toastOptions);
app.use(createPinia())
app.use(router)

app.mount('#app')
