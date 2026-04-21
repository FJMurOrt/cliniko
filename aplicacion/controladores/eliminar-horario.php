<?php
session_start();
require_once "../configuracion/config.php";
require_once "../modelos/eliminar-horario-modelo.php";

//ARRAY DONDE VOY GUARDADO LOS ERRORES PARA LUEGO PASARLOS AL SESSION Y PODER MOSTRARLOS
$errores = [];

//PARA LA VERIFICACIÓN DE LOS DATOS QUE SE RECIBEN
$id = null;
if(isset($_GET["id"])){
    $id = intval($_GET["id"]);
}
$id_medico = $_SESSION["id_medico"];

if(!$id) {
    $_SESSION["errores"][] = "El id no es válido";
    header("Location: ../vistas/medico/ver-horarios.php");
    exit;
}

if(!$id_medico) {
    $_SESSION["errores"][] = "No se encontró el id del medico.";
    header("Location: ../vistas/medico/ver-horarios.php");
    exit;
}

//PARA OBTENER EL HORARIO
$horario = obtenerHorario($conexion, $id, $id_medico);
if(!$horario) {
    $_SESSION["errores"][] = "No se pudo encontrar el horario.";
    header("Location: ../vistas/medico/ver-horarios.php");
    exit;
}

//PARA VERIFICAR QUE NO HAY CITAS ACTIVAS EN EL HORARIO QUE SE VA A ELIMINAR
$total_citas = contarCitasEnHorario($conexion, $id_medico, $horario["fecha"], $horario["hora_inicio"], $horario["hora_fin"]);
if($total_citas > 0) {
    $_SESSION["errores"][] = "No se puede eliminar porque ya existen citas activas en este horario.";
    header("Location: ../vistas/medico/ver-horarios.php");
    exit;
}

//PARA ELIMINAR EL HORARIO
$eliminado = eliminarHorario($conexion, $id);
if($eliminado) {
    $_SESSION["eliminada"] = "¡Disponibilidad eliminada!";
} else {
    $_SESSION["errores"][] = "No se pudo eliminar el horario.";
}

header("Location: ../vistas/medico/ver-horarios.php");
exit;
?>