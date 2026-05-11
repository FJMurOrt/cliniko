<?php
header("Content-Type: application/json; charset=utf-8");
require_once "../configuracion/config.php";
require_once "../modelos/ajax-circular-modelo.php";
session_start();

//VERIFICO EL ID DEL ADMIN
if(!isset($_SESSION["id_usuario"])){
    exit;
}

//GUARDO EL ASUNTO Y EL MENSAJE QUE SE ESTÁN ESCRIBIENDO DESDE LA WEB
$asunto = trim($_POST["asunto"]);
$mensaje = trim($_POST["mensaje"]);

//SI EL MENSAJE O EL ASUNTO ESTÁ VACÍO NO SIGO CON EL SCRIPT Y SALGO.
if($asunto === "" || $mensaje === ""){
    echo json_encode([
        "enviado" => false, 
        "mensaje_de_error" => "El asunto y el mensaje son obligatorios."
        ]);
    exit;
}

//USO LA FUNCIÓN DE OBTENER LOS CORREOS DE LOS USUARIOS QUE SÓLO ESTÉN HABILITADOS
$usuarios = obtenerCorreosTodosUsuarios($conexion);

$api = "CLAVE_API_BREVO";
$url_brevo = "https://api.brevo.com/v3/smtp/email";

$destinatarios = [];
foreach($usuarios as $usuario){
    $destinatarios[] = ["email" => $usuario["correo"]];
}

$correo_que_se_va_a_enviar = [
    "sender" => ["name" => "Clíniko", "email" => "francisco.javier.muriel.orta@ieslaarboleda.es"],
    "to" => $destinatarios,
    "subject" => $asunto,
    "htmlContent" => "<p>".nl2br(htmlspecialchars($mensaje))."</p>"
];

$curl = curl_init($url_brevo);
curl_setopt($curl, CURLOPT_HTTPHEADER, [
    "api-key: $api",
    "Content-Type: application/json",
    "accept: application/json"
]);
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($correo_que_se_va_a_enviar));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$respuesta_api = curl_exec($curl);
curl_close($curl);

echo json_encode([
    "enviado" => true
    ]);
?>