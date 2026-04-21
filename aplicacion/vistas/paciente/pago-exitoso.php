<?php
session_start();
require_once "../../configuracion/config.php";

//SI NO SE HUBIERAN REGODIO LOS DATOS POR ALGUN ERROR
if(!isset($_SESSION["cita_solicitada"])){
    echo "No hay datos guardados de la cita.";
    exit;
}

$cita = $_SESSION["cita_solicitada"];

//HACEMOS EL INSERT EN LA TABLA DE CITAS
$fecha_cita = $cita["fecha"]." ".$cita["hora"];

$sql = "INSERT INTO citas (id_paciente, id_medico, fecha_cita, motivo, estado) VALUES (?, ?, ?, ?, 'pendiente')";

$consulta = mysqli_prepare($conexion, $sql);
mysqli_stmt_bind_param($consulta, "iiss", $cita["id_paciente"], $cita["id_medico"], $fecha_cita, $cita["motivo"]);
mysqli_stmt_execute($consulta);
mysqli_stmt_close($consulta);

//AHORA VAMOS A ENVIAR UN CORREO AL MÉDICO PARA QUE SEPA QUE SE HA SOLICITADO UNA CITA CON ÉL
//PRIMERO VAMOS A OBTENER DATOS DEL PACIENTE
$id_paciente = $cita["id_paciente"];

$sql_paciente = "SELECT nombre, apellidos FROM usuarios WHERE id_usuario = ?";

$datos_paciente = mysqli_prepare($conexion, $sql_paciente);
mysqli_stmt_bind_param($datos_paciente, "i", $id_paciente);
mysqli_stmt_execute($datos_paciente);

$resultados_paciente = mysqli_stmt_get_result($datos_paciente);
$paciente = mysqli_fetch_assoc($resultados_paciente);
mysqli_stmt_close($datos_paciente);

//Y AHORA LOS DEL MEDICOS POR TAMBIÉN
$id_medico = $cita["id_medico"];

$sql_medico = "SELECT nombre, apellidos, correo FROM usuarios WHERE id_usuario = ?";

$datos_medico = mysqli_prepare($conexion, $sql_medico);
mysqli_stmt_bind_param($datos_medico, "i", $id_medico);
mysqli_stmt_execute($datos_medico);

$resultados_medico = mysqli_stmt_get_result($datos_medico);
$medico = mysqli_fetch_assoc($resultados_medico);
mysqli_stmt_close($datos_medico);

//ENVÍO DEL CORREO AL MÉDICO
$api = "CLAVE QUE NO PUEDO SUBIR A GITHUB";
$url = "https://api.brevo.com/v3/smtp/email";

//LE PONEMOS EL FORMATO BIEN A LA FECHA Y LA HORA
$hora_inicio = explode("-", $cita["hora"])[0];
$fecha_y_hora = $cita["fecha"]." ".$hora_inicio;

//LO PASAMOS A FORMATO DE TIEMPO CORRECTO
$fecha_y_hora_en_formato_tiempo = strtotime($fecha_y_hora);

//Y AHORA EXTRAEMOS CADA UNO
$fecha_con_formato_bueno = date("d/m/Y", $fecha_y_hora_en_formato_tiempo);
$hora_cita = date("H:i", $fecha_y_hora_en_formato_tiempo);
$turno = $cita["turno"];

//VAMOS A VER SI EL MOTIVO TIENE ALGO Y SI NO PONEMOS UN MENSAJE POR DEFECTO
$motivo = trim($cita["motivo"]);
if($motivo === ""){
    $motivo = "No se especifica el motivo";
}

