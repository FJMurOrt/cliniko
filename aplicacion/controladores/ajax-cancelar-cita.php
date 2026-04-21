<?php
header("Content-Type: application/json; charset=utf-8");
require_once "../configuracion/config.php";
require_once "../modelos/ajax-cancelar-cita-modelo.php";
session_start();

$id_paciente = $_SESSION["id_usuario"];

if(isset($_GET["id_cita"])){
    $id_cita = intval($_GET["id_cita"]);
    $cancelada = cancelarCita($conexion, $id_cita, $id_paciente);

    if($cancelada){
        $cita_info = obtenerDatosCitaParaNotificacion($conexion, $id_cita);
        $fecha_formato = date("d/m/Y", strtotime($cita_info["fecha_cita"]));
        $hora_formato = date("H:i", strtotime($cita_info["fecha_cita"]));

        $mensaje_noti = "El paciente ".$cita_info["nombre"]." ".$cita_info["apellidos"]." ha cancelado su cita del ".$fecha_formato." a las ".$hora_formato.".";
        insertarNotificacionMedico($conexion, $cita_info["id_medico"], $mensaje_noti);

        //ENVÍO EL CORREO AL MÉDICO DE QUE HE CANCELADO LA CITA
        $correo_medico = obtenerCorreoMedico($conexion, $cita_info["id_medico"]);

        $api = "CLAVE QUE NO PUEDO SUBIR A GITHUB";
        $url_brevo = "https://api.brevo.com/v3/smtp/email";

        $asunto = "Cita cancelada por ".$cita_info["nombre"]." ".$cita_info["apellidos"];
        $mensaje = "<h2>Cita cancelada</h2>";
        $mensaje .= "<p>El paciente ".$cita_info["nombre"]." ".$cita_info["apellidos"]." ha cancelado su cita del ".$fecha_formato." a las ".$hora_formato.".</p>";
        $mensaje .= "<p>Saludos cordiales,</p>";
        $mensaje .= "<p>El equipo de Clíniko</p>";

        $correoEmail = [
            "sender" => ["name" => "Clíniko", "email" => "francisco.javier.muriel.orta@ieslaarboleda.es"],
            "to" => [["email" => $correo_medico]],
            "subject" => $asunto,
            "htmlContent" => $mensaje
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
        "cita_cancelada" => $cancelada
    ]);
}else{
    echo json_encode([
        "cita_cancelada" => false
    ]);
}
?>