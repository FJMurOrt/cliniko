<?php
session_start();
require_once "../configuracion/config.php";

//RECOGEMOS EL VALOR DEL CORREO
$correo = trim($_POST["correo"]);

//VALIDACIÓN PARA QUE EL CAMPO NO ESTÉ VACÍO Y SEA UN CORREO VÁLIDO
if (empty($correo) || !filter_var($correo, FILTER_VALIDATE_EMAIL)) {
    $_SESSION["errores"] = ["Por favor, introduce un correo válido."];
    header("Location: ../../recuperar-contrasena.php");
    exit;
}

//CONSULTA SEGURA DEL USUARIO
$consulta = mysqli_prepare($conexion, "SELECT id_usuario, nombre FROM usuarios WHERE correo = ?");
mysqli_stmt_bind_param($consulta, "s", $correo);
mysqli_stmt_execute($consulta);
$resultado = mysqli_stmt_get_result($consulta);
$usuario_registro = mysqli_fetch_assoc($resultado);
mysqli_stmt_close($consulta);

//SI EXISTE EL USUARIO, GENERAMOS EL TOKEN
if ($usuario_registro) {

    //GENERACIÓN DEL TOKEN Y FECHA DE CADUCIDAD
    $token = bin2hex(random_bytes(16));
    $f_caduca = date("Y-m-d H:i:s", strtotime("+30 minutes"));

    //INSERTAMOS EL TOKEN EN LA TABLA DE RECUPERACION DE CONTRASEÑAS
    $consultaToken = mysqli_prepare($conexion, "INSERT INTO recuperacion_de_contrasenas (id_usuario, token, fecha_caduca) VALUES (?, ?, ?)");
    mysqli_stmt_bind_param($consultaToken, "iss", $usuario_registro["id_usuario"], $token, $f_caduca);
    mysqli_stmt_execute($consultaToken);
    mysqli_stmt_close($consultaToken);

    //Y ENVIAMOS EL CORREO JUNTO CON EL TOKEN
    $api = "CLAVE QUE NO PUEDO SUBIR A GITHUB"; 
    $url = "https://api.brevo.com/v3/smtp/email";
    $enlace_recuperar = "http://localhost/cliniko_copia_con_datos_para_local-copia/cambiar-contrasena.php?token=$token";

    $correoEmail = [
        "sender" => ["name" => "Clíniko", "email" => "francisco.javier.muriel.orta@ieslaarboleda.es"],
        "to" => [["email" => $correo]],
        "subject" => "Recuperar contraseña",
        "htmlContent" => "<h1>¡Hola ".$usuario_registro["nombre"]."!</h1>".
                         "<p>Para ayudarte a recuperar o reestablecer tu contraseña, haz clic <a href='$enlace_recuperar'>aquí</a>.</p>"
    ];

    $manjeador_cURL = curl_init($url);
    curl_setopt($manjeador_cURL, CURLOPT_HTTPHEADER, [
        "api-key: $api",
        "Content-Type: application/json",
        "accept: application/json"
    ]);
    curl_setopt($manjeador_cURL, CURLOPT_POST, 1);
    curl_setopt($manjeador_cURL, CURLOPT_POSTFIELDS, json_encode($correoEmail));
    curl_setopt($manjeador_cURL, CURLOPT_RETURNTRANSFER, true);

    $respuesta = curl_exec($manjeador_cURL);
    curl_close($manjeador_cURL);

    header("Location: ../../enviada-recuperacion.php");
    exit;

}else{
    $_SESSION["errores"] = ["El correo no es válido."];
    header("Location: ../../recuperar-contrasena.php");
    exit;
}
?>
