<?php
session_start();
require_once '../configuracion/config.php';

//RECOGEMOS EL VALOR DEL CORREO
$correo = trim($_POST['correo']);

//VALIDACIÓN PARA QUE EL CAMPO NO ESTE VACÍO Y OBVIAMENTE SEA UN CORREO TAMBIÉN
if (empty($correo) || !filter_var($correo, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['errores'] = ["Por favor, introduce un correo válido."];
    header("Location: ../../recuperar-contrasena.php");
    exit;
}

//ESCAPAMOS EL CORREO PARA SQL
$correo = mysqli_real_escape_string($conexion, $correo);
//HACEMOS LA CONSULTA A LA BASE DE DATOS
$sql = "SELECT id_usuario, nombre FROM usuarios WHERE correo='$correo'";
$resultado = mysqli_query($conexion, $sql);

if(mysqli_num_rows($resultado) == 1){
    $usuario_registro = mysqli_fetch_assoc($resultado);

    //SI EXISTE UN USUARIO CON ESE NOMBRE Y CORREO GENERAMOS EL TOKEN
    $token = bin2hex(random_bytes(16));
    $f_caduca = date('Y-m-d H:i:s', strtotime('+30 minutes'));

    $sql2 = "INSERT INTO recuperacion_de_contrasenas (id_usuario, token, fecha_caduca) VALUES ({$usuario_registro['id_usuario']}, '$token', '$f_caduca')";
    mysqli_query($conexion, $sql2);

    //ENVIAMOS EL CORREO CON LA API
    $api = "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";
    $url = "https://api.brevo.com/v3/smtp/email";
    $enlace_recuperar = "http://localhost/cliniko_copia_con_datos_para_local - copia/cambiar-contrasena.php?token=$token";

    $correo = [
        "sender" => ["name" => "Clíniko", "email" => "francisco.javier.muriel.orta@ieslaarboleda.es"],
        "to" => [["email" => $correo]],
        "subject" => "Recuperar contraseña",
        "htmlContent" => "<h1>¡Hola ".$usuario_registro['nombre']."!</h1>"."<p>Para ayudarte a recuperar a reestablecer tu contraseña, haz clic <a href='$enlace_recuperar'>aquí</a>.</p>"
    ];

    $manjeador_cURL = curl_init($url);
    curl_setopt($manjeador_cURL, CURLOPT_HTTPHEADER, [
        "api-key: $api",
        "Content-Type: application/json",
        "accept: application/json"
    ]);
    curl_setopt($manjeador_cURL, CURLOPT_POST, 1);
    curl_setopt($manjeador_cURL, CURLOPT_POSTFIELDS, json_encode($correo));
    curl_setopt($manjeador_cURL, CURLOPT_RETURNTRANSFER, true);

    $respuesta = curl_exec($manjeador_cURL);
    curl_close($manjeador_cURL);

    header("Location: ../../enviada-recuperacion.php");
    exit;
} else {
    $_SESSION['errores'] = ["El correo no es válido."];
    header("Location: ../../recuperar-contrasena.php");
    exit;
}
?>
