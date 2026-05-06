<?php
header("Content-Type: application/json; charset=utf-8");
require_once "../configuracion/config.php";
require_once "../modelos/ajax-reportar-valoracion-modelo.php";
session_start();

//VERIFICO QUE EL ID DEL ADMIN ESTE BIEN Y NO DE PROBLEMAS
if(!isset($_SESSION["id_usuario"])){
    exit;
}

//RECOJO EL ID DE LA VALORACIÓN Y LO GUARDO EN UNA VARAIBLE PARA LAS FUNCIONES
$id_valoracion = intval($_GET["id_valoracion"]);

//GUARDO LOS DATOS DE LA VALORACIÓN PAR ALUEGO USARLOS EN EL CORREO 
$datos_valoracion = obtenerDatosValoracion($conexion, $id_valoracion);
reportarValoracion($conexion, $id_valoracion);

//GUARDO LOS CORREOS DE LOS ADMINS PARA LUEGO ENVIARLES LOS CORREOS
$admins = obtenerCorreosAdmins($conexion);

// INSERTAMOS NOTIFICACIÓN Y ENVIAMOS CORREO A CADA ADMIN
$api = "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";
$url_brevo = "https://api.brevo.com/v3/smtp/email";

foreach($admins as $admin){
    //INSERTO LA NOTIFICAICÓN EN LA TABLA DE NOTIFICACIONES PARA LOS ADMINISTRADORES
    $mensaje_noti = "Se ha reportado una valoración del paciente ".$datos_valoracion["nombre"]." ".$datos_valoracion["apellidos"].".";
    $sql_noti = "INSERT INTO notificaciones (id_usuario, tipo, mensaje) VALUES (?, 'valoracion_reportada', ?)";

    $prep_noti = mysqli_prepare($conexion, $sql_noti);
    mysqli_stmt_bind_param($prep_noti, "is", $admin["id_usuario"], $mensaje_noti);
    mysqli_stmt_execute($prep_noti);

    mysqli_stmt_close($prep_noti);

    //ENVIO EL CORREO AL ADMIN O LOS ADMINS SI ES QUE HAY MÁS DE UNO
    $asunto = "Nueva valoración reportada";
    $mensaje_correo = "<h2>Valoración reportada</h2>";
    $mensaje_correo .= "<p>Un médico ha reportado una valoración del paciente ".$datos_valoracion["nombre"]." ".$datos_valoracion["apellidos"].".</p>";
    $mensaje_correo .= "<p>Comentario que dejó el paciente: ".htmlspecialchars($datos_valoracion["comentario"])."</p>";
    $mensaje_correo .= "<p>Puntuación de la valoración que dejó el paciente: ".$datos_valoracion["puntuacion"]."/5</p>";
    $mensaje_correo .= "<p>Por favor, revisa la valoración cuanto antes.</p>";
    $mensaje_correo .= "<p>Saludos cordiales,</p>";
    $mensaje_correo .= "<p>El equipo de Clíniko</p>";

    $correoEmail = [
        "sender" => ["name" => "Clíniko", "email" => "francisco.javier.muriel.orta@ieslaarboleda.es"],
        "to" => [["email" => $admin["correo"]]],
        "subject" => $asunto,
        "htmlContent" => $mensaje_correo
    ];

    $curl = curl_init($url_brevo);
    curl_setopt($curl, CURLOPT_HTTPHEADER, [
        "api-key: $api",
        "Content-Type: application/json",
        "accept: application/json"
    ]);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($correoEmail));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_exec($curl);
    curl_close($curl);
}

echo json_encode([
    "reportada" => true
    ]);
?>