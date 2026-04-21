<?php
header("Content-Type: application/json; charset=utf-8");
require_once "../configuracion/config.php";
require_once "../modelos/agregar-nota-modelo.php";
session_start();

//COMPRUEBO EL ID DEL USUARIO QUE SEA EL DEL MEDICO DEL PANEL
if(!isset($_SESSION["id_usuario"])){
    echo json_encode([
        "la_nota_se_sube" => false, 
        "error" => "No se encontró el id del médico."
    ]);
    exit;
}

//PARA COMPROBAR LOS DATOS QUE SE RECIBEN
if(!isset($_POST["id_cita"]) || !isset($_POST["nota"])){
    echo json_encode([
        "la_nota_se_sube" => false, 
        "error" => "Faltan datos."
    ]);
    exit;
}

$id_cita = intval($_POST["id_cita"]);
$nota = trim($_POST["nota"]);

//PARA VALIDAR QUE EL ID DE CITA ES CORRECTO
if($id_cita <= 0){
    echo json_encode([
        "la_nota_se_sube" => false, 
        "error" => "ID de cita no válido."
    ]);
    exit;
}

if($nota === ""){
    echo json_encode([
        "la_nota_se_sube" => false, 
        "error" => "La nota está vacía."
    ]);
    exit;
}

//PARA GUARDAR LA NOTA
$guardada = guardarNota($conexion, $id_cita, $nota);

//Y AHORA INSERTO LA NOTIFICACIÓN SI SE GUARDO LA NOTA CLARO. PRIMERO OBTENGO LOS DATOS DE LA CITA Y LUEGO LA INSERTO.
if($guardada){
    $sql_cita = "SELECT id_paciente, fecha_cita FROM citas WHERE id_cita = ?";

    $prepararion_cita_datos_nota = mysqli_prepare($conexion, $sql_cita);
    mysqli_stmt_bind_param($prepararion_cita_datos_nota, "i", $id_cita);
    mysqli_stmt_execute($prepararion_cita_datos_nota);

    $resultado_cita_datos_nota = mysqli_stmt_get_result($prepararion_cita_datos_nota);
    $cita_datos_nota = mysqli_fetch_assoc($resultado_cita_datos_nota);

    mysqli_stmt_close($prepararion_cita_datos_nota);

    $fecha_formato = date("d/m/Y", strtotime($cita_datos_nota["fecha_cita"]));
    $hora_formato = date("H:i", strtotime($cita_datos_nota["fecha_cita"]));
    $id_paciente = $cita_datos_nota["id_paciente"];

    $mensaje = "Tu médico añadió observaciones a tu cita del $fecha_formato a las $hora_formato";
    $sql_notificacion = "INSERT INTO notificaciones (id_usuario, tipo, mensaje, id_cita) VALUES (?, 'observacion_añadida', ?, ?)";

    $preparacion_notificacion_nota = mysqli_prepare($conexion, $sql_notificacion);
    mysqli_stmt_bind_param($preparacion_notificacion_nota, "isi", $id_paciente, $mensaje, $id_cita);
    mysqli_stmt_execute($preparacion_notificacion_nota);

    mysqli_stmt_close($preparacion_notificacion_nota);
}

echo json_encode([
    "la_nota_se_sube" => $guardada
]);
?>