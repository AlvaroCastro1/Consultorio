<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Página de bienvenida</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=DynaPuff:wght@400..700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="assets/css/LoginStyles.css">
</head>
<body>
    <div class="container2 mt-5">
        <?php if (isset($_SESSION['nombre_usuario'])): ?>
            <h1 class="text-center mb-5 titulo">¡Bienvenido, <?php echo htmlspecialchars($_SESSION['nombre_usuario']); ?>!</h1>
            <div class="text-center">
                <a href="../Login/logout.php" class="btn btn-danger">Cerrar Sesión</a>
            </div>    
        <?php else: ?>
            <h1 class="text-center mb-5 titulo">¡Bienvenido!</h1>
            <h3 class="text-center mb-5">Por favor, inicie sesión para continuar.</h3>
            <div class="text-center">
                <a href="./Login/login.php" class="btn btn-primary">Iniciar Sesión</a>
            </div>
        <?php endif; ?>
        <div class="espacio-final"></div>
        <div class="text-center">
            <button class="btn" onclick="window.location.href='./Login/index.html'"><i class="fas fa-child"></i> Inicio</button>
            <button type="button" class="btn btn-secondary ms-3" onclick="window.location.href='./configuracion/index.html'">Configuración</button>
        </div>
      </div>
      <div class="espacio-final"></div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
