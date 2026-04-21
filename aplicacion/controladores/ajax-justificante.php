<?php
header('Content-Type: application/json; charset=utf-8');
require_once "../configuracion/config.php";
require_once "../modelos/ajax-justificante-modelo.php";
session_start();

if(!isset($_SESSION['id_usuario'])){
    echo json_encode([
        "error" => "No autorizado"
        ]);
    exit;
}

$id_cita = 0;
if(isset($_GET['id_cita'])){
    $id_cita = intval($_GET['id_cita']);
}

$id_paciente = $_SESSION['id_usuario'];

$cita = obtener_datos_cita($conexion, $id_cita, $id_paciente);

if($cita){
    $fecha_hora = strtotime($cita['fecha_cita']);
    $cita['fecha'] = date('d/m/Y', $fecha_hora);
    $cita['hora']  = date('H:i', $fecha_hora);
    echo json_encode($cita);
}else{
    echo json_encode([
        "error" => "No se pudo encontrar la cita."
    ]);
}
?>