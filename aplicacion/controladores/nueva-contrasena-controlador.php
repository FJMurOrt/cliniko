<?php
session_start();
require_once '../configuracion/config.php';

//RECIBIMOS LAS NUEVAS CONTRASEÑAS Y EL TOKEN PARA SABER A QUIÉN CAMBIARLE LAS CONTRASEÑA
if (isset($_POST['token'])){
    $token = $_POST['token'];
}else{
    $token = '';
}

if(isset($_POST['contrasena1'])){
    $contrasena1 = $_POST['contrasena1'];
}else{
    $contrasena1 = '';
}

if(isset($_POST['contrasena2'])){
    $contrasena2 = $_POST['contrasena2'];
}else{
    $contrasena2 = '';
}

//VALIDAMOS ANTES QUE LOS DATOS LOS TENGAMOS Y NO TENGAMOS NADA VACÍO
if(empty($token) || empty($contrasena1) || empty($contrasena2)){
    $_SESSION['errores'] = ["Debes introducir tu nueva contraseña."];
    header("Location: ../../cambiar-contrasena.php?token=$token");
    exit;
}

if($contrasena1 !== $contrasena2){
    $_SESSION['errores'] = ["Las contraseñas no coinciden."];
    header("Location: ../../cambiar-contrasena.php?token=$token");
    exit;
}

if(strlen($contrasena1) < 8){
    $_SESSION['errores'] = ["La contraseña debe tener como mínimo 8 caracteres."];
    header("Location: ../../cambiar-contrasena.php?token=$token");
    exit;
}

//BUSCAMOS EL TOKEN EN LA BASE DE DATOS
$token = mysqli_real_escape_string($conexion, $token);
$sql = "SELECT id_usuario, fecha_caduca FROM recuperacion_de_contrasenas WHERE token='$token'";
$resultado = mysqli_query($conexion, $sql);

if(mysqli_num_rows($resultado) !== 1){
    $_SESSION['errores'] = ["Ocurrió un error al intentar acceder al cambio de contraseña."];
    header("Location: ../../recuperar-contrasena.php");
    exit;
}

$registro = mysqli_fetch_assoc($resultado);
$fecha_actual = date('Y-m-d H:i:s');
if($fecha_actual > $registro['fecha_caduca']){
    $_SESSION['errores'] = ["El enlace ha caducado. Vuelve a solicitar el cambio de contraseña."];
    header("Location: ../../recuperar-contrasena.php");
    exit;
}

//ACTUALIZAMOS LA CONTRASEÑA
$hash = password_hash($contrasena1, PASSWORD_DEFAULT);
$sql2 = "UPDATE usuarios SET contrasena='$hash' WHERE id_usuario={$registro['id_usuario']}";
mysqli_query($conexion, $sql2);

//Y BORRAMOS EL TOKEN PARA QUE EL USUARIO NO PUEDA DE NUEVO ACCEDER AL ENLACE Y PODER CAMBIAR LA CONTRASEÑA
$sql3 = "DELETE FROM recuperacion_de_contrasenas WHERE token='$token'";
mysqli_query($conexion, $sql3);

header("Location: ../../confirmacion-nueva-contrasena.php");
exit;
?>
