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
      editable: false,
      selectable: true,
      events: events,
  
      dateClick: function(info) {
        document.getElementById('eventDate').value = info.dateStr;
        $('#addEventModal').modal('show');
        $('#addEventForm').trigger('reset');
        // Evento que se ejecuta cuando el modal se abre
        $('#addEventModal').on('show.bs.modal', function() {
          var fechaSeleccionada = $('#eventDate').val();
          console.log("Este es un mensaje de error");
          cargarHorarios('#eventTime', fechaSeleccionada);
        });

        // Evento que se ejecuta cuando cambia el valor del input
        $('#eventDate').on('change', function() {
          var fechaSeleccionada = $(this).val();
          cargarHorarios('#eventTime', fechaSeleccionada);
        });
        document.getElementById('eventDate').value = info.dateStr;
      },
  
      dayCellDidMount: function(info) {
        var date = info.date;
        var today = new Date(); // Obtener la fecha actual
        if (date.getFullYear() === today.getFullYear() && date.getMonth() === today.getMonth() && date.getDate() === today.getDate()) {
            // Si la fecha es igual a la fecha actual, cambiar el color de fondo a verde
            info.el.style.backgroundColor = '#CAFFBF';
            //info.el.style.backgroundColor = '#42AB49';
        }
        var count = counts.find(function(count) {
          return count.date === date.toISOString().split('T')[0];
          
        });
        if (count) {
          var color;
          if (count.count <= 1) {
            color = '#CAFFBF'; // verde personalizado
            //color = '#77DD77'; // verde personalizado
          } else if (count.count < mitadTotales) {
            color = '#FFB347'; // amarillo personalizado
          } else {
            color = '#FF6961'; // rojo personalizado
          }
          info.el.style.backgroundColor = color;
        }
        
      },
      
  
      eventClick: function(info) {
        var eventObj = info.event;
        var fechaHora = moment(eventObj.start).locale('es').format('D [de] MMMM [de] YYYY, HH:mm'); // Formatear la fecha y hora en español
        document.getElementById('eventInfo').textContent = 'Evento: ' + eventObj.title + '\nFecha y hora: ' + fechaHora;
        var idC = info.event.extendedProps.idCita;
        document.getElementById('ocultoIDPaciente').value=info.event.extendedProps.idPaciente;
        document.getElementById('ocultoEventDate').value=info.event.extendedProps.fechaCita;
        document.getElementById('ocultoEventTime').value=info.event.extendedProps.horaCita;
        document.getElementById('ocultoEventAttendance').value=info.event.extendedProps.asistenciaCita;
        
        document.getElementById('deleteButton').addEventListener('click', function() {
          $.ajax({
              url: 'eliminar_cita.php',
              type: 'POST',
              data: { id: idC },
          })
          .done(function(response) {
              // La petición se realizó con éxito
              alert('La cita ha sido eliminada exitosamente');
              $('#eventModal').modal('hide');
              location.reload();
          })
          .fail(function(xhr, status, error) {
              // Hubo un error en la petición
              alert('Error al eliminar la cita');
              console.error(xhr.responseText);
          });
      });
      
  
        document.getElementById('modifyButton').addEventListener('click', function() {
          // Abre el modal de modificación
          document.getElementById('editeventPatientId').value=document.getElementById('ocultoIDPaciente').value
          document.getElementById('editeventDate').value=document.getElementById('ocultoEventDate').value;
          $('#editEventModal').on('show.bs.modal', function() {
            var fechaSeleccionada = $('#editeventDate').val();
            cargarHorarios('#editeventTime', fechaSeleccionada, $('#ocultoEventTime').val().slice(0, -3));
          });
          
          $('#editeventDate').on('change', function() {
              var fechaSeleccionada = $(this).val();
              cargarHorarios('#editeventTime', fechaSeleccionada, $('#ocultoEventTime').val().slice(0, -3));
          });
          document.getElementById('editeventAttendance').checked = document.getElementById('ocultoEventAttendance').value == 1;

          $('#editEventModal').modal('show');
          document.getElementById('editsaveButton').addEventListener('click', function() {

          });
          
          
          
        });
  
        $('#eventModal').modal('show');
      }
    });
  
    calendar.render();
  });

  document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('saveButton').addEventListener('click', function() {
        // Obtener los valores de los campos del formulario
        var patientId = document.getElementById('eventPatientId').value;
        var eventDate = document.getElementById('eventDate').value;
        var eventTime = document.getElementById('eventTime').value;
        var eventAttendance = document.getElementById('eventAttendance').checked ? 1 : 0; // Convertir a 1 si está marcado, 0 si no
    
        // Validar campos vacíos
        if (!patientId || !eventDate || !eventTime) {
            alert('Por favor, completa todos los campos obligatorios.');
            return; // Detener la ejecución si algún campo está vacío
        }
    
        // Crear un objeto con los datos a enviar
        var data = {
            patientId: patientId,
            eventDate: eventDate,
            eventTime: eventTime,
            eventAttendance: eventAttendance
        };
    
        // Enviar los datos al archivo PHP utilizando AJAX
        $.ajax({
            url: 'guardar_cita.php', // Ruta al archivo PHP que procesará la inserción
            type: 'POST',
            data: data,
            success: function(response) {
                // Mostrar un mensaje de éxito o recargar la página
                alert('Cita guardada correctamente');
                location.reload(); // Recargar la página para mostrar la nueva cita en el calendario
            },
            error: function(xhr, status, error) {
                // Mostrar un mensaje de error en caso de fallo
                alert('Error al guardar la cita');
                console.error(xhr.responseText);
            }
        });
    });
});

