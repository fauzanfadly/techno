import { createApp } from "vue";
import axios from "axios";
import App from "./App.vue";
import vuetify from "./plugins/vuetify";
import router from "./router";

window.axios = axios;

window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

const app = createApp(App);

app.use(vuetify);
app.use(router);
app.mount("#app");
