<?php
header("Content-Type: application/json; charset=utf-8");
require_once "../configuracion/config.php";
require_once "../modelos/gestionar-especialidades-modelo.php";
session_start();

//VERFICIO ID DEL ADMIN PARA CONTINUAR O NO
if(!isset($_SESSION["id_usuario"])){
    exit;
}

//RECOJO LO QUE SE VA HACER, YA SEA EDITAR, ELIMINAR, OBTENER LA LISTA, ETC.
if (isset($_GET["loquesevaahacer"])) {
    $loquesevaahacer = $_GET["loquesevaahacer"];
} else {
    $loquesevaahacer = "";
}

//SI SIIMPLEMETNE SE VA A CARGAR LA LISTA DE LAS QUE HAY
if($loquesevaahacer === "obtener"){
    $especialidades = obtenerEspecialidades($conexion);

    echo json_encode([
        "especialidades" => $especialidades
        ]);

//SI SE VA A AÑADIR UNA NUEVA
}else if($loquesevaahacer === "añadir"){
    $nombre = trim($_POST["nombre"]);
    if($nombre === ""){
        echo json_encode([
            "añadida" => false,
            "mensaje_de_error" => "El nombre no puede estar vacío."
        ]);
        exit;
    }
    if(!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/u", $nombre)){
        echo json_encode([
            "añadida" => false,
            "mensaje_de_error" => "El nombre solo puede contener letras y espacios."
            ]);
        exit;
    }
    if(especialidadYaExiste($conexion, $nombre)){
    echo json_encode([
            "añadida" => false,
            "mensaje_de_error" => "Esta especialidad que intentas añadir ya existe."
        ]);
        exit;
    }
    $resultado = anadirEspecialidad($conexion, $nombre);

    echo json_encode([
        "añadida" => $resultado
        ]);

//SI SE VA A EDITAR
}else if($loquesevaahacer === "editar"){
    $id_especialidad = intval($_POST["id_especialidad"]);
    $nombre = trim($_POST["nombre"]);

    if($nombre === ""){
        echo json_encode([
            "guardada" => false,
            "mensaje_de_error" => "El nombre no puede estar vacío."
        ]);
        exit;
    }
    if(!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/u", $nombre)){
        echo json_encode([
            "guardada" => false,
            "mensaje_de_error" => "El nombre solo puede contener letras y espacios."
        ]);
        exit;
    }
    $resultado = editarEspecialidad($conexion, $id_especialidad, $nombre);

    echo json_encode(["guardada" => $resultado]);

//SI SE VA A ELIMINAR UNA ESPECIALIDAD
}else if($loquesevaahacer === "eliminar"){
    $id_especialidad = intval($_GET["id_especialidad"]);

    if(cuantosMedicosHayConEstaEspecialidad($conexion, $id_especialidad)){
        echo json_encode([
            "eliminada" => false,
            "mensaje_de_error" => "No se puede eliminar esta especialidad porque hay médicos registrados que la tienen."
        ]);
        exit;
    }
    $resultado = eliminarEspecialidad($conexion, $id_especialidad);

    echo json_encode([
        "eliminada" => $resultado
        ]);
}
?>