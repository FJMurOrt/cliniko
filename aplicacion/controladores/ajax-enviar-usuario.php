<?php
header("Content-Type: application/json; charset=utf-8");
require_once "../configuracion/config.php";
require_once "../modelos/ajax-enviar-usuario-modelo.php";
session_start();

//VERIFICO ID DEL ADMIN
if(!isset($_SESSION["id_usuario"])){
    exit;
}

//RECOJO LA PETICIÓN DEL BOTÓN ENVIAR EL MENSAJE AL USUARIO
$loquesevaahacer = "";
if(isset($_GET["loquesevaahacer"])){
    $loquesevaahacer = $_GET["loquesevaahacer"];
}

if($loquesevaahacer === "enviar"){
    //RECOJO LOS CAMPOS
    $correo = trim($_POST["correo"]);
    $asunto = trim($_POST["asunto"]);
    $mensaje = trim($_POST["mensaje"]);

    if($asunto === "" || $mensaje === ""){
        echo json_encode([
            "enviado" => false, 
            "error" => "El asunto y el mensaje son obligatorios."
            ]);
        exit;
    }

    $api = "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";
    $url_brevo = "https://api.brevo.com/v3/smtp/email";

    $correo_enviar_al_usuario = [
        "sender" => ["name" => "Clíniko", "email" => "francisco.javier.muriel.orta@ieslaarboleda.es"],
        "to" => [["email" => $correo]],
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
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($correo_enviar_al_usuario));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_exec($curl);
    curl_close($curl);

    echo json_encode(["enviado" => true]);
    exit;
}


$pagina = 1;
if(isset($_GET["pagina"])){
    $pagina = intval($_GET["pagina"]);
}

//LOS REGISTROS QUE SE MUESTRAN POR PÁGINA
$registros = 4;
$inicio = ($pagina - 1) * $registros;

$busqueda = "";
if(isset($_GET["busqueda"]) && $_GET["busqueda"] !== ""){
    $busqueda = trim($_GET["busqueda"]);
}

$rol = "";
if(isset($_GET["rol"]) && $_GET["rol"] !== ""){
    $rol = $_GET["rol"];
}

$fecha = "";
if(isset($_GET["fecha"]) && $_GET["fecha"] !== ""){
    $fecha = $_GET["fecha"];
}

$estado = "";
if(isset($_GET["estado"]) && $_GET["estado"] !== ""){
    $estado = $_GET["estado"];
}

$total = contarUsuariosEnviar($conexion, $busqueda, $rol, $fecha, $estado);
$total_paginas = ceil($total / $registros);
$usuarios = obtenerUsuariosEnviar($conexion, $inicio, $registros, $busqueda, $rol, $fecha, $estado);

echo json_encode([
    "usuarios" => $usuarios,
    "total_paginas" => $total_paginas
]);
?>