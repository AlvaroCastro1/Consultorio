import { idPaciente, idExpediente, obtenerDatosSession } from '../../Estudios/js/obtenerExpediente.js';

document.addEventListener('DOMContentLoaded', (event) => {
    obtenerDatosSession();
    cargarYMostrarGrafica('altura', idExpediente, 'cargarAltura', 'blue');
    cargarYMostrarGrafica('peso', idExpediente, 'cargarPeso', 'green');
    cargarYMostrarGrafica('indiceMasaCorporal', idExpediente, 'cargarMasaCorporal', 'red');
    cargarYMostrarGrafica('circunferenciaDelCraneo', idExpediente, 'cargarCircunferenciaCraneo', 'purple');
});


// Hacer la gráfica responsive en tiempo real
window.addEventListener('resize', function() {

    obtenerDatosSession();
   
   cargarYMostrarGrafica('altura', idExpediente, 'cargarAltura', 'blue');
   cargarYMostrarGrafica('peso', idExpediente, 'cargarPeso', 'green');
   cargarYMostrarGrafica('indiceMasaCorporal', idExpediente, 'cargarMasaCorporal', 'red');
   cargarYMostrarGrafica('circunferenciaDelCraneo', idExpediente, 'cargarCircunferenciaCraneo', 'purple');
});