<?php
header("Content-Type: application/json; charset=utf-8");
require_once "../configuracion/config.php";
require_once "../modelos/ajax-datos-receta-pdf-modelo.php";
session_start();

//VERIFICO EL ID DEL MÉDICO
if(!isset($_SESSION["id_usuario"])){
    exit;
}
//GUARDO EL ID DE LA CITA Y LUEGO LA USO EN LA FUNCIÓN
$id_cita = intval($_GET["id_cita"]);

$datos_de_la_cita = obtenerDatosCitaParaRecetaPDF($conexion, $id_cita);

echo json_encode($datos_de_la_cita);
?>