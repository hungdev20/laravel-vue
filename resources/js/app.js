import { createApp } from "vue";
import "./bootstrap";
import App from "./layouts/App.vue";
import store from "./store";
// import axios from 'axios'
import router from "./router";
import { library } from "@fortawesome/fontawesome-svg-core";
import { faSortUp } from "@fortawesome/free-solid-svg-icons";
import { faSortDown } from "@fortawesome/free-solid-svg-icons";
import { faXmark } from "@fortawesome/free-solid-svg-icons";
import { faFilter } from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
library.add(faSortUp, faSortDown, faXmark, faFilter);

// customize clickOutside event handler
const clickOutside = {
    beforeMount: (el, binding) => {
        el.clickOutsideEvent = (event) => {
            // here I check that click was outside the el and his children
            if (!(el == event.target || el.contains(event.target))) {
                // and if it did, call method provided in attribute value
                binding.value();
            }
        };
        document.addEventListener("click", el.clickOutsideEvent);
    },
    unmounted: (el) => {
        document.removeEventListener("click", el.clickOutsideEvent);
    },
};
const app = createApp(App)
    .directive("click-outside", clickOutside)
    .component("font-awesome-icon", FontAwesomeIcon)
    .use(store);
app.use(router);
app.mount("#app");
