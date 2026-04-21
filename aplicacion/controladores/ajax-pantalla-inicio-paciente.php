<?php
header("Content-Type: application/json; charset=utf-8");
require_once "../configuracion/config.php";
require_once "../modelos/ajax-pantalla-inicio-paciente-modelo.php";
session_start();

//VERIFICO QUE NO HAYA NINGÚN PROBLEMA CON EL ID DEL PACIENTE
if(!isset($_SESSION["id_usuario"])){
    echo json_encode(["error" => "No autorizado"]);
    exit;
}

//Y LO GUARDO EN UNA VARIABLE PARA USARLO EN LOS PARAMETROS DE LAS FUNCIONES QUE VOY A LLAMAR DEL MODELO
$id_paciente = $_SESSION["id_usuario"];

$proxima_cita = obtenerProximaCita($conexion, $id_paciente);
$notificaciones = obtenerNotificacionesNoLeidas($conexion, $id_paciente);
$ultimo_medico = obtenerUltimoMedico($conexion, $id_paciente);
$medico_favorito = obtenerMedicoHabitual($conexion, $id_paciente);
$ultima_receta = obtenerUltimaReceta($conexion, $id_paciente);
$ultimo_historial = obtenerUltimoHistorial($conexion, $id_paciente);
$total_citas = obtenerTotalCitasRealizadas($conexion, $id_paciente);
$valoraciones = obtenerUltimasValoraciones($conexion, $id_paciente);

//DEVUELVO EN UN JSON EL RESULTADO DE LAS FUNCIONES QUE LAS HE GUARDADO EN UNA VARIABLE
echo json_encode([
    "proxima_cita" => $proxima_cita,
    "notificaciones" => $notificaciones,
    "ultimo_medico" => $ultimo_medico,
    "medico_favorito" => $medico_favorito,
    "ultima_receta" => $ultima_receta,
    "ultimo_historial" => $ultimo_historial,
    "total_citas" => $total_citas,
    "valoraciones" => $valoraciones
]);
?>