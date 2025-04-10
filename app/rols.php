<?php
require_once '../config/conexion.php';


function crearRol($nombre)
{
    $conexion = conectar(); // debe estar definida en conexion.php
    $stmt = $conexion->prepare("INSERT INTO roles (nom_roles) VALUES (?)");
    $stmt->bind_param("s", $nombre);
    $resultado = $stmt->execute();

    return $resultado;
}
function listarRoles() {
    $conexion = conectar();
    $resultado = $conexion->query("SELECT * FROM roles");
    return $resultado->fetch_all(MYSQLI_ASSOC);
}

function actualizarRol($id, $nuevoNombre) {
    $conexion = conectar();
    $stmt = $conexion->prepare("UPDATE roles SET nom_roles = ? WHERE id = ?");
    return $stmt->execute([$nuevoNombre, $id]);
}

function eliminarRol($id) {
    $conexion = conectar();
    $stmt = $conexion->prepare("DELETE FROM roles WHERE id = ?");
    return $stmt->execute([$id]);
}

function obtenerRol($id) {
    $conexion = conectar();
    $stmt = $conexion->query("SELECT * FROM roles WHERE id = $id");
    return $stmt->fetch_all(MYSQLI_ASSOC);
}