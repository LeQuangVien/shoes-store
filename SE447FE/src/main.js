import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import Client from './Layout/Wrapper/MasterClient.vue'
import Auth from './Layout/Wrapper/AuthClient.vue'
import Default from './Layout/Wrapper/MasterRocker.vue'
import Admin from './Layout/Wrapper/MasterAdmin.vue'
import Toaster from "@meforma/vue-toaster"
import AuthAdmin from './Layout/Wrapper/AuthAdmin.vue'

const app = createApp(App)

app.use(router, Toaster)
app.component("client-layout", Client);
app.component("auth-layout", Auth);
app.component("default-layout", Default);
app.component("admin-layout", Admin);
app.component("authadmin-layout", AuthAdmin);

app.mount("#app")