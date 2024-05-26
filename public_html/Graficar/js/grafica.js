function cargarYMostrarGrafica(campo, idExpediente, divId, color) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        var response = JSON.parse(this.responseText);
        var fechas = response.fechas;
        var datos = response.datos;
        console.log(idExpediente);
        // Graficar los datos
        var trace = {
          x: fechas,
          y: datos,
          mode: 'lines+markers',
          type: 'scatter',
          line: {
            color: color // Usar el color especificado para la línea
          }
        };
  
        var data = [trace];
  
        var layout = {
          width: document.getElementById(divId).clientWidth,
          height: document.getElementById(divId).clientHeight
        };
  
        Plotly.newPlot(divId, data, layout);
      }
    };
    xhttp.open("GET", "obtener_datos.php?campo=" + campo + "&idExpediente=" + idExpediente, true);
    xhttp.send();
  }
  

  