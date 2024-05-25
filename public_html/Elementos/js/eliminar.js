function eliminarElementosIndividual(idElemento, rowIndex) {
    const confirmacion = confirm("¿Estás seguro de que quieres eliminar este elemento?");
    console.log(rowIndex)
    if (confirmacion) {
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "eliminarElemento.php", true);
        xhr.setRequestHeader("Content-Type", "application/json");
        xhr.onload = function() {
            if (xhr.status === 200) {
                alert("Elemento eliminado exitosamente");
                // Eliminar la fila de la tabla
                document.getElementById("tabla-ElementosIndividual").deleteRow(rowIndex);
            } else {
                alert("Hubo un error al eliminar el elemento");
            }
        };
        xhr.send(JSON.stringify({ idElemento: idElemento }));
    }
}
