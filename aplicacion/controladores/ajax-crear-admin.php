<?php
header("Content-Type: application/json; charset=utf-8");
require_once "../configuracion/config.php";
require_once "../modelos/ajax-crear-admin-modelo.php";
session_start();

//VERIFICO AL ADMIN
if(!isset($_SESSION["id_usuario"])){
    exit;
}

//DONDE GUARDO LOS ERRORES
$errores = [];

$nombre = "";
if(isset($_POST["nombre"])){
    $nombre = trim($_POST["nombre"]);
}

$apellidos = "";
if(isset($_POST["apellidos"])){
    $apellidos = trim($_POST["apellidos"]);
}

$telefono = "";
if(isset($_POST["telefono"])){
    $telefono = trim($_POST["telefono"]);
}

$correo = "";
if(isset($_POST["correo"])){
    $correo = trim($_POST["correo"]);
}

$contrasena = "";
if(isset($_POST["contrasena"])){
    $contrasena = $_POST["contrasena"];
}

$contrasena2 = "";
if(isset($_POST["contrasena2"])){
    $contrasena2 = $_POST["contrasena2"];
}

//VALIDACIONES
//NOMBRE
if(empty($nombre)){
    $errores[] = "El nombre es obligatorio.";
}else{
    $palabras = array_filter(explode(" ", $nombre));
    if(count($palabras) > 2){
        $errores[] = "El nombre no puede ser más de 2 palabras.";
    }
    if(strlen(str_replace(" ", "", $nombre)) > 20){
        $errores[] = "El nombre no puede tener más de 20 caracteres.";
    }
    if(!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/u", $nombre)){
        $errores[] = "El nombre solo puede contener letras y espacios.";
    }
}

//APELLIDOS
if(empty($apellidos)){
    $errores[] = "Los apellidos son obligatorios.";
}else{
    $palabras = array_filter(explode(" ", $apellidos));
    if(count($palabras) > 2){
        $errores[] = "Los apellidos no pueden ser más de 2 palabras.";
    }
    if(strlen(str_replace(" ", "", $apellidos)) > 20){
        $errores[] = "Los apellidos no pueden tener más de 20 caracteres.";
    }
    if(!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/u", $apellidos)){
        $errores[] = "Los apellidos solo pueden contener letras y espacios.";
    }
}

//TELÉFONO
if(empty($telefono)){
    $errores[] = "El teléfono es obligatorio.";
}elseif(!preg_match("/^[0-9]{9}$/", $telefono)){
    $errores[] = "El teléfono debe contener exactamente 9 números.";
}

//CORREO ELECTRÓNICO
if(empty($correo)){
    $errores[] = "El correo es obligatorio.";
}else{
    if(!filter_var($correo, FILTER_VALIDATE_EMAIL)){
        $errores[] = "El correo no tiene un formato válido.";
    }

    $correo_limpio = mysqli_real_escape_string($conexion, $correo);
    
    $sql = "SELECT id_usuario FROM usuarios WHERE correo = '$correo_limpio'";

    $resultado = mysqli_query($conexion, $sql);
    if(mysqli_num_rows($resultado) > 0){
        $errores[] = "Este correo ya existe en el sistema.";
    }
}

//CONTRASEÑA
if(empty($contrasena)){
    $errores[] = "La contraseña es obligatoria.";
}else{
    if(strlen($contrasena) < 8){
       $errores[] = "La contraseña debe tener mínimo 8 caracteres."; 
    }
    if(!preg_match("/[A-Z]/", $contrasena)){
        $errores[] = "La contraseña debe contener al menos una mayúscula.";
    }
    if(!preg_match("/[a-z]/", $contrasena)){
        $errores[] = "La contraseña debe contener al menos una minúscula.";
    }
    if(!preg_match("/[0-9]/", $contrasena)){
        $errores[] = "La contraseña debe contener al menos un número.";
    }
    if(!preg_match("/[.\-_]/", $contrasena)){
        $errores[] = "La contraseña debe contener al menos un carácter especial: '.', '-' o '_'";
    }
}

if($contrasena !== $contrasena2) $errores[] = "Las contraseñas no coinciden.";

//SI HAY ERRORES LOS MOTRAMOS EN EL MODAL
if(!empty($errores)){
    echo json_encode([
        "admin_creado" => false, 
        "error_al_crear_admin" => implode("<br>", $errores)
        ]);
    exit;
}

$resultado = crearAdministrador($conexion, $nombre, $apellidos, $telefono, $correo, $contrasena);
echo json_encode([
    "admin_creado" => $resultado
    ]);
?>