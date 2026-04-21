<?php
require_once "../../modelos/medico.php";

//RECOGEMOS EL ID QUE LE MENADAMOS DESDE LA TABLA DE LA LISTA DE MEDICOS AL PULSAR EN UN MÉDICO
if(!isset($_GET["id"])){
    header("Location: ver-medicos.php");
    exit;
}

$id_medico = intval($_GET["id"]);

//CON EL ID, VEMOS LOS DATOS DEL MEDICOS EN LA BASE DATOS PARA VER SU NOMBRE Y ESPECIALDIAD
$medico = obtenerMedicoPorID($conexion, $id_medico);

if(!$medico){
    header("Location: ver-medicos.php");
    exit;
}

//Y LUEGO CON EL ID DEL MEDICO TAMBIEN CONSULTAMOS EN LA TABLA DE DISPONIBILDAD HORARIA, LOS HORARIOS QUE TIENE.
$disponibilidad = obtener_disponibilidad_medico($conexion, $id_medico);

//PARA GUARDAR LA MEDIA DEL MEDICO DE LAS VALORACIONES
$valoracion = obtenerMediaValoracion($conexion, $id_medico);

$media_valoracion = $valoracion["media"];
$total_valoraciones = $valoracion["total"];
?>