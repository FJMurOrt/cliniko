<?php
header("Content-Type: application/json; charset=utf-8");
require_once "../configuracion/config.php";
require_once "../modelos/ajax-guardar-valoracion-modelo.php";
session_start();

if(!isset($_SESSION["id_usuario"])){
    echo json_encode([
        "respuestaOk" => false, 
        "respuestaNOOK" => "No se encontró el id del paciente."
    ]);
    exit;
}

$id_paciente = $_SESSION["id_usuario"];
$borrar_valoracion = "nada";
if(isset($_POST["borrar"])){
    $borrar_valoracion = $_POST["borrar"];
}

//ELIMINAR RESEÑA
if($borrar_valoracion === "eliminar"){
    $id_valoracion = intval($_POST["id_valoracion"]);

    if(!valoracion_pertenece($conexion, $id_valoracion, $id_paciente)){
        echo json_encode([
            "respuestaOk" => false,
            "respuestaNOOK" => "No puedes eliminar esta reseña."
        ]);
        exit;
    }

    $eliminada = eliminar_valoracion($conexion, $id_valoracion);
    echo json_encode([
        "respuestaOk" => $eliminada
    ]);
    exit;
}

//RECIBIR DATOS
$id_medico  = intval($_POST["id_medico"]);
$puntuacion = intval($_POST["puntuacion"]);
$comentario = trim($_POST["comentario"]);
$id_valoracion = "";
if (isset($_POST["id_valoracion"])) {
    $id_valoracion = intval($_POST["id_valoracion"]);
}

//VALIDACIONES
if($puntuacion < 1 || $puntuacion > 5){
    echo json_encode([
        "respuestaOk" => false, 
        "respuestaNOOK" => "La puntuación no es válida."
    ]); 
    exit;
}
if(empty($comentario)){
    echo json_encode([
        "respuestaOk" => false, 
        "respuestaNOOK" => "El comentario no puede quedar vacío."
    ]); 
    exit;
}
if(strlen($comentario) > 200){
    echo json_encode([
        "respuestaOk" => false, 
        "respuestaNOOK" => "El comentario no puede tener más de 200 caracteres."
    ]); 
    exit;
}

//COMPROBAR SI EL PACIENTE PUEDE VALORAR AL MÉDICO
if(!paciente_puede_valorar($conexion, $id_paciente, $id_medico)){
    echo json_encode([
        "respuestaOk" => false, 
        "respuestaNOOK" => "No puedes valorar a este médico."
    ]); 
    exit;
}

//EDITAR RESEÑA
if(!empty($id_valoracion)){
    if(!valoracion_pertenece($conexion, $id_valoracion, $id_paciente)){
        echo json_encode([
            "respuestaOk" => false, 
            "respuestaNOOK" => "No puedes editar esta reseña."
        ]); 
        exit;
    }
    $actualizada = actualizar_valoracion($conexion, $id_valoracion, $puntuacion, $comentario);
    echo json_encode([
        "respuestaOk" => $actualizada
    ]);
    exit;
}

//NUEVA RESEÑA
if(existe_valoracion($conexion, $id_paciente, $id_medico)){
    echo json_encode([
        "respuestaOk" => false, 
        "respuestaNOOK" => "Ya existe una reseña tuya para este médico"
    ]); 
    exit;
}

$insertada = insertar_valoracion($conexion, $id_paciente, $id_medico, $puntuacion, $comentario);
echo json_encode([
    "respuestaOk" => $insertada
    ]);
?>