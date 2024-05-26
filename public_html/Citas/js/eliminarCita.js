function eliminarCita(idCita) {
    if (confirm('¿Está seguro de que desea eliminar esta cita?')) {
        $.ajax({
            url: '../Calendario/eliminar_cita.php',
            type: 'POST',
            data: { id: idCita },
        })
        .done(function(response) {
            alert('La cita ha sido eliminada exitosamente');
            
            location.reload();
        })
        .fail(function(xhr, status, error) {
            alert('Error al eliminar la cita');
            console.error(xhr.responseText);
        });
    }
}