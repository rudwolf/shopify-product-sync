import { createApp } from 'vue';
import ProductSync from './components/ProductSync.vue';

const app = createApp({});
app.component('product-sync', ProductSync);
app.mount('#app');
