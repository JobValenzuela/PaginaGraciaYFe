import { createApp } from 'vue'
import { createPinia } from 'pinia'

import App from './App.vue'
import router from './router'
import piniaPluginPersistedstate from 'pinia-plugin-persistedstate';
import 'vuetify/styles'
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'

import '@mdi/font/css/materialdesignicons.css'

import axios from 'axios'
import env from './env'

axios.defaults.headers.common["Cache-Control"] = "no-cache";
axios.defaults.headers.common["Pragma"] = "no-cache";
axios.defaults.headers.common["Expires"] = "0";
axios.defaults.baseURL = env.API_URL

const app = createApp(App)

const vuetify = createVuetify({
    components,
    directives,
    theme: {
      themes: {
        light: {
          dark: false,
          colors: {
            primary: '#f8f8f8',
            secondary: '#1e1e1e',
            GYF: '#5038b2',
            GYF2: '#5038b2',
            hovermenu: '#BDBDBD',
            botones: '#5038b2'
          }
        },
        dark: {
          light: false,
          colors: {
            primary: '#1e1e1e',
            secondary: '#f1f1f1',
            GYF: '#5038b2',
            GYF2: '#031a61',
            hovermenu: '#2d2d2d',
            botones: '#5038b2'
          }
        },
      },
    }
  })
const pinia = createPinia()
pinia.use(piniaPluginPersistedstate)
app.use(pinia)
app.use(router)
app.use(vuetify)

app.mount('#app')
