import './bootstrap';
import { createApp } from "vue";
import ThemeSwitcher from "./Components/ThemeSwitcher";

const app = createApp({})
app.component('theme-switcher', ThemeSwitcher)
app.mount('#app');