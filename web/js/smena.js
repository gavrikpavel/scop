(function ($) {
    let smenaEvents = $('#smena-events').data('smena-events');

    document.addEventListener('DOMContentLoaded', function() {
        let calendarEl = document.getElementById('calendar');
        let calendar = new FullCalendar.Calendar(calendarEl, {
            plugins: [ 'interaction', 'dayGrid', 'timeGrid' ],
            defaultView: 'dayGridMonth',
            locale: 'ru',
            firstDay: 1,
            header: {
                left: 'prev,next today',
                center: 'title',
                right: '' //dayGridMonth,timeGridWeek
            },
            displayEventEnd: true,
            eventMouseEnter: function(info) {
                info.el.style.cursor = 'pointer';
            },
            eventClick: function(info) {
                let options = {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric',
                    timezone: 'UTC',
                    hour: 'numeric',
                    minute: 'numeric',
                };
                let startSmena = 'Приняли смену - ' + info.event.start.toLocaleString("ru", options);
                let endSmena = '';

                if (info.event.end !== undefined) {
                    endSmena = 'Сдали смену - ' + info.event.end.toLocaleString();
                }
                Swal.fire({
                    customClass: {
                        content: 'content-class-swal',
                    },
                    title: info.event.title,
                    text: startSmena + ' ' +  endSmena,
                });
            },

           events: smenaEvents,
        });
        calendar.render();
    });
})(jQuery);


