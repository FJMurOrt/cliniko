<?php
header("Content-Type: application/json; charset=utf-8");
require_once "../configuracion/config.php";
require_once "../modelos/ajax-inicio-admin-modelo.php";
session_start();

//VERIFICACIÓN DEL ID DEL ADMIN
if(!isset($_SESSION["id_usuario"])){
    exit;
}

//SE GUARDA EL ID DEL ADMIN PARA PARA LAS NOTIFICIACIONES
$id_admin = $_SESSION["id_usuario"];

$total_usuarios = obtenerTotalUsuarios($conexion);
$citas_estado = obtenerCitasPorEstado($conexion);
$notificaciones = obtenerUltimasNotificaciones($conexion, $id_admin);
$valoraciones_reportadas = obtenerValoracionesReportadas($conexion);
$documentos_hoy = obtenerDocumentosHoy($conexion);
$valoraciones_estrellas = obtenerValoracionesPorEstrellas($conexion);

//DEVUELVO LOS RESULTADOS
echo json_encode([
    "usuarios_habilitados" => $total_usuarios["habilitados"],
    "usuarios_deshabilitados" => $total_usuarios["deshabilitados"],
    "notificaciones" => $notificaciones,
    "citas_pendiente" => $citas_estado["pendiente"],
    "citas_confirmada" => $citas_estado["confirmada"],
    "citas_cancelada" => $citas_estado["cancelada"],
    "citas_realizada" => $citas_estado["realizada"],
    "citas_no_atendida" => $citas_estado["no_atendida"],
    "valoraciones_reportadas" => $valoraciones_reportadas,
    "recetas_hoy" => $documentos_hoy["recetas"],
    "historiales_hoy" => $documentos_hoy["historiales"],
    "estrellas_1" => $valoraciones_estrellas["una"],
    "estrellas_2" => $valoraciones_estrellas["dos"],
    "estrellas_3" => $valoraciones_estrellas["tres"],
    "estrellas_4" => $valoraciones_estrellas["cuatro"],
    "estrellas_5" => $valoraciones_estrellas["cinco"]
]);
?>