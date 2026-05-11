<?php
header("Content-Type: application/json; charset=utf-8");
require_once "../configuracion/config.php";
require_once "../modelos/ajax-habilitar-usuario-modelo.php";
session_start();

//SI DE NUEVO HAY PROBLEMAS CON EL ID DEL ADMIN, NO SE HACE NADA.
if(!isset($_SESSION["id_usuario"])){
    echo json_encode([
        "usuario_habilitado" => false
        ]);
    exit;
}

//RECOJO EL ID DEL USUARIO QUE VAMOS A HABILITAR PARA LUEGO EN FUNCIONES RECOGER SUS DATOS PARA EL CORREO Y PARA HABILITARLO
$id_usuario = intval($_GET["id_usuario"]);

$usuario = obtenerDatosUsuario($conexion, $id_usuario);
habilitarUsuario($conexion, $id_usuario);

//ENVIO EL CORREO AL USUARIO DE QUE SE LE HA HABILITADO
$api = "CLAVE_API_BREVO";
$url_brevo = "https://api.brevo.com/v3/smtp/email";

$asunto = "Tu cuenta en Clíniko ha sido activada";
$mensaje = "<h2>¡Bienvenido/a a Clíniko!</h2>";
$mensaje .= "<p>Hola ".$usuario["nombre"]." ".$usuario["apellidos"].",</p>";
$mensaje .= "<p>Tu cuenta ha sido activada correctamente. Ya puedes acceder a ella.</p>";
$mensaje .= "<p>Saludos cordiales,</p>";
$mensaje .= "<p>El equipo de Clíniko</p>";

$correo = [
    "sender" => ["name" => "Clíniko", "email" => "francisco.javier.muriel.orta@ieslaarboleda.es"],
    "to" => [["email" => $usuario["correo"]]],
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
curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($correo));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_exec($curl);
curl_close($curl);

echo json_encode([
    "usuario_habilitado" => true
    ]);
?>