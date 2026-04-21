<?php
require_once "../../configuracion/config.php";
require_once "../../modelos/listar-horarios-modelo.php";

//VERICIAR QUE EL ID SE ENCUENTRA EN EL SESSION
if(!isset($_SESSION["id_medico"])){
    echo json_encode([
        "ok" => false,
        "mensaje" => "No se encontró el id del médico."
    ]);
    exit;
}

$id_medico = $_SESSION["id_medico"];

//FILTROS
$fecha = null;
if (isset($_GET["fecha"]) && $_GET["fecha"] != ""){
    $fecha = $_GET["fecha"];
}

//PARA OBTENER LOS HORARIOS
$horarios = obtenerHorariosMedico($conexion, $id_medico, $fecha);
?>