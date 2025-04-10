<?php
require_once '../config/conexion.php';

// Permisos

function crearPermiso($nombre) {
    $conexion = conectar();
    $stmt = $conexion->prepare("INSERT INTO permisos (nom_permisos) VALUES (?)");
    return $stmt->execute([$nombre]);
}

function listarPermisos() {
    $conexion = conectar();
    $resultado = $conexion->query("SELECT * FROM permisos");
    return $resultado->fetch_all(MYSQLI_ASSOC);
}

function actualizarPermiso($id, $nuevoNombre) {
    $conexion = conectar();
    $stmt = $conexion->prepare("UPDATE permisos SET nom_permisos = ? WHERE id = ?");
    return $stmt->execute([$nuevoNombre, $id]);
}

function eliminarPermiso($id) {
    $conexion = conectar();
    $stmt = $conexion->prepare("DELETE FROM permisos WHERE id = ?");
    return $stmt->execute([$id]);
}
function obtenerPermiso($id) {
    $conexion = conectar();
    $stmt = $conexion->query("SELECT * FROM permisos WHERE id = $id");
    return $stmt->fetch_all(MYSQLI_ASSOC);
}