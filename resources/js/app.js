import { createApp } from "vue";
import axios from "axios";
import App from "./App.vue";
import vuetify from "./plugins/vuetify";
import router from "./router";
import AOS from "aos";
import "aos/dist/aos.css";
import { createHead } from "@vueuse/head";

window.axios = axios;

window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

AOS.init({
    duration: 1200,
    once: true,
});

const app = createApp(App);
const head = createHead();

app.use(vuetify);
app.use(router);
app.use(head);
app.mount("#app");
