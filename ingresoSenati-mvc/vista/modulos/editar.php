 <?php
session_start();

// Verificamos si la sesión está activa
if (!$_SESSION["validar"]) {
    header("location:index.php?action=login");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Usuario</title>
    <link rel="stylesheet" href="vista/assets/css/bootstrap.min.css">
    <style>
        body {
            margin: 0;
            padding: 20px;
            background-color: #f1f1f1;
            background: url(vista/css/bgg.jpg);
            background-repeat: no-repeat;
            background-repeat: no-repeat;
            background-position: center;
            background-attachment: fixed;
            background-size: cover;
        }
        .container {
            max-width: 700px;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-radius: 50px;
        }
        .alert {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center">Editar Usuario</h2>

        <!-- Mostrar mensaje si existe -->
        <?php if (isset($_SESSION["mensaje"])): ?>
            <div class="alert alert-info">
                <?php 
                    echo $_SESSION["mensaje"];
                    unset($_SESSION["mensaje"]); // Limpiamos el mensaje después de mostrarlo
                ?>
            </div>
        <?php endif; ?>

        <?php
        // Instanciamos el controlador
        $editar = new MvcControlador();

        // Mostrar el formulario con los datos actuales del usuario
        $editar->editarUsuarioControlador();

        // Procesar la actualización del usuario
        $editar->actualizarUsuarioControlador();
        ?>
    </div>
</body>
</html>