//EL MENSAJE QUE VAMOS A METER EN EL CORREO
$asunto = "Nueva cita solicitada por ".$paciente["nombre"]." ".$paciente["apellidos"];
$mensaje = "<h2>Estimado ".$medico["nombre"]." ".$medico["apellidos"].",</h2>";
$mensaje .= "<p>El paciente".$paciente["nombre"]." ".$paciente["apellidos"]." ha solicitado una cita contigo.</p>";
$mensaje .= "<ul style='list-style: none;'>";
$mensaje .= "<li><u>Fecha</u>: ".$fecha_con_formato_bueno."</li>";
$mensaje .= "<li><u>Turno</u>: ".$turno."</li>";
$mensaje .= "<li><u>Hora</u>: ".$hora_cita."</li>";
$mensaje .= "<li><u>Motivo</u>: ".htmlspecialchars($motivo)."</li>";
$mensaje .= "</ul>";
$mensaje .= "<p>Por favor, confirma la cita para notificar a tu paciente cuanto antes.</p>";
$mensaje .= "<p>Saludos cordiales,</p>";
$mensaje .= "<p>El equipo de Clíniko</p>";

// DATOS PARA LA API DE BREVO
$correo_que_se_le_envia = [
    "sender" => ["name" => "Clíniko", "email" => "francisco.javier.muriel.orta@ieslaarboleda.es"],
    "to" => [["email" => $medico["correo"]]],
    "subject" => $asunto,
    "htmlContent" => $mensaje
];

// EJECUTAR PETICIÓN CURL
$manjeador_cURL = curl_init($url);
curl_setopt($manjeador_cURL, CURLOPT_HTTPHEADER, [
    "api-key: $api",
    "Content-Type: application/json",
    "accept: application/json"
]);
curl_setopt($manjeador_cURL, CURLOPT_POST, 1);
curl_setopt($manjeador_cURL, CURLOPT_POSTFIELDS, json_encode($correo_que_se_le_envia));
curl_setopt($manjeador_cURL, CURLOPT_RETURNTRANSFER, true);

$respuesta = curl_exec($manjeador_cURL);
curl_close($manjeador_cURL);

//PARA INSERTAR LA NOTIFIACIÓN PARA EL MÉDICO DE QUE UN PACIENTE HA SOLICITADO CITA CON ÉL
$mensaje_de_la_notificacion = "El paciente ".$paciente["nombre"]." ".$paciente["apellidos"]." ha solicitado una cita contigo el ".$fecha_con_formato_bueno." a las ".$hora_cita.".";

$consultar_antes_si_existe_notificacion = "SELECT id_notificacion FROM notificaciones WHERE id_usuario = ? AND tipo = 'cita_confirmada' AND mensaje = ?";

$preparacion_de_la_consulta = mysqli_prepare($conexion, $consultar_antes_si_existe_notificacion);
mysqli_stmt_bind_param($preparacion_de_la_consulta, "is", $id_medico, $mensaje_de_la_notificacion);
mysqli_stmt_execute($preparacion_de_la_consulta);

$resultado_si_existe = mysqli_stmt_get_result($preparacion_de_la_consulta);

mysqli_stmt_close($preparacion_de_la_consulta);

if(mysqli_num_rows($resultado_si_existe) === 0){
    $sql_notificacion = "INSERT INTO notificaciones (id_usuario, tipo, mensaje) VALUES (?, 'cita_confirmada', ?)";
    
    $preparacion_notificacion = mysqli_prepare($conexion, $sql_notificacion);
    mysqli_stmt_bind_param($preparacion_notificacion, "is", $id_medico, $mensaje_de_la_notificacion);
    mysqli_stmt_execute($preparacion_notificacion);
    
    mysqli_stmt_close($preparacion_notificacion);
}

//BORRAMOS LOS DATOS DE LA CITA QUE HEMOS GUARDADO EL SESION PARA QUE NO SE MEZCLE CON LA SIGUIENTE
unset($_SESSION["cita_solicitada"]);

//Y VOLVEMOS A LA PÁGINA DE PAGO REALIZO PERFECTAMENTE
header("Location: pago-aceptado.php");
exit;
?>















