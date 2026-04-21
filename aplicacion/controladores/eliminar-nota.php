<?php
header("Content-Type: application/json; charset=utf-8");
require_once "../configuracion/config.php";
require_once "../modelos/eliminar-nota-modelo.php";
session_start();

//VERIFICO QUE TENEMOS EL ID DEL MÉDICO
if(!isset($_SESSION["id_usuario"])){
    echo json_encode([
        "la_nota_se_elimina" => false,
        "la_nota_no_se_elimina" => "No se encontró el id del médico."
    ]);
    exit;
}

//VERIFICO AHORA QUE EL ID DE LA CITA TAMBIÉN LO TENGA SI NO NO PUEDO ACCEDER A LA CITA PARA ELIMINAR LA NOTA
if(!isset($_POST["id_cita"])){
    echo json_encode([
        "la_nota_se_elimina" => false,
        "la_nota_no_se_elimina" => "No se encontra el id de la cita."
    ]);
    exit;
}

$id_cita = intval($_POST["id_cita"]);

if($id_cita <= 0){
    echo json_encode([
        "la_nota_se_elimina" => false,
        "la_nota_no_se_elimina" => "La cita no es válida."
    ]);
    exit;
}

//ELIMINO LA NOTA
$eliminada = eliminarNotaPorCita($conexion, $id_cita);

if($eliminada){
    echo json_encode([
        "la_nota_se_elimina" => true
    ]);
}else{
    echo json_encode([
        "la_nota_se_elimina" => false,
        "la_nota_no_se_elimina" => "No se pudo eliminar la nota."
    ]);
}
?>