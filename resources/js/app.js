import './bootstrap';
import { initAjaxMenus } from './ajaxMenus';
import { initAjaxForms,initUsuarios } from './ajaxForms';

document.addEventListener("DOMContentLoaded", () => {
    initAjaxMenus();
    initAjaxForms();
    initUsuarios();
})