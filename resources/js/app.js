import './bootstrap';
//import { initAjaxMenus } from './ajaxMenus';
import { enableDynamicLoading } from './ajaxMenus';
import { initAjaxForms,initUsuarios } from './ajaxForms';

import '@fortawesome/fontawesome-free/js/all.js';
import TomSelect from 'tom-select';
import 'tom-select/dist/css/tom-select.css';
import 'tom-select/dist/css/tom-select.default.css';

import { initFullCalendar } from './fullcalendar';
window.initFullCalendar = initFullCalendar; 

// Inicializa el calendario si existe el elemento en el DOM


document.addEventListener("DOMContentLoaded", () => {
    enableDynamicLoading();
    initAjaxForms();
    initUsuarios();
    document.querySelector('#home').click();
})

window.initTomSelect = () => {
    document.querySelectorAll("select.tom").forEach(select => {
        if (!select.tomselect) {
            new TomSelect(select, {
                plugins: ['remove_button'],
                persist: false,
                create: false,
                maxItems: null,
                hidePlaceholder: true,

                render: {
                    item: function(data, escape) {
                        return `
                            <div class="ts-item-pill">
                                ${escape(data.text)}
                            </div>
                        `;
                    },
                    option: function(data, escape) {
                        return `
                            <div class="ts-option-strong">
                                ${escape(data.text)}
                            </div>
                        `;
                    }
                }
            });
        }
    });
};
