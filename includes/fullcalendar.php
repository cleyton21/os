<link href='../fullcalendar/packages/core/main.min.css' rel='stylesheet' />
<link href='../fullcalendar/packages/daygrid/main.min.css' rel='stylesheet' />
<link href='../fullcalendar/packages/timegrid/main.min.css' rel='stylesheet' />
<link href='../fullcalendar/packages/list/main.min.css' rel='stylesheet' />

<style>
  #calendar {
    max-width: 1000px;
    max-height: 800px;
    margin: 0 auto;
  }
</style>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

      var calendar = new FullCalendar.Calendar(calendarEl, {
      eventClick: function(info) {
      alert('Incidente: ' + info.event.title);
    // change the border color just for fun
      info.el.style.borderColor = 'red';
      },
      buttonText: {
                today: 'hoje',
                month: 'mês',
                week: 'semana',
                day: 'dia',
                listMonth: 'lista'
      },
      header: {
        right: 'dayGridMonth, timeGridWeek, timeGridDay, listMonth',
        left: 'prevYear, prev, next, nextYear, today',
        // left: 'prev,next today myCustomButton',
        center: 'title',
        // right: 'dayGridMonth,timeGridWeek,timeGridDay'
      },
      locale: 'pt-br',
      plugins: [ 'resourceDayGrid, interaction', 'dayGrid', 'timeGrid', 'list' ],
      // defaultView: 'resourceDayGridDay',
      // defaultDate: '2019-04-12',
      editable: true,
      eventLimit: false, // allow "more" link when too many events
      events: 'http://localhost/os/includes/eventos.php', //carrega os dados do caledário do banco de dados
    });
    calendar.render();
  });
</script>

<div id='calendar'></div>

<script src='../fullcalendar/packages/core/main.min.js'></script>
<script src='../fullcalendar/packages/interaction/main.min.js'></script>
<script src='../fullcalendar/packages/daygrid/main.min.js'></script>
<script src='../fullcalendar/packages/timegrid/main.min.js'></script>
<script src='../fullcalendar/packages/list/main.min.js'></script>
<!-- <script src='../fullcalendar/packages/core/locales/pt-br.js'></script> -->
