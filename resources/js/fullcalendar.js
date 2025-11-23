import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import interactionPlugin from '@fullcalendar/interaction';


export function initFullCalendar(containerId = 'calendar') {
    const calendarEl = document.getElementById(containerId);
    if (!calendarEl) return;

    const calendar = new Calendar(calendarEl, {
        plugins: [dayGridPlugin, timeGridPlugin, interactionPlugin],
        locale: 'es-Es',
        initialView: 'timeGridWeek',
        slotMinTime: "08:00:00",
        slotMaxTime: "19:30:00",
        slotDuration: "00:30:00",
        expandRows: false,
        allDaySlot: false,
        hiddenDays: [0],
        nowIndicator: true,
        nowIndicatorSnap: true,
        eventTimeFormat: {
            hour: '2-digit',
            minute: '2-digit',
            meridiem: true // pon true si quieres AM/PM
        },


        dayCellClassNames(info) {
            const today = new Date();
            today.setHours(0,0,0,0);
    
            if (info.date < today) {
                return ['fc-day-disabled']; // clase personalizada
            }
        },
        eventDidMount: function(info) {

            // Construir contenido del tooltip
            const contenido = `
                <strong>${info.event.title}</strong><br>
                Inicio: ${info.event.start.toLocaleString()}<br>
                Fin: ${info.event.end.toLocaleString()}
            `;
        
            // Tooltip con Tippy.js
            tippy(info.el, {
                content: contenido,
                allowHTML: true,
                theme: "light-border",
                placement: "top",
                animation: 'shift-away',
                duration: 200,
                theme: "glass",
            });
        }
        ,         
    
        dateClick(info) {
            //if (info.date < new Date()) return;
            const now = new Date();

            if (info.date < now) {
                alert("No se puede calendarizar en días pasados.");
                return;
            }
            //abrirModal(info);
        },
    
        selectAllow(info) {
            return info.start >= new Date();
        },
    
        eventAllow(dropInfo) {
            return dropInfo.start >= new Date();
        },
        height: "auto",
        expandRows: true,
        selectable: true,        // permite seleccionar
        selectMirror: true,      // ilumina visualmente el slot
        unselectAuto: true, 
        headerToolbar: {
            right: 'prev,next,today',
            center: 'title',
            left:''
        },buttonText: {
            today: 'Hoy',
            week: 'Semana',
            day: 'Día',
            month: 'Mes'
        },
        

        // 🔥 Cargar eventos desde Laravel
        events: '/citas/data',

        // 🔥 Click en fecha -> abrir modal
        select: function(info) {
            console.log("INICIO:", info.startStr);
            console.log("FIN:", info.endStr);
        
            window.dispatchEvent(new CustomEvent("open-modal", {
                detail: {
                    title: "Nueva Cita",
                    url: "/citas/create?inicio=" + info.startStr + "&fin=" + info.endStr,
                    maxWidth: "max-w-4xl"
                }
            }));
        },
        
        eventClick: function(info) {

            // Mostramos modal de confirmación usando tu sistema
            window.dispatchEvent(new CustomEvent('open-modal', {
                detail: {
                    title: 'Eliminar Cita',
                    url: '/citas/' + info.event.id + '/confirm-delete',
                    maxWidth: 'max-w-md'
                }
            }));

        },

    });

    calendar.render();

    // Guardamos calendario globalmente por si necesitas refrescarlo
    window.calendarioCitas = calendar;
}
