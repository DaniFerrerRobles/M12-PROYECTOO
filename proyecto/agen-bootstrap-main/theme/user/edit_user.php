<?php
session_start();
include '../config.php'; // Conexión a la base de datos

// Solo el usuario actual puede editar su perfil
$usuario_id = $_SESSION['user_id'];

// Obtenemos datos actuales del usuario
$stmt = $mysqli->prepare("SELECT nombre_usuario, email FROM USUARIOS WHERE id=?");
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$usuario = $stmt->get_result()->fetch_assoc();

// Si no existe el usuario, redirige al inicio
if (!$usuario) {
    header("Location: ../index.php");
    exit;
}

// Recibir datos del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre_usuario'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (!empty($password)) {
        //Si ha cambiado la contraseña lo actualizamos con la nueva contraseña
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $mysqli->prepare("UPDATE USUARIOS SET nombre_usuario=?, email=?, password=? WHERE id=?");
        $stmt->bind_param("sssi", $nombre, $email, $hashed_password, $usuario_id);
    } else {
        //Si NO ha cambiado la contraseña lo actualizamos sin nueva contraseña
        $stmt = $mysqli->prepare("UPDATE USUARIOS SET nombre_usuario=?, email=? WHERE id=?");
        $stmt->bind_param("ssi", $nombre, $email, $usuario_id);
    }

    if ($stmt->execute()) {
        $success = "Perfil actualizado correctamente.";

        // Actualizar datos
        $stmt = $mysqli->prepare("SELECT nombre_usuario, email FROM USUARIOS WHERE id=?");
        $stmt->bind_param("i", $usuario_id);
        $stmt->execute();
        $usuario = $stmt->get_result()->fetch_assoc();
    } else {
        $error = "Error al actualizar el perfil.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Perfil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container my-5">
    <h2 class="mb-4">Mi Perfil</h2>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label for="nombre_usuario" class="form-label">Nombre de usuario</label>
                <input type="text" class="form-control" name="nombre_usuario" id="nombre_usuario" value="<?php echo $usuario['nombre_usuario']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" name="email" id="email" value="<?php echo $usuario['email']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Contraseña (dejar en blanco para no cambiar)</label>
                <input type="password" class="form-control" name="password" id="password">
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Actualizar Perfil</button>
                <a href="../index.php" class="btn btn-secondary">Volver al Inicio</a>
            </div>
        </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>