<?php
header("Content-Type: application/json; charset=utf-8");
require_once "../configuracion/config.php";
require_once "../modelos/subir-historial-modelo.php";
session_start();

//VERIFICO QUE EL ID DEL MEDICO ES CORRECTO
if(!isset($_SESSION["id_usuario"])){
    echo json_encode([
        "se_sube_el_historial" => false,
        "mensaje_de_error" => "No se encontró el id del médico."
    ]);
    exit;
}

$id_medico = $_SESSION["id_usuario"];
$id_paciente = 0;
if(isset($_POST["id_paciente"])){
    $id_paciente = intval($_POST["id_paciente"]);
}

if($id_paciente <= 0){
    echo json_encode([
        "se_sube_el_historial" => false,
        "mensaje_de_error" => "No se encontró el id del paciente."
    ]);
    exit;
}

if(!isset($_FILES["archivo"]) || $_FILES["archivo"]["error"] !== UPLOAD_ERR_OK){
    echo json_encode([
        "se_sube_el_historial" => false,
        "mensaje_de_error" => "No se puedo subir el archivo."
    ]);
    exit;
}

//VERIFICO QUE EL ARCHIVO QUE SUBE SÓLO SEA PDF
$archivo = $_FILES["archivo"];
$formato = pathinfo($archivo["name"], PATHINFO_EXTENSION);
if(strtolower($formato) !== "pdf"){
    echo json_encode([
        "se_sube_el_historial" => false,
        "mensaje_de_error" => "Solo se permiten archivos PDF."
    ]);
    exit;
}

//QUE EL ARCHIVO TENGA UN NOMBRE UNICO CON UNIQUID
$nombre_nuevo = uniqid("historial_") . ".pdf";
$ruta_destino = "../../uploads/historiales/" . $nombre_nuevo;

//MIRO SI EL PACIENTE YA TIENE UN HISTORIAL SUBIDO Y LO TIENE, HAGO UNA COSA U OTRA
$historial_existente = obtenerHistorial($conexion, $id_paciente, $id_medico);

if($historial_existente){
    //SI LO TIENE LO QUE HAGO ES SUSTITUIR EL NUEVO POR EL ANTERIOR
    $archivo_anterior = "../../uploads/historiales/".$historial_existente["archivo_pdf"];
    if(file_exists($archivo_anterior)) unlink($archivo_anterior);

    if(!move_uploaded_file($archivo["tmp_name"], $ruta_destino)){
        echo json_encode([
            "se_sube_el_historial" => false,
            "mensaje_de_error" => "Error al guardar el archivo."
        ]);
        exit;
    }

    $resultadoOk = actualizarHistorial($conexion, $historial_existente["id_historial"], $nombre_nuevo);
    if($resultadoOk){
        $mensaje = "Historial actualizado.";
    }else{
        $mensaje = "Error al actualizar el historial.";
    }

    //Y AHORA AQUÍ METO LA NOTIFICACIÓN PARA DECIRLE AL PACIENTE QUE SE LE HA ACTUALIZADO EL HSITORIAL
    if($resultadoOk){
        $mensaje_de_la_notifiacion = "Tu médico ha actualizado tu historial médico";
        $sql_notificacion = "INSERT INTO notificaciones (id_usuario, tipo, mensaje) VALUES (?, 'historial_subido', ?)";
        
        $prepracion_notificacion_actualizacion_historial = mysqli_prepare($conexion, $sql_notificacion);
        mysqli_stmt_bind_param($prepracion_notificacion_actualizacion_historial, "is", $id_paciente, $mensaje_de_la_notifiacion);
        mysqli_stmt_execute($prepracion_notificacion_actualizacion_historial);
        
        mysqli_stmt_close($prepracion_notificacion_actualizacion_historial);
    }else{
        $mensaje = "Hubo un error al intentar actualizar el historial.";
    }

    echo json_encode([
        "se_sube_el_historial" => $resultadoOk,
        "mensaje_de_error" => $mensaje
    ]);

}else{
    if(!move_uploaded_file($archivo["tmp_name"], $ruta_destino)){
        echo json_encode([
            "se_sube_el_historial" => false,
            "mensaje_de_error" => "Hubo un error al intentar guardar el archivo."
        ]);
        exit;
    }

    $resultadoOk = insertarHistorial($conexion, $id_paciente, $id_medico, $nombre_nuevo);
    if ($resultadoOk) {
        $mensaje = "El historial médico fue subido.";
    }else{
        $mensaje = "No se pudo guardar el historial.";
    }

    //Y AQUÍ IGUAL, METO LA NOTIFIACIÓN
    if($resultadoOk){
        //NOTIFICACIÓN
        $mensaje_notifiacion_historial_subido = "Tu médico ha subido tu historial médico";
        $sql_notifiacion_historil_subido = "INSERT INTO notificaciones (id_usuario, tipo, mensaje) VALUES (?, 'historial_subido', ?)";
        
        $preparacion_historial_subido = mysqli_prepare($conexion, $sql_notifiacion_historil_subido);
        mysqli_stmt_bind_param($preparacion_historial_subido, "is", $id_paciente, $mensaje_notifiacion_historial_subido);
        mysqli_stmt_execute($preparacion_historial_subido);
        
        mysqli_stmt_close($preparacion_historial_subido);
    }else{
        $mensaje = "No se pudo guardar el historial.";
    }

    echo json_encode([
        "se_sube_el_historial" => $resultadoOk,
        "mensaje_de_error" => $mensaje
    ]);
}
?>