<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8' />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Gráficas</title>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="js/plotly-2.30.0.min.js"></script>
    <script src="grafica.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DynaPuff:wght@400..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/graficarStyles.css">
    <link rel="stylesheet" href="../assets/css/barraNav.css">
    <script src="../assets/js/header.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <script>
                // Llamar a la función para cargar y mostrar las gráficas
        var idExpediente = 1; // ID del expediente deseado
        
        cargarYMostrarGrafica('altura', idExpediente, 'cargarAltura', 'blue');
        cargarYMostrarGrafica('peso', idExpediente, 'cargarPeso', 'green');
        cargarYMostrarGrafica('indiceMasaCorporal', idExpediente, 'cargarMasaCorporal', 'red');
        cargarYMostrarGrafica('circunferenciaDelCraneo', idExpediente, 'cargarCircunferenciaCraneo', 'purple');
    </script>
    <script>
        const navItems = [
            {name: "Control de crecimiento", uri: "..//Control/control.html"},
            {name: "Gráficas", uri: "..//Graficar/index.html"}
        ];

        createHeader(navItems);
    </script>
    <div class="container2 mt-5">
        <div class="panel panel-primary border-panel">
            <div class="titulo text-center">
                <h1>Gráficas de crecimiento</h1>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="tituloAltura">
                            <h3>Altura</h3>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div id="cargarAltura"></div>
                    </div>
                    <div class="col-sm-12">
                        <div class="tituloPeso">
                            <h3>Peso</h3>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div id="cargarPeso"></div>
                    </div>
                    <div class="col-sm-12">
                        <div class="tituloMasaCorporal">
                            <h3>Masa Corporal</h3>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div id="cargarMasaCorporal"></div>
                    </div>
                    <div class="col-sm-12">
                        <div class="tituloCircunferenciaDelCraneo">
                            <h3>Circunferencia Del Craneo</h3>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div id="cargarCircunferenciaCraneo"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="espacio-final"></div>
  <footer>
        <div class="container3">
            <p>Pie de página</p>
        </div>
    </footer>
    <script>
        // Hacer la gráfica responsive en tiempo real
        window.addEventListener('resize', function() {
             // Llamar a la función para cargar y mostrar las gráficas
            var idExpediente = 1; // ID del expediente deseado
            
            cargarYMostrarGrafica('altura', idExpediente, 'cargarAltura', 'blue');
            cargarYMostrarGrafica('peso', idExpediente, 'cargarPeso', 'green');
            cargarYMostrarGrafica('indiceMasaCorporal', idExpediente, 'cargarMasaCorporal', 'red');
            cargarYMostrarGrafica('circunferenciaDelCraneo', idExpediente, 'cargarCircunferenciaCraneo', 'purple');
        });
    </script>
    
    
</body>
</html>
<?php
// Obtener el valor de idExpediente de la URL
$idExpediente = $_GET['idExpediente'] ?? null;
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8' />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Gráficas</title>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="js/plotly-2.30.0.min.js"></script>
    <script src="grafica.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DynaPuff:wght@400..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/graficarStyles.css">
    <link rel="stylesheet" href="/assets/css/barraNav.css">
    <script src="/assets/js/header.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <script>
        var idExpediente = <?php echo json_encode($idExpediente); ?>;
        if (idExpediente !== null) {
                // Llamar a la función para cargar y mostrar las gráficas con idExpediente
                cargarYMostrarGrafica('altura', idExpediente, 'cargarAltura', 'blue');
                cargarYMostrarGrafica('peso', idExpediente, 'cargarPeso', 'green');
                cargarYMostrarGrafica('indiceMasaCorporal', idExpediente, 'cargarMasaCorporal', 'red');
                cargarYMostrarGrafica('circunferenciaDelCraneo', idExpediente, 'cargarCircunferenciaCraneo', 'purple');
            }else{
                <?php echo 'Error: El parámetro idExpediente no se ha especificado.'?>;
            }            
    </script>
    <nav class="navbar navbar-expand-lg navbar-light bg-primary-custom">
        <div class="container">
            <a class="navbar-brand texto-gris-claro" href="..//Expediente/expediente.html" style="font-size: 20px; font-weight: bold; ">Expediente Médico</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link texto-gris-claro" href="..//Control/control.html" onclick="abrirPagina('control')">Control de crecimiento</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link texto-blanco-activo" href="..//Graficar/index.html" onclick="abrirPagina('index')">Gráficas</a>
                    </li>  
                </ul>
            </div>
        </div>
    </nav>
    <div class="container2 mt-5">
        <div class="panel panel-primary border-panel">
            <div class="titulo text-center">
                <h1>Gráficas de crecimiento</h1>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="tituloAltura">
                            <h3>Altura</h3>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div id="cargarAltura"></div>
                    </div>
                    <div class="col-sm-12">
                        <div class="tituloPeso">
                            <h3>Peso</h3>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div id="cargarPeso"></div>
                    </div>
                    <div class="col-sm-12">
                        <div class="tituloMasaCorporal">
                            <h3>Masa Corporal</h3>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div id="cargarMasaCorporal"></div>
                    </div>
                    <div class="col-sm-12">
                        <div class="tituloCircunferenciaDelCraneo">
                            <h3>Circunferencia Del Craneo</h3>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div id="cargarCircunferenciaCraneo"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="espacio-final"></div>
  <footer>
        <div class="container3">
            <p>Pie de página</p>
        </div>
    </footer>
    <script>
        // Hacer la gráfica responsive en tiempo real
        window.addEventListener('resize', function() {
             // Llamar a la función para cargar y mostrar las gráficas
            var idExpediente = 1; // ID del expediente deseado
            
            cargarYMostrarGrafica('altura', idExpediente, 'cargarAltura', 'blue');
            cargarYMostrarGrafica('peso', idExpediente, 'cargarPeso', 'green');
            cargarYMostrarGrafica('indiceMasaCorporal', idExpediente, 'cargarMasaCorporal', 'red');
            cargarYMostrarGrafica('circunferenciaDelCraneo', idExpediente, 'cargarCircunferenciaCraneo', 'purple');
        });
    </script>
    
    
</body>
</html>
