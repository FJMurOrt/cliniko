<?php
header("Content-Type: application/json; charset=utf-8");
require_once "../configuracion/config.php";
session_start();

//RECOGEMOS EL ID DE LA CITA QUE VAMOS A CONFIRMAR Y SI NO TENEMOS NADA, EL ASOCIATIVO PONEMOS FALSO EN CONFIRMADA Y EL MENSAJE DE ERROR
if(!isset($_GET["id_cita"])){
    echo json_encode([
        "confirmada" => false, 
        "error" => "No se recibió el ID de la cita"
        ]);
    exit;
}

//LAS GUARDAMOS EN UNA VARIABLE
$id_cita = intval($_GET["id_cita"]);
$id_medico = $_SESSION["id_usuario"];

//ACTUALIZAMOS LA CITA A CONFIRMADA 
$sql = "UPDATE citas SET estado = 'confirmada', fecha_actualizacion = NOW()
        WHERE id_cita = $id_cita AND id_medico = $id_medico AND estado = 'pendiente'";

$resultado = mysqli_query($conexion, $sql);

//CREAMOS UNA VARIBALE QUE ES LA QUE VAMOS A DEVOLVER CON LA RESPUESTA
$respuesta = [
    "confirmada" => 
    false, "error" => ""
    ];

if($resultado && mysqli_affected_rows($conexion) > 0){
    $respuesta["confirmada"] = true;
}else{
    $respuesta["error"] = "No se pudo confirmar la cita";
    echo json_encode($respuesta);
    exit;
}

//AHORA LE ENVIAMOS EL CORREO AL PACIENTE
$sql_cita = "SELECT c.fecha_cita, c.motivo, c.id_paciente, u.nombre, u.apellidos, u.correo FROM citas c
             INNER JOIN usuarios u ON c.id_paciente = u.id_usuario
             WHERE c.id_cita = $id_cita";

$res_cita = mysqli_query($conexion, $sql_cita);
$cita_info = mysqli_fetch_assoc($res_cita);

if(!$cita_info){
    echo json_encode([
        "confirmada" => true,
        "error" => "No se pudo obtener la información del paciente"
    ]);
    exit;
}

$fecha_hora = strtotime($cita_info["fecha_cita"]);
$fecha_formato = date("d/m/Y", $fecha_hora);
$hora_formato = date("H:i", $fecha_hora);
$motivo = trim($cita_info["motivo"]);
$id_paciente = $cita_info["id_paciente"];

//INSERTARMOS QUE SE HA CONFIRMADO LA CITA EN LA TABLA DE NOTIFICACIONES
$mensaje_de_la_notificacion = "Tu cita del $fecha_formato a las $hora_formato ha sido confirmada";
$sql_notificacion = "INSERT INTO notificaciones (id_usuario, tipo, mensaje, id_cita) 
                     VALUES ($id_paciente, 'cita_confirmada', '$mensaje_de_la_notificacion', $id_cita)";

mysqli_query($conexion, $sql_notificacion);

//CONSTRUYO EL MENSAJE PARA EL CORREO
$asunto = "Tu cita ha sido confirmada";
$mensaje = "<h2>¡Tu cita médica ha sido confimada!</h2>";
$mensaje = "<p>Hola ".$cita_info["nombre"]." ".$cita_info["apellidos"].","."</p>";
$mensaje .= "<p>Te escribimos para comunicarte que tu cita ha sido confirmada y tendrá lugar el:</p>";
$mensaje .= "<ul style='list-style: none;'>";
$mensaje .= "<li><u>Fecha</u>: ".$fecha_formato."</li>";
$mensaje .= "<li><u>Hora</u>: ".$hora_formato."</li>";
$mensaje .= "<li><u>Motivo</u>: ".htmlspecialchars($motivo)."</li>";
$mensaje .= "</ul>";
$mensaje .= "<p>Recuerda que la cancelación gratuita solo es posible si se realiza al menos 24 horas antes de la cita, o si la cancelación es efectuada por el médico.</p>";
$mensaje .= "<p>Saludos cordiales,</p>";
$mensaje .= "<p>El equipo de Clíniko</p>";

$api = "CLAVE QUE NO PUEDO SUBIR A GITHUB";
$url = "https://api.brevo.com/v3/smtp/email";

//SINTAXIS PREDERTERMINADA DE BREVO PAR APODER ENVIAR EL CORREO
$correoEmail = [
    "sender" => ["name" => "Clíniko", "email" => "francisco.javier.muriel.orta@ieslaarboleda.es"],
    "to" => [["email" => $cita_info["correo"]]],
    "subject" => $asunto,
    "htmlContent" => $mensaje
];

$curl = curl_init($url);
curl_setopt($curl, CURLOPT_HTTPHEADER, [
    "api-key: $api",
    "Content-Type: application/json",
    "accept: application/json"
]);
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($correoEmail));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$respuesta_api = curl_exec($curl);
curl_close($curl);

echo json_encode($respuesta);
?>