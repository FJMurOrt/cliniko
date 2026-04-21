<?php
require_once "../../configuracion/config.php";
require_once "../../modelos/obtener-horario-modelo.php";

$errores = [];

//VERIFICO EL ID DE LA DISPONIBILIDAD Y DEL MÉDICO
$id = null;
if (isset($_GET["id"])){
    $id = intval($_GET["id"]);
}

$id_medico = null;
if (isset($_SESSION["id_medico"])){
    $id_medico = intval($_SESSION["id_medico"]);
}

if(!$id || !$id_medico){
    $errores[] = "No se puedo encontrar el id de la disponibilidad o del médico.";
}

//SI NO HAY ERRORES, LLAMO A LA FUNCIÓN PARA OBTENER EL HORARIO
if(empty($errores)){
    $horario = obtenerHorarioPorId($conexion, $id, $id_medico);

    if(!$horario){
        $errores[] = "No se encotró el horario.";
    }else{
        $horas = obtenerHorasPorTurno($horario["turno"]);
    }
}

//ENVIAR ERRORES O MOSTRAR HORARIO
if(!empty($errores)){
    $_SESSION["errores"] = $errores;
    header("Location: ../../vistas/medico/ver-horarios.php");
    exit;
}
?>