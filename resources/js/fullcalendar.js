import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import interactionPlugin from '@fullcalendar/interaction';


export function initFullCalendar(containerId = 'calendar') {
    const calendarEl = document.getElementById(containerId);
    if (!calendarEl) return;

    const calendar = new Calendar(calendarEl, {
        plugins: [dayGridPlugin, timeGridPlugin, interactionPlugin],
        initialView: 'dayGridMonth',
        selectable: true,
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },

        // 🔥 Cargar eventos desde Laravel
        events: '/citas/data',

        // 🔥 Click en fecha -> abrir modal
        dateClick: function(info) {
            window.dispatchEvent(
                new CustomEvent("open-modal", {
                    detail: {
                        title: "Nueva Cita",
                        url: "/citas/create?fecha=" + info.dateStr,
                        maxWidth: "max-w-4xl"
                    }
                })
            );
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
