function modificarCita(rowIndex) {
    // Obtén la tabla y la fila correspondiente
    var table = document.getElementById('tabla-Citas');
    var row = table.rows[rowIndex];

    // Verifica si la fila existe y tiene al menos 5 celdas
    if (row && row.cells.length >= 5) {
        // Recupera los valores de las celdas de la fila
        var idCita = row.cells[0].innerText;
        var idPacienteC = row.cells[1].innerText;
        var fecha = row.cells[2].innerText;
        var hora = row.cells[3].innerText;
        var asistencia = row.cells[4].innerText == 'Asistió';
        console.log('Texto de la celda:', row.cells[4].innerText);


        // Obtén los elementos del modal por su id
        var idCitaInput = document.getElementById('input-idCita');
        var idPacienteInput = document.getElementById('input-IDpacienteModificar');
        var fechaInput = document.getElementById('eventDateModificar');
        var horaInput = document.getElementById('eventTimeModificar');
        var asistenciaInput = document.getElementById('eventAttendanceModificar');
        var fechaInputOculto = document.getElementById('ocultoEventDate');
        var horaInputOculto = document.getElementById('ocultoEventTime');

        // Verifica si los elementos existen antes de intentar establecer su valor
        if (idCitaInput && idPacienteInput && fechaInput && horaInput && asistenciaInput) {
            // Coloca los datos de la fila en los campos del modal
            idCitaInput.value = idCita;
            idPacienteInput.value = idPacienteC;
            fechaInput.value = fecha;
            horaInput.value = hora;
            asistenciaInput.checked = asistencia;
            fechaInputOculto.value = fecha;
            horaInputOculto.value = hora;
            

            // Abre el modal
            $('#modalModificar').modal('show');
        } else {
            console.error('Alguno de los elementos input no se encontró.');
        }
    } else {
        console.error('La fila o las celdas no están definidas correctamente.');
    }
}
