<?php

//crear un usuario

function crearUsuario($request)
{   

    try {        $passwordHash = password_hash($request['password'], PASSWORD_BCRYPT);
        $sql = "INSERT INTO `usuarios`(`id`, `nombre`,
     `apellido`, `email`, `password`)
     VALUES (null,'{$request['nombre']}','{$request['apellido']}',
     '{$request['email']}','{$passwordHash}')";
        $conexion = conectar();
        $conexion->query($sql);
        return true;

    } catch (\Throwable $th) {
        return false;
    }
}

function listarUsuarios() {
    $conexion = conectar(); // mysqli
    $stmt = $conexion->prepare("SELECT * FROM usuarios");
    $stmt->execute();
    $resultado = $stmt->get_result();
    $users = [];

    while ($fila = $resultado->fetch_assoc()) {
        $users[] = $fila;
    }

    if ($users) {
        return $users;
    } else {
        return ["error" => "No hay usuarios registrados"];
    }
}


function obtenerUsuario($id)
{
    $sql = "SELECT * FROM usuarios WHERE id = {$id}"; 
    $conexion = conectar();
    $resultado = $conexion->query($sql);
    $usuario = $resultado->fetch_assoc(); //fetch_all trae todos los registros
    return $usuario;
}

function ActualizarUsuario($request)
{
    $sql = "UPDATE `usuarios` SET 
    `nombre`='$request[nombre]',
    `apellido`='$request[apellido]',
    `email`='$request[email]'     
    WHERE id = {$request['id']}"; 
    
    $conexion = conectar();
    $resultado = $conexion->query($sql);
    return $resultado;
}
function eliminarUsuario($id)
{
    $conexion = conectar(); // mysqli
    $stmt = $conexion->prepare("DELETE FROM usuarios WHERE id = ?");
    $stmt->bind_param("i", $id);
    $resultado = $stmt->execute();

    return $resultado;
}
