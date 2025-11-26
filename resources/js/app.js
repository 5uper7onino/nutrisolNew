import './bootstrap';
import '../css/app.css';
import '../css/fc-minty.css';
import tippy from "tippy.js";
import "tippy.js/dist/tippy.css";
import "tippy.js/animations/shift-away.css";
import Swal from 'sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

window.Swal = Swal;


//import { initAjaxMenus } from './ajaxMenus';
import { enableDynamicLoading } from './ajaxMenus';
import { initAjaxForms,initUsuarios } from './ajaxForms';

import TomSelect from 'tom-select';
import 'tom-select/dist/css/tom-select.css';
import 'tom-select/dist/css/tom-select.default.css';

import { initFullCalendar } from './fullcalendar';
import esLocale from '@fullcalendar/core/locales/es';
import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();
window.initFullCalendar = initFullCalendar;
window.tippy = tippy;

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

window.eliminarCita = async function(id) {
    console.log("Eliminando cita con ID:", id);
    const token = document.querySelector('meta[name="csrf-token"]').content;

    const confirmDelete = confirm("¿Seguro que quieres eliminar esta cita?");
    if (!confirmDelete) return;

    try {
        const response = await fetch(`/citas/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': token,
                'Accept': 'application/json'
            }
        });

        if (!response.ok) {
            throw new Error("No se pudo eliminar");
        }

        // Si usas fullcalendar como window.calendario
        if (window.calendario) {
            window.calendario.refetchEvents();
        }

        // Cerrar modal (si tienes un evento para eso)
        window.dispatchEvent(new CustomEvent('close-modal'));

    } catch (e) {
        alert("Error al eliminar: " + e.message);
    }
};

