import axios from "axios";
import "bootstrap/dist/js/bootstrap";
import "@popperjs/core/dist/umd/popper";

window.axios = axios;

window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
