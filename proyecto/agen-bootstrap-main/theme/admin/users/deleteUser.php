<?php
session_start();
include '../../config.php'; // Conexión a mi base de datos

// Verifica si el usuario no está logueado o no es administrador
if (!isset($_SESSION['user_rol']) || $_SESSION['user_rol'] !== 'admin') {
    header('Location: ../../index.php');
    exit();
}

// Si NO recibimos el id del usuario que queremos eliminar, NO podremos eliminarlo
if (!isset($_GET['id'])) {
    header("Location: addUser.php");
    exit;
}
//Si recibimos correctamente el id del usuario que queremos eliminar, SI podremos eliminarlo. Guardamos el id en la variable "usuario_id"
$usuario_id = $_GET['id'];

// Ejecutar eliminación
$stmt = $mysqli->prepare("DELETE FROM USUARIOS WHERE id=?");
$stmt->bind_param("i", $usuario_id);
$stmt->execute();

// Redirigir de vuelta al listado de usuarios o para añadir nuevos
header("Location: addUser.php");
exit;
?>