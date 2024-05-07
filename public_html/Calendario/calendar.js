document.addEventListener('DOMContentLoaded', function() {
  var calendarEl = document.getElementById('calendar');

  var calendar = new FullCalendar.Calendar(calendarEl, {
      locale: 'es',
      editable: true,
      selectable: true,
      headerToolbar: {
          locale: 'es',
          left: 'prev,next today',
          center: 'title',
          right: 'dayGridMonth,timeGridDay,listMonth'
      },
      initialDate: fecha_actual,
      navLinks: true,
      businessHours: false,
      events: events,

      dateClick: function(info) {
          
          $('#addEventModal').modal('show');
          $('#addEventForm').trigger('reset');
          document.getElementById('eventDate').value = info.dateStr;
      },

      dayCellDidMount: function(info) {
          var date = info.date;
          var today = new Date();
          if (date.toDateString() === today.toDateString()) {
              info.el.style.backgroundColor = '#CAFFBF';
          }
          var count = counts.find(function(count) {
              return count.date === date.toISOString().split('T')[0];
          });
          if (count) {
              var color = count.count <= mitadTotales/2 ? '#CAFFBF' : count.count < mitadTotales ? '#FFB347' : '#FF6961';
              info.el.style.backgroundColor = color;
          }
      },

      eventClick: function(info) {
          var eventObj = info.event;
          var fechaHora = moment(eventObj.start).locale('es').format('D [de] MMMM [de] YYYY, HH:mm');
          document.getElementById('eventInfo').textContent = 'Evento: ' + eventObj.title + '\nFecha y hora: ' + fechaHora;
          document.getElementById('ocultoIdCita').value = eventObj.extendedProps.idCita;
          document.getElementById('ocultoIDPaciente').value = eventObj.extendedProps.idPaciente;
          document.getElementById('ocultoEventDate').value = eventObj.extendedProps.fechaCita;
          document.getElementById('ocultoEventTime').value = eventObj.extendedProps.horaCita;
          document.getElementById('ocultoEventAttendance').value = eventObj.extendedProps.asistenciaCita;

          document.getElementById('deleteButton').addEventListener('click', function() {
              if (confirm('¿Estás seguro de que deseas eliminar la cita?')) {
                  $.ajax({
                          url: 'eliminar_cita.php',
                          type: 'POST',
                          data: { id: eventObj.extendedProps.idCita },
                      })
                      .done(function(response) {
                          alert('La cita ha sido eliminada exitosamente');
                          $('#eventModal').modal('hide');
                          location.reload();
                      })
                      .fail(function(xhr, status, error) {
                          alert('Error al eliminar la cita');
                          console.error(xhr.responseText);
                      });
              }
          });

          document.getElementById('modifyButton').addEventListener('click', function() {
              document.getElementById('editeventPatientId').value = document.getElementById('ocultoIDPaciente').value;
              document.getElementById('editeventDate').value = document.getElementById('ocultoEventDate').value;
              var fechaInicial = $('#ocultoEventDate').val();
              $('#editEventModal').on('show.bs.modal', function() {
                  var fechaSeleccionada = $('#editeventDate').val();
                  cargarHorarios('#editeventTime', fechaSeleccionada, fechaInicial, $('#ocultoEventTime').val().slice(0, -3));
              });

              $('#editeventDate').on('change', function() {
                  var fechaSeleccionada = $(this).val();
                  cargarHorarios('#editeventTime', fechaSeleccionada, fechaInicial, $('#ocultoEventTime').val().slice(0, -3));
              });

              document.getElementById('editeventAttendance').checked = document.getElementById('ocultoEventAttendance').value == 1;
              $('#editEventModal').modal('show');

              document.getElementById('editsaveButton').addEventListener('click', function() {
                  var patientId = document.getElementById('editeventPatientId').value;
                  var eventDate = document.getElementById('editeventDate').value;
                  var eventTime = document.getElementById('editeventTime').value;
                  var eventAttendance = document.getElementById('editeventAttendance').checked ? 1 : 0;

                  if (!patientId || !eventDate || !eventTime) {
                      alert('Por favor, completa todos los campos obligatorios.');
                      return;
                  }

                  var data = {
                      citaId: eventObj.extendedProps.idCita,
                      patientId: patientId,
                      eventDate: eventDate,
                      eventTime: eventTime,
                      eventAttendance: eventAttendance
                  };

                  $.ajax({
                      url: 'modificar_cita.php',
                      type: 'POST',
                      data: data,
                      success: function(response) {
                          alert('Cita Modificada correctamente');
                          location.reload();
                      },
                      error: function(xhr, status, error) {
                          alert('Error al guardar la cita');
                          console.error(xhr.responseText);
                      }
                  });
              });
          });

          $('#eventModal').modal('show');
      }
  });

  calendar.render();

  document.getElementById('saveButton').addEventListener('click', function() {
      var patientId = document.getElementById('eventPatientId').value;
      var eventDate = document.getElementById('eventDate').value;
      var eventTime = document.getElementById('eventTime').value;
      var eventAttendance = document.getElementById('eventAttendance').checked ? 1 : 0;

      if (!patientId || !eventDate || !eventTime) {
          alert('Por favor, completa todos los campos obligatorios.');
          return;
      }

      var data = {
          patientId: patientId,
          eventDate: eventDate,
          eventTime: eventTime,
          eventAttendance: eventAttendance
      };

      $.ajax({
          url: 'guardar_cita.php',
          type: 'POST',
          data: data,
          success: function(response) {
              alert('Cita Guardada correctamente');
              location.reload();
          },
          error: function(xhr, status, error) {
              alert('Error al guardar la cita');
              console.error(xhr.responseText);
          }
      });
  });
});
