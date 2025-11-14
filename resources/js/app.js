import './bootstrap';
//import { initAjaxMenus } from './ajaxMenus';
import { enableDynamicLoading } from './ajaxMenus';
import { initAjaxForms,initUsuarios } from './ajaxForms';

import '@fortawesome/fontawesome-free/js/all.js';

document.addEventListener("DOMContentLoaded", () => {
    enableDynamicLoading();
    initAjaxForms();
    initUsuarios();
    document.querySelector('#home').click();
})
