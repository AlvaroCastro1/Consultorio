function eliminarEstudio(idEstudio, idDetalleEstudio, rowIndex) {
    const confirmacion = confirm("¿Estás seguro de que quieres eliminar este estudio?");
    console.log(idEstudio)
    
    
    if (confirmacion) {
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "eliminar_estudio.php", true);
        xhr.setRequestHeader("Content-Type", "application/json");
        xhr.onload = function() {
            if (xhr.status === 200) {
                alert("Estudio eliminado exitosamente");
                location.reload();
            } else {
                alert("Hubo un error al eliminar el estudio");
            }
        };
        xhr.send(JSON.stringify({ idEstudio: idEstudio, idDetalleEstudio: idDetalleEstudio }));
    }
}
