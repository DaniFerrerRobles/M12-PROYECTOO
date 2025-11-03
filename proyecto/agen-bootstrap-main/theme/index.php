<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enganchados Por El Futbol</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="position-relative">

<section class="position-relative text-center text-white" style="height: 100vh; overflow: hidden;">

    <!-- Imagen de fondo -->
    <img src="https://img2.wallspic.com/attachments/originals/2/5/6/8/3/138652-balon_de_futbol-juego_de_pelota-jugador_de_futbol-los_deportes_de_equipo-el_deporte_lugar-4200x2800.jpg" 
         class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover" 
         alt="Balón de fútbol sobre césped">

    <!-- Capa oscura semi-transparente -->
    <div class="position-relative d-flex flex-column justify-content-center align-items-center h-100 bg-dark bg-opacity-50 px-3">

        <h1 class="display-4 fw-bold mb-4">Bienvenido a Enganchados Por El Fútbol</h1>

        <?php if (!isset($_SESSION['user_id'])): ?>
            <!-- Usuario no logueado -->
            <p class="lead mb-4">¡Regístrate o inicia sesión para no perderte nada!</p>
            <div class="d-flex gap-3 flex-wrap justify-content-center">
                <a href="registro.php" class="btn btn-light text-dark btn-lg">Registro</a>
                <a href="login.php" class="btn btn-light text-dark btn-lg">Iniciar Sesión</a>
            </div>

        <?php else: ?>
            <!-- Usuario logueado -->
            <p class="lead mb-3">Hola, <?php echo $_SESSION['user_name']; ?>!</p>

            <div class="d-flex flex-wrap gap-3 justify-content-center align-items-center mb-3">

                <!-- Botón desplegable de ligas -->
                <div class="btn-group">
                    <button type="button" class="btn btn-light text-dark btn-lg dropdown-toggle" 
                            data-bs-toggle="dropdown" aria-expanded="false">
                        Seleccionar Liga
                    </button>
                    <ul class="dropdown-menu dropdown-menu-dark">
                        <li><a class="dropdown-item" href="admin/news/noticias.php?liga_id=1">La Liga (España)</a></li>
                        <li><a class="dropdown-item" href="admin/news/noticias.php?liga_id=2">Premier League</a></li>
                        <li><a class="dropdown-item" href="admin/news/noticias.php?liga_id=3">Serie A</a></li>
                        <li><a class="dropdown-item" href="admin/news/noticias.php?liga_id=4">Bundesliga</a></li>
                        <li><a class="dropdown-item" href="admin/news/noticias.php?liga_id=5">Ligue 1</a></li>
                        <li><a class="dropdown-item" href="admin/news/noticias.php?liga_id=6">Champions League</a></li>
                    </ul>
                </div>

                <!-- Botón para editar perfil -->
                <a href="user/edit_user.php?id=<?php echo $_SESSION['user_id']; ?>" 
                   class="btn btn-primary btn-lg">
                    Editar Mi Perfil
                </a>

                <!-- Botón panel admin (solo si es admin) -->
                <?php if ($_SESSION['user_rol'] === 'admin'): ?>
                    <a href="adminPanel.php" class="btn btn-warning btn-lg">Panel Administrador</a>
                <?php endif; ?>

                <!-- Botón cerrar sesión -->
                <a href="logout.php" class="btn btn-light text-dark btn-lg">Cerrar Sesión</a>
            </div>
        <?php endif; ?>

    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>