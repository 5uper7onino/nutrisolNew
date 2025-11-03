import './bootstrap';
//import { initAjaxMenus } from './ajaxMenus';
import { enableDynamicLoading } from './ajaxMenus';
import { initAjaxForms,initUsuarios } from './ajaxForms';

document.addEventListener("DOMContentLoaded", () => {
    enableDynamicLoading();
    initAjaxForms();
    initUsuarios();
})
