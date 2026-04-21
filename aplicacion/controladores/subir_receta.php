<?php
header("Content-Type: application/json; charset=utf-8");
require_once "../configuracion/config.php";
require_once "../modelos/subir-receta-modelo.php";
session_start();

//VERIFICO QUE EL ID DEL MEDICO EXISTE
if(!isset($_SESSION["id_usuario"])){
    echo json_encode([
        "se_sube_la_receta" => false,
        "no_se_sube_la_receta" => "No se encontró el id del médico."
    ]);
    exit;
}

$id_medico = $_SESSION["id_usuario"];
$id_cita = 0;
if(isset($_POST["id_cita"])){
    $id_cita = intval($_POST["id_cita"]);
}

if($id_cita <= 0){
    echo json_encode([
        "se_sube_la_receta" => false,
        "no_se_sube_la_receta" => "No se encontró el id de la cita."
    ]);
    exit;
}

//VERIFICO QUE SE SELECCIONÓ UN ARCHIVO
if(!isset($_FILES["archivo"]) || $_FILES["archivo"]["error"] !== UPLOAD_ERR_OK){
    echo json_encode([
        "se_sube_la_receta" => false,
        "no_se_sube_la_receta" => "El archivo no es válido."
    ]);
    exit;
}

$archivo = $_FILES["archivo"];
$formato = strtolower(pathinfo($archivo["name"], PATHINFO_EXTENSION));

if($formato !== "pdf"){
    echo json_encode([
        "se_sube_la_receta" => false,
        "no_se_sube_la_receta" => "Solo se permiten archivos PDF."
    ]);
    exit;
}

//LE DOY UN NOMBRE UNICO CON UNIQUID A LA RECETA QUE SE SUBE
$nombre_nuevo = uniqid("receta_") . ".pdf";
$ruta_destino = "../../uploads/recetas/" . $nombre_nuevo;

//MIRO SI YA EXISTE UNA RECETA PARA LA CITA Y SI LA HAY LA SUSITUYO POR LA ANTIGUO O SUBO LA NUEVA
$receta_existente = obtenerReceta($conexion, $id_cita);

if($receta_existente){
    //ELIMINO LA ANTERIOR
    $ruta_anterior = "../../uploads/recetas/".$receta_existente["archivo_pdf"];
    if(file_exists($ruta_anterior)) unlink($ruta_anterior);

    if(!move_uploaded_file($archivo["tmp_name"], $ruta_destino)){
        echo json_encode([
            "se_sube_la_receta" => false,
            "no_se_sube_la_receta" => "Hubo un error al guardar el archivo."
        ]);
        exit;
    }

    $respuestaOk = actualizarReceta($conexion, $receta_existente["id_receta"], $nombre_nuevo);

}else{
    if(!move_uploaded_file($archivo["tmp_name"], $ruta_destino)){
        echo json_encode([
            "se_sube_la_receta" => false,
            "no_se_sube_la_receta" => "Hubo un error al guardar el archivo."
        ]);
        exit;
    }

    $respuestaOk = insertarReceta($conexion, $id_cita, $nombre_nuevo);
}

//NOTIFIACIÓN APRA CUANDO SE SUBE UNA RECETA
if($respuestaOk){
    //LOS DATOS DE LA CITA QUE TIENE LA RECETA
    $sql_cita = "SELECT id_paciente, fecha_cita FROM citas WHERE id_cita = ?";

    $preparacion_receta_cita = mysqli_prepare($conexion, $sql_cita);
    mysqli_stmt_bind_param($preparacion_receta_cita, "i", $id_cita);
    mysqli_stmt_execute($preparacion_receta_cita);

    $resultado_receta_cita = mysqli_stmt_get_result($preparacion_receta_cita);
    $cita_receta_datos = mysqli_fetch_assoc($resultado_receta_cita);

    mysqli_stmt_close($preparacion_receta_cita);

    $fecha_formato = date("d/m/Y", strtotime($cita_receta_datos["fecha_cita"]));
    $hora_formato = date("H:i", strtotime($cita_receta_datos["fecha_cita"]));
    $id_paciente = $cita_receta_datos["id_paciente"];

    $mensaje = "Tu médico subió una receta a tu cita del $fecha_formato a las $hora_formato";
    $sql_notificacion = "INSERT INTO notificaciones (id_usuario, tipo, mensaje, id_cita) VALUES (?, 'receta_subida', ?, ?)";

    $preparacion_notificacion = mysqli_prepare($conexion, $sql_notificacion);
    mysqli_stmt_bind_param($preparacion_notificacion, "isi", $id_paciente, $mensaje, $id_cita);
    mysqli_stmt_execute($preparacion_notificacion);
    mysqli_stmt_close($preparacion_notificacion);
}

//DEVUELVO LA RESPUESTA EN JSON PARA EL JS
echo json_encode([
    "se_sube_la_receta" => $respuestaOk
]);
?>