<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Error de inicio de sesión</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6">
                <div class="alert alert-danger" role="alert">
                    <h4 class="alert-heading">Error de inicio de sesión</h4>
                    <p><?php echo isset($_GET['error']) ? $_GET['error'] : 'Hubo un problema al iniciar sesión. Por favor, inténtelo de nuevo.'; ?></p>
                    <hr>
                    <p class="mb-0">Vuelva a <a href="../login.html" class="alert-link">iniciar sesión</a>.</p>
                </div>
            </div>
        </div>
    </div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
