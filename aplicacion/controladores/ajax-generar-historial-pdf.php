<?php
header("Content-Type: application/json; charset=utf-8");
require_once "../configuracion/config.php";
require_once "../modelos/ajax-generar-historial-pdf-modelo.php";
session_start();

//VERIFICACIÓN DEL MÉDICO
if(!isset($_SESSION["id_usuario"])){
    exit;
}

//LO GUARDO PARA LUEGO USARLO EN FUNCIONES COMO SIEMPRE
$id_medico = $_SESSION["id_usuario"];

$id_paciente = 0;
if(isset($_GET["id_paciente"])){
    $id_paciente = intval($_GET["id_paciente"]);
}

if($id_paciente <= 0){
    exit;
}

//GUARDO LOS RESULTADO DE CADA FUNCIÓN EN UNA VARIABLE
$paciente = obtenerDatosPaciente($conexion, $id_paciente);
$medico = obtenerDatosMedico($conexion, $id_medico);
$citas = obtenerCitasPacienteMedico($conexion, $id_paciente, $id_medico);

echo json_encode([
    "paciente" => $paciente,
    "medico" => $medico,
    "citas" => $citas
]);
?>