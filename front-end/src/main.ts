import { createApp } from 'vue'
import './style.css'
import App from './App.vue'

//pinia
import {createPinia} from "pinia";

//vue router
import router from "@/router.ts";

//vuetify
import 'vuetify/styles'
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components';
import * as directives from 'vuetify/directives';

const vuetify = createVuetify({
    components,
    directives,
})

const pinia = createPinia()

createApp(App)
    .use(router)
    .use(vuetify)
    .use(pinia)
    .mount('#app')

