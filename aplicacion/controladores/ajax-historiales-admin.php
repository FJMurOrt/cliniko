<?php
header("Content-Type: application/json; charset=utf-8");
require_once "../configuracion/config.php";
require_once "../modelos/ajax-historiales-admin-modelo.php";
session_start();

//VERIFICO EL ID DEL ADMIN
if(!isset($_SESSION["id_usuario"])){
    exit;
}

//PARA RECOGER LO QUE SE VA A HACER
$loquesevaahacer = "";
if (isset($_GET["loquesevaahacer"])) {
    $loquesevaahacer = $_GET["loquesevaahacer"];
}

if($loquesevaahacer === "eliminar"){
    $id_historial = intval($_GET["id_historial"]);

    $id_medico = obtenerIdMedicoHistorial($conexion, $id_historial);
    
    $mensaje_de_la_notificacion = "Uno de tus historiales médicos subidos fue eliminado por incumplir con las normas de la plataforma.";

    $sql_noti = "INSERT INTO notificaciones (id_usuario, tipo, mensaje) VALUES (?, 'historial_eliminado', ?)";

    $prep_noti = mysqli_prepare($conexion, $sql_noti);
    mysqli_stmt_bind_param($prep_noti, "is", $id_medico, $mensaje_de_la_notificacion);
    mysqli_stmt_execute($prep_noti);
    mysqli_stmt_close($prep_noti);

    $resultado = eliminarHistorialAdmin($conexion, $id_historial);
    echo json_encode([
        "eliminada" => $resultado
        ]);
    exit;
}

$pagina = 1;
if(isset($_GET["pagina"])){
    $pagina = intval($_GET["pagina"]);
}

$registros = 4;
$inicio = ($pagina - 1) * $registros;

$busqueda_paciente = "";
if(isset($_GET["busqueda_paciente"]) && $_GET["busqueda_paciente"] !== ""){
    $busqueda_paciente = trim($_GET["busqueda_paciente"]);
}

$busqueda_medico = "";
if(isset($_GET["busqueda_medico"]) && $_GET["busqueda_medico"] !== ""){
    $busqueda_medico = trim($_GET["busqueda_medico"]);
}

$fecha = "";
if(isset($_GET["fecha"]) && $_GET["fecha"] !== ""){
    $fecha = $_GET["fecha"];
}

$total = contarHistorialesAdmin($conexion, $busqueda_paciente, $busqueda_medico, $fecha);
$total_paginas = ceil($total / $registros);
$historiales = obtenerHistorialesAdmin($conexion, $inicio, $registros, $busqueda_paciente, $busqueda_medico, $fecha);

echo json_encode([
    "historiales" => $historiales,
    "total_paginas" => $total_paginas
]);
?>