export var idPaciente = null;
export var idExpediente = null;

export function obtenerDatosSession() {
    const datos = JSON.parse(sessionStorage.getItem('datosPaciente'));

    if (datos) {
        idPaciente = datos.idPacienteE;
        idExpediente = datos.idExpedienteE;
        console.log("se obtuvieron los datos idPaciente: ", idPaciente, "idExpediente: ", idExpediente);
    } else {
        alert("Su sesión ya expiró o no la ha iniciado");
        window.location.href = '../index.php';
    }
}


export function verificarSesion(idE) {
    if (idE === null) {
        alert("Su sesión ya expiró o no la ha iniciado");
        window.location.href = '../index.php';
        return false;
    }
    return true;
}