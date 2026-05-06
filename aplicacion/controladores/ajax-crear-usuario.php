<?php
header("Content-Type: application/json; charset=utf-8");
require_once "../configuracion/config.php";
require_once "../modelos/ajax-crear-usuario-modelo.php";
session_start();

//SE VERIFICAL ID DEL ADMIN
if(!isset($_SESSION["id_usuario"])){
    exit;
}

//VARIABLE DONDE SE VAN A IR GUARDANDO LOS ERRORES ENC ASO DE QUE HAYA ALGUNO
$errores = [];

//VALIDACIONES DE LOS CAMPOS
//NOMBRE
if(isset($_POST["nombre"])){
    $nombre = trim($_POST["nombre"]);
}

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
$apellidos = "";
if(isset($_POST["apellidos"])){
    $apellidos = trim($_POST["apellidos"]);
}

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

//CORREO
$correo = "";
if(isset($_POST["correo"])){
    $correo = trim($_POST["correo"]);
}

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

//TELÉFONO
$telefono = "";
if(isset($_POST["telefono"])){
    $telefono = trim($_POST["telefono"]);
}

if(empty($telefono)){
    $errores[] = "El teléfono es obligatorio.";
}elseif(!preg_match("/^[0-9]{9}$/", $telefono)){
    $errores[] = "El teléfono debe contener exactamente 9 números.";
}

//CONTRASEÑA
$contrasena = "";
if(isset($_POST["contrasena"])){
    $contrasena = $_POST["contrasena"];
}

$contrasena2 = "";
if(isset($_POST["contrasena2"])){
    $contrasena2 = $_POST["contrasena2"];
}

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
if($contrasena !== $contrasena2){
    $errores[] = "Las contraseñas no coinciden.";
}

//EL TIPO DE USUARIO
$rol = "";
if(isset($_POST["rol"])){
    $rol = $_POST["rol"];
}

if(empty($rol)){
   $errores[] = "Debes elegir un tipo de usuario."; 
}

//FOTO. COMO EL USUARIO LO CREA EL ADMIN, ENTONCES NO LE VA A SUBIR UNA FOTO. LE PONE LA QUE SALE POR DEFECTO.s
$nombreArchivo = "por_defecto.png";

//VALIDACIONES DE LOS CAMPOS DEL PACIENTE
$fecha_nacimiento = "";
if(isset($_POST["fecha_nacimiento"])){
    $fecha_nacimiento = $_POST["fecha_nacimiento"];
}

$direccion = "";
if(isset($_POST["direccion"])){
    $direccion = trim($_POST["direccion"]);
}

$nss = "";
if(isset($_POST["nss"])){
    $nss = trim($_POST["nss"]);
}

if($rol === "paciente"){
    if(empty($fecha_nacimiento)){
        $errores[] = "La fecha de nacimiento es obligatoria.";
    }else{
        $hoy = new DateTime();
        $fecha = new DateTime($fecha_nacimiento);
        $edad = $hoy->diff($fecha)->y;
        if($edad < 18){
            $errores[] = "El usuario debe tener al menos 18 años.";
        }
    }
    if(empty($direccion)){
        $errores[] = "La dirección es obligatoria.";
    }elseif(!preg_match("/^[A-ZÁÉÍÓÚÑa-záéíóúñ0-9 ]+$/", $direccion)){
        $errores[] = "La dirección solo puede contener letras y números.";
    }
    if(!empty($nss)){
        $nss_sin_espacios = preg_replace("/\D/", "", $nss);
        if(strlen($nss_sin_espacios) !== 12){
            $errores[] = "El NSS debe tener exactamente 12 dígitos.";
        }else{
            $nss_limpio = mysqli_real_escape_string($conexion, $nss_sin_espacios);

            $sql = "SELECT id_paciente FROM pacientes WHERE REPLACE(nss, ' ', '') = '$nss_limpio'";

            $resultado = mysqli_query($conexion, $sql);
            if(mysqli_num_rows($resultado) > 0){
                $errores[] = "Este NSS ya está registrado.";
            }
        }
    }
}

//VALIDACIONES DE LOS CAMPOS DEL MÉDICO
$numero_colegiado = "";
if(isset($_POST["numero_colegiado"])){
    $numero_colegiado = trim($_POST["numero_colegiado"]);
}

$id_especialidad = "";
if(isset($_POST["id_especialidad"])){
    $id_especialidad = $_POST["id_especialidad"];
}

if($rol === "medico"){
    if(empty($numero_colegiado)){
        $errores[] = "El número de colegiado es obligatorio.";
    }elseif(!preg_match("/^[0-9]{9}$/", $numero_colegiado)){
        $errores[] = "El número de colegiado debe contener 9 números.";
    }else{
        $numColegiado_limpio = mysqli_real_escape_string($conexion, $numero_colegiado);

        $sql = "SELECT id_medico FROM medicos WHERE numero_colegiado = '$numColegiado_limpio'";

        $resultado = mysqli_query($conexion, $sql);
        if(mysqli_num_rows($resultado) > 0){
            $errores[] = "Este número de colegiado ya está registrado.";
        }
    }
    if(empty($id_especialidad)){
        $errores[] = "La especialidad es obligatoria.";
    }
}

if(!empty($errores)){
    echo json_encode([
        "creacion_usuario_ok" => false,
        "creacion_usuario_error" => implode("<br>", $errores)
        ]);
    exit;
}

$id_usuario = crearUsuarioAdmin($conexion, $nombre, $apellidos, $correo, $contrasena, $rol, $telefono, $nombreArchivo);

if($rol === "paciente"){
    crearPacienteAdmin($conexion, $id_usuario, $fecha_nacimiento, $direccion, $nss, $telefono);
}

if($rol === "medico"){
    crearMedicoAdmin($conexion, $id_usuario, $id_especialidad, $numero_colegiado);
}

echo json_encode([
    "creacion_usuario_ok" => true
    ]);
?>