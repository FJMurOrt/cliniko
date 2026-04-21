<?php
session_start();
require_once "../modelos/disponibilidad-horaria.php";

//COGEMOS EL ID DEL MEDICO
if(isset($_SESSION["id_medico"])){
    $id_medico = $_SESSION["id_medico"];
}else{
    $id_medico = null;
}

//VERIFICAMOS QUE LOS RECIBIMOS
if($id_medico === null){
    die("Debe iniciar sesión como médico.");
}

//RECOGEMOS LOS DATOS DEL FORMULARIO
if(isset($_POST["fecha"])){
    $fecha = $_POST["fecha"];
}else{
    $fecha = "";
}

if(isset($_POST["hora_inicio"])){
    $hora_inicio = $_POST["hora_inicio"];
}else{
    $hora_inicio = "";
}

if(isset($_POST["hora_fin"])){
    $hora_fin = $_POST["hora_fin"];
}else{
    $hora_fin = "";
}

if(isset($_POST["turno"])){
    $turno = $_POST["turno"];
}else{
    $turno = "";
}

//ERRORES
$errores = [];

if($fecha === ""){
    $errores[] = "Debes introducir una fecha.";
}

if($hora_inicio === ""){
    $errores[] = "Debes seleccionar la hora de inicio.";
}

if($hora_fin === ""){
    $errores[] = "Debes seleccionar la hora de finalización.";
}

if($turno === ""){
    $errores[] = "Debes seleccionar un turno del día.";
}

//VERIFICAMOS QUE SI SE SINTRODUCE UNA FECHA MENOR A LA FECHA ACTUAL, NO SEA POSIBLE.
$fecha_actual = date("Y-m-d");
if(strtotime($fecha) < strtotime($fecha_actual)){
    $errores[] = "La fecha no puede ser anterior a hoy.";
}

//VALIDACIÓN DE QUE LA HORA DE INCIO NO SEA MENOR A LA HORA DE FIN.
if(strtotime($hora_inicio) >= strtotime($hora_fin)){
    $errores[] = "La hora de inicio debe ser menor que la hora de finalización.";
}

//Y GUARDAMOS LOS ERRORES CON SESSION
if(!empty($errores)){
    $_SESSION["errores_disponibilidad"] = $errores;
    header("Location: ../vistas/medico/gestionar-disponibilidad.php");
    exit;
}

//VERFIICAMOS QUE EL TURNO YA NO ESTE AGREGADO EN LA TABLA PARA ESE DÍA
if(existeDisponibilidad($conexion, $id_medico, $fecha, $turno)){
    $_SESSION["errores_disponibilidad"] = ["Ya existe una disponibilidad para ese turno en esa fecha."];
    header("Location: ../vistas/medico/gestionar-disponibilidad.php");
    exit;
}

//LO GUARDAMOS
$resultado = guardarDisponibilidad($conexion, $id_medico, $fecha, $turno, $hora_inicio, $hora_fin);

if(guardarDisponibilidad($conexion, $id_medico, $fecha, $turno, $hora_inicio, $hora_fin)){
    $_SESSION["mensaje_disponibilidad"] = "Disponibilidad guardada correctamente.";
}else{
    $_SESSION["errores_disponibilidad"] = ["No se pudo guardar la disponibilidad."];
}

header("Location: ../vistas/medico/gestionar-disponibilidad.php");
exit;
?>