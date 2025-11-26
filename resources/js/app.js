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

window.inicializarCalculadora = function () {

    document.querySelectorAll('.calc-input').forEach(el => {
        el.addEventListener('input', calcularValores);
    });

    function calcularValores() {
        console.log("SDFSDFDSFFDSFSDFS");
        let peso    = parseFloat(document.getElementById('peso')?.value) || 0;
        let altura  = parseFloat(document.getElementById('altura')?.value) || 0;
        let cintura = parseFloat(document.getElementById('cintura')?.value) || 0;
        let cadera  = parseFloat(document.getElementById('cadera')?.value) || 0;
        let cuello  = parseFloat(document.getElementById('cuello')?.value) || 0;
        let sexo    = document.getElementById('sexo')?.value || 'H';

        if (peso > 0 && altura > 0) {
            let altura_m = altura / 100;
            document.getElementById('imc').value = (peso / (altura_m ** 2)).toFixed(2);
        }

        if (cintura > 0 && cadera > 0) {
            document.getElementById('icc').value = (cintura / cadera).toFixed(2);
        }

        if (cintura > 0 && cuello > 0 && altura > 0) {
            let igc = 0;

            if (sexo === 'H') {
                igc = 495 / (
                    1.0324
                    - 0.19077 * Math.log10(cintura - cuello)
                    + 0.15456 * Math.log10(altura)
                ) - 450;
            } else if (cadera > 0) {
                igc = 495 / (
                    1.29579
                    - 0.35004 * Math.log10(cintura + cadera - cuello)
                    + 0.22100 * Math.log10(altura)
                ) - 450;
            }

            document.getElementById('igc').value = igc.toFixed(2);
        }
    }
};

window.miFuncion = function () {
    console.log("🔥 miFuncion() ejecutada desde Alpine");
};

window.imageUploader = (initialPreview = '') => ({
    preview: initialPreview,
    selectImage() {
        this.$refs.fileInput.click();
    },
    handleFileChange(e) {
        const file = e.target.files[0];
        if (file) {
            this.preview = URL.createObjectURL(file);
        }
    }
});
