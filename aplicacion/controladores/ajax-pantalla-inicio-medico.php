<?php
header("Content-Type: application/json; charset=utf-8");
require_once "../configuracion/config.php";
require_once "../modelos/ajax-pantalla-inicio-medico-modelo.php";
session_start();

//VERIFICO QUE NO HAYA NINGÚN ERROR CON EL ID DEL MÉDICO
if(!isset($_SESSION["id_usuario"])){
    echo json_encode(["error" => "No autorizado"]);
    exit;
}

//Y LO GUARDO EN UNA VARIABLE PARA USARLO EN LAS FUNCIONES DEL MODELO
$id_medico = $_SESSION["id_usuario"];

$proxima_cita = obtenerProximaCitaMedico($conexion, $id_medico);
$citas_hoy = obtenerCitasHoy($conexion, $id_medico);
$citas_pendientes = obtenerCitasPendientesMedico($conexion, $id_medico);
$total_pacientes = obtenerTotalPacientesMedico($conexion, $id_medico);
$ultimo_paciente = obtenerUltimoPaciente($conexion, $id_medico);
$puntuacion_media = obtenerPuntuacionMedia($conexion, $id_medico);
$ultimas_valoraciones = obtenerUltimasValoracionesMedico($conexion, $id_medico);
$notificaciones = obtenerNotificacionesNoLeidasMedico($conexion, $id_medico);

echo json_encode([
    "proxima_cita" => $proxima_cita,
    "citas_hoy" => $citas_hoy,
    "citas_pendientes" => $citas_pendientes,
    "total_pacientes" => $total_pacientes,
    "ultimo_paciente" => $ultimo_paciente,
    "puntuacion_media" => $puntuacion_media,
    "ultimas_valoraciones" => $ultimas_valoraciones,
    "notificaciones" => $notificaciones
]);
?>