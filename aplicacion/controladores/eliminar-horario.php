<?php
session_start();
require_once "../configuracion/config.php";
require_once "../modelos/eliminar-horario-modelo.php";

header("Content-Type: application/json; charset=utf-8");

//RECOJO EL ID DEL HORARIO QUE ME LLEGA DEL JS QEU VOY A ELIMINAR
$id = null;
if(isset($_GET["id"])){
    $id = intval($_GET["id"]);
}

$id_medico = $_SESSION["id_usuario"];

if(!$id){
    echo json_encode([
        "eliminado" => false, 
        "eliminado_error" => "Hubo un problema al obtener el id del horario."
        ]);
    exit;
}


if(!$id_medico){
    echo json_encode([
        "eliminado" => false, 
        "eliminado_error" => "Hubo un problema al intentar identificar al médico."
        ]);
    exit;
}

//COMPROBAR QUE ESE HORARIO PERTENCE AL MÉDICO QUE LO ELIMINA
$horario = obtenerHorario($conexion, $id, $id_medico);
if(!$horario){
    echo json_encode([
        "eliminado" => false, 
        "eliminado_error" => "No se pudo encontrar el horario."
        ]);
    exit;
}

//COMPROBAR QUE NO HAYA CITAS EN ESE HORARIO.
$total_citas = contarCitasEnHorario($conexion, $id_medico, $horario["fecha"], $horario["hora_inicio"], $horario["hora_fin"]);
if($total_citas > 0){
    echo json_encode([
        "eliminado" => false, 
        "eliminado_error" => "No se puede eliminar porque ya existen citas activas en este horario."
        ]);
    exit;
}

//PARA ELIMINAR EL HORARIO
$eliminado = eliminarHorario($conexion, $id);
if($eliminado){
    echo json_encode([
        "eliminado" => true, 
        "eliminado_error" => "El horario se eliminó correctamente."
        ]);
}else{
    echo json_encode([
        "eliminado" => false, 
        "eliminado_error" => "No se pudo eliminar el horario."
        ]);
}
?>