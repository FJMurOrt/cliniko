<?php
require_once '../modelos/usuario.php';

//RECOGEMOS LOS DATOS DEL FORMULARIO
$nombre = $_POST["nombre"];
$apellidos = $_POST["apellidos"];
$correo = $_POST["correo"];
$contrasena = $_POST["contrasena"];
$rol = $_POST["rol"];
$telefono = $_POST["telefono"];
$fecha_nacimiento = $_POST["fecha_nacimiento"];
$direccion = $_POST["direccion"];
$nss = $_POST["nss"];
$numero_colegiado = $_POST["numero_colegiado"];

if (isset($_POST["id_especialidad"]) && $_POST["id_especialidad"] !== "") {
    $id_especialidad = $_POST["id_especialidad"];
}else {
    $id_especialidad = null;
}

//SUBIMOS LA IMAGEN
$nombreArchivo = "";
if(isset($_FILES["foto"]) && $_FILES["foto"]["error"] == 0) {
    $nombreArchivo = $_FILES["foto"]["name"];
    $rutaOrigen = $_FILES["foto"]["tmp_name"];
    $rutaDestino = '../../uploads/perfiles/' . $nombreArchivo;
    move_uploaded_file($rutaOrigen, $rutaDestino);
}

//GUARDAMOS LOS DATOS EN LA BASE DE DATOS.
if(registrarUsuario($conexion, $nombre, $apellidos, $correo, $contrasena, $rol, $telefono, $fecha_nacimiento, $direccion, $nss, $numero_colegiado, $id_especialidad, $nombreArchivo)) {
    echo "El usuario se registró correctamente";
} else {
    echo "No se pudo registrar al usuario";
}
?>