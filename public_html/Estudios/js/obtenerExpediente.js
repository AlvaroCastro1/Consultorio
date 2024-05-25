export var idPaciente = null;
export var idExpediente = null;

export function obtenerDatosSession() {
    const datos = JSON.parse(sessionStorage.getItem('datosPaciente'));

    if (datos) {
        idPaciente = datos.idPacienteE;
        idExpediente = datos.idExpedienteE;
        console.log("se obtuvieron los datos idPaciente: ", idPaciente, "idExpediente: ", idExpediente);
    } else {
        console.log('No se encontraron datos en sessionStorage');
    }
}
