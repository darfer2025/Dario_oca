<?php
require_once '../config/conexion.php';
require_once '../config/jwt.php';
require_once '../app/usuarios.php';
require_once '../app/auth.php';
require_once '../app/rols.php';
require_once '../app/permisos.php';

header('Content-Type: application/json');

$request = json_decode(file_get_contents("php://input"), true);

// Ruta para registrar usuario
if ($_SERVER['REQUEST_URI'] == '/registrar/usuario' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $respuesta = crearUsuario($request);
    if ($respuesta) {
        echo json_encode(["mensaje" => "Registro exitoso"]);
    } else {
        echo json_encode(["mensaje" => "Hubo un error"]);
    }
    exit;
}
if ($_SERVER['REQUEST_URI'] == '/eliminar/usuario' && $_SERVER['REQUEST_METHOD'] == 'DELETE') {
    // Eliminar usuario por ID recibido en el body
    if (isset($request['id'])) {
        $eliminado = eliminarUsuario($request['id']);
        if ($eliminado) {
            echo json_encode(["mensaje" => "Usuario eliminado correctamente"]);
        } else {
            echo json_encode(["error" => "No se pudo eliminar el usuario"]);
        }
    } else {
        echo json_encode(["error" => "Falta el ID del usuario"]);
    }
    exit;
}


// Ruta para listar usuarios (protegida con token)
if ($_SERVER['REQUEST_URI'] == '/listar/usuarios' && $_SERVER['REQUEST_METHOD'] == 'GET') {
    // Aquí puedes validar el token si ya tienes eso implementado
    $usuarios = listarUsuarios();
    echo json_encode($usuarios);
    exit;
}

// Ruta para obtener un usuario por ID
if ($_SERVER['REQUEST_URI'] == '/obtener/usuario' && $_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($request['id'])) {
        $usuario = obtenerUsuario($request['id']);
        echo json_encode($usuario);
    } else {
        echo json_encode(["error" => "Falta el ID del usuario"]);
    }
    exit;
}

// Ruta para actualizar usuario
if ($_SERVER['REQUEST_URI'] == '/actualizar/usuario' && $_SERVER['REQUEST_METHOD'] == 'PUT') {
    $resultado = ActualizarUsuario($request);
    echo json_encode(["resultado" => $resultado]);
    exit;
}

// Ruta para login
if ($_SERVER['REQUEST_URI'] == '/login' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = iniciarSesion($request);

    if ($usuario) {
        $token = generarJwtToken($usuario);
        echo json_encode([
            "usuario" => $usuario,
            "token" => $token
        ]);
    } else {
        echo json_encode(["error" => "Usuario o contraseña incorrectos"]);
    }
    exit;

    //ROLES


}elseif (
    $_SERVER['REQUEST_URI'] == '/crearoles' &&
    $_SERVER['REQUEST_METHOD'] == 'POST'
) {
    $resultado = crearRol($request['nombre']);
    echo json_encode([
        'mensaje' => $resultado ? 'Rol creado' : 'Error al crear rol'
    ]);
} elseif (
    $_SERVER['REQUEST_URI'] == '/listarrol' &&
    $_SERVER['REQUEST_METHOD'] == 'GET'
) {
    $roles = listarRoles();
    echo json_encode($roles);
}  elseif (
    $_SERVER['REQUEST_URI'] == '/obtenerrol' &&
    $_SERVER['REQUEST_METHOD'] == 'GET'
) {
    $roles = obtenerRol($request['id']);
    echo json_encode($roles);


} elseif (
    $_SERVER['REQUEST_URI'] == '/actualizarol' &&
    $_SERVER['REQUEST_METHOD'] == 'PUT'
) {
    $resultado = actualizarRol($request['id'], $request['nombre']);
    echo json_encode([
        'mensaje' => $resultado ? 'Rol actualizado' : 'Error al actualizar rol'
    ]);
} elseif (
    $_SERVER['REQUEST_URI'] == '/borrarrol' &&
    $_SERVER['REQUEST_METHOD'] == 'DELETE'
) {
    $resultado = eliminarRol($request['id']);
    echo json_encode([
        'mensaje' => $resultado ? 'Rol eliminado' : 'Error al eliminar rol'
    ]);

    //PERMISOS

}elseif (
    $_SERVER['REQUEST_URI'] == '/crearpermiso' &&
    $_SERVER['REQUEST_METHOD'] == 'POST'
) {
    $resultado = crearPermiso($request['nombre']);
    echo json_encode([
        'mensaje' => $resultado ? 'Permiso creado' : 'Error al crear permiso'
    ]);
} elseif (
    $_SERVER['REQUEST_URI'] == '/lisarpermiso' &&
    $_SERVER['REQUEST_METHOD'] == 'GET'
) {
    $permisos = listarPermisos();
    echo json_encode($permisos);
} elseif (
    $_SERVER['REQUEST_URI'] == '/actualizarpermiso' &&
    $_SERVER['REQUEST_METHOD'] == 'PUT'
) {
    $resultado = actualizarPermiso($request['id'], $request['nom_permisos']);
    echo json_encode([
        'mensaje' => $resultado ? 'Permiso actualizado' : 'Error al actualizar permiso'
    ]);
} elseif (
    $_SERVER['REQUEST_URI'] == '/eliminarpermiso' &&
    $_SERVER['REQUEST_METHOD'] == 'DELETE'
) {
    $resultado = eliminarPermiso($request['id']);
    echo json_encode([
        'mensaje' => $resultado ? 'Permiso eliminado' : 'Error al eliminar permiso'
    ]);
}  elseif (
    $_SERVER['REQUEST_URI'] == '/obtenerpermiso' &&
    $_SERVER['REQUEST_METHOD'] == 'GET'
) {
    $permisos = obtenerPermiso($request['id']);
    echo json_encode($permisos);
}

// Si no se encontró la ruta

