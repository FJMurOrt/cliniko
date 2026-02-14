<?php
//INIDICAMOS LA SESSIÓN Y VINCULAMOS EL ACHIVO DEL MODELO USUARIO.PHP QUE ES BÁSCIAMNENTE DONDE TENEMOS LA FUNCIÓN QUE AGREGA EL USUARIO EN LA BASE DE DATOS.
session_start();
require_once '../modelos/usuario.php';

//ARRAY DONDE VAMOS A IR GUARDANDO LOS ERRORES
$errores = [];

//RECOGEMOS LOS DATOS DEL FORMULARIO
//VALIDACIÓN DEL NOMBRE
if(isset($_POST["nombre"])){
    $nombre = trim($_POST["nombre"]);
} else {
    $nombre = "";
}

if(empty($nombre)){
    $errores[] = "El campo del nombre es obligatorio.";
}else{
    //SOLO DOS PALABRAS PARA EL NOMBRE
    $nombre = trim($nombre);
    $palabras = explode(" ", $nombre);
    $palabras = array_filter($palabras);

    if(count($palabras) > 2){
        $errores[] = "El nombre no puede ser más de 2 palabras.";
    }

    //CONTAMOS CUANTOS CARACTERES TIENE Y SI TIENE MÁS DE 20 NO ES VÁLIDO.
    $letras_en_total = strlen(str_replace(' ', '', $nombre));
    if($letras_en_total > 20){
        $errores[] = "El nombre no puede tener más de 20 caracteres.";
    }

    //SOLO PUEDE TENER LETRAS Y ESPACIOS.
    if(!preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/u', $nombre)){
        $errores[] = "El nombre solo puede contener letras y espacios (sin números ni caracteres especiales).";
    }
}

//VALIDACIÓN DE LOS APELLIDOS
if(isset($_POST["apellidos"])){
    $apellidos = trim($_POST["apellidos"]);
}else{
    $apellidos = "";
}

if(empty($apellidos)){
    $errores[] = "El campo de los apellidos es obligatorio.";
}else{
    //QUE NO SEAN MÁS DE DOS PALABRAS
    $apellidos = trim($apellidos);
    $palabras = explode(" ", $apellidos);
    $palabras = array_filter($palabras);

    if(count($palabras) > 2){
        $errores[] = "Los apellidos no pueden ser más de 2 palabras.";
    }

    //PARA QUE SÓLO PUEDA TENER 20 CARACTERES COMO EL NOMBRE
    $letras_en_total = strlen(str_replace(' ', '', $apellidos));
    if($letras_en_total > 20){
        $errores[] = "Los apellidos no pueden tener más de 20 caracteres.";
    }

    //PARA QUE SOLO PEUDA TENER LETRAS Y ESPACIOS
    if(!preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/u', $apellidos)){
        $errores[] = "Los apellidos solo pueden contener letras y espacios (sin números ni caracteres especiales).";
    }
}

//VALIDACIÓN DEL CORREO
if(isset($_POST["correo"])){
    $correo = trim($_POST["correo"]);
}else{
    $correo = "";
}

if(empty($correo)){
    $errores[] = "El campo del correo electrónico es obligatorio.";
}else{
    if(!filter_var($correo, FILTER_VALIDATE_EMAIL)){
        $errores[] = "El correo no cumple con el formato válido.";
    }else{
        $partes = explode('@', $correo);
        $usuario = $partes[0];

        if(!preg_match('/^[A-Za-z0-9._-]+$/', $usuario)){
            $errores[] = "El correo solo puede contener letras, números, '.', '-' o '_'";
        }
    }
}

//NOS ASEGURAMOS QUE EL CORREO NO EXISTA YA EN LA BASE DE DATOS
//HACEMOS LA CONSULTA ESCAPANDO LOS CARACTERES ESPECIALES QUE PUDIERA TENER EL CORREO CON LA FUNCCION DE REAL_ESCAPE_STRING
$correo_limpio = mysqli_real_escape_string($conexion, $correo);
$sql = "SELECT id_usuario FROM usuarios WHERE correo = '$correo_limpio'";
$resultado = mysqli_query($conexion, $sql);
if(mysqli_num_rows($resultado) > 0){
    $errores[] = "Este correo ya existe en nuestro sistema.";
}

//VALIDACIÓN DEL TELÉFONO
if(isset($_POST['telefono'])){
    $telefono = trim($_POST['telefono']);
}else{
    $telefono = '';
}

if(empty($telefono)){
    $errores[] = "El campo del teléfono es obligatorio.";
}elseif(!preg_match('/^[0-9]{9}$/', $telefono)){
    $errores[] = "El teléfono debe contener exactamente 9 números y sin espacios.";
}

//VALIDACIÓN DE LA CONTRASEÑA
if(isset($_POST['contrasena'])){
    $contrasena = $_POST['contrasena'];
}else{
    $contrasena = "";
}

if(empty($contrasena)){
    $errores[] = "El campo de la contraseña es obligatorio.";
}else {
    if(strlen($contrasena) < 8){
        $errores[] = "La contraseña debe tener como mínnimo 8 caracteres.";
    }
    if(!preg_match('/[A-Z]/', $contrasena)){
        $errores[] = "La contraseña debe contener al menos una letra mayúscula.";
    }
    if(!preg_match('/[a-z]/', $contrasena)){
        $errores[] = "La contraseña debe contener al menos una letra minúscula.";
    }
    if(!preg_match('/[0-9]/', $contrasena)){
        $errores[] = "La contraseña debe contener al menos un número.";
    }
    if(!preg_match('/[.\-_]/', $contrasena)){
        $errores[] = "La contraseña debe contener al menos un carácter especial: '.', '-' o '_'";
    }
}

//VALIDACIÓN DE LA SEGUNDA CONTRASEÑA
if(isset($_POST["contrasena2"])){
    $contrasena2 = $_POST["contrasena2"];
}else{
    $contrasena2 = "";
}

if(empty($contrasena2)){
    $errores[] = "Se necesita que introduzcas el segundo campo para la contraseña.";
}elseif($contrasena2 !== $contrasena){
    $errores[] = "Las contraseñas no coinciden.";
}

//VALIDACIÓN DEL ROL
if(isset($_POST["rol"])){
    $rol = $_POST["rol"];
}else{
    $rol = "";
}

if(empty($rol)){
    $errores[] = "Debes seleccionar qué tipo de usuario eres.";
}

//FECHA
if(isset($_POST["fecha_nacimiento"])){
    $fecha_nacimiento = $_POST["fecha_nacimiento"];
}else{
    $fecha_nacimiento = "";
}

//DIRECCIÓN
if(isset($_POST["direccion"])){
    $direccion = trim($_POST["direccion"]);
}else{
    $direccion = "";
}

//NÚMERO DE LA SEGURIDAD SOCIAL
if(isset($_POST["nss"])){
    $nss = trim($_POST["nss"]);
}else{
    $nss = "";
}

//VALIDACIÓN DEL CHECKBOX DE ACEPTAR LA POLÍTICA DE PRIVACIDAD.
if(!isset($_POST['acepta_politica'])){
    $errores[] = "Debes aceptar la política de privacidad para registrarte.";
}

//ELIMINAMOS LOS ESPACIOS O CUALQUIER OTRO CARACTER QUE NO SEA UN NÚMERO PARA PODER VALIDAR LOS 12 NÚMEROS DEL NÚMERO DE LA SEGURIDAD SOCIAL
if($rol === "paciente"){
    //BUSCAMOS CUALQUIER CARACTER QUE NO SEA UN NÚMERO Y LO SUSTITUIMOS POR NADA BÁSICAMENTE, ES DECIR, QUE NOS QUEDAMOS CON LO NÚMEROS SOLO.
    $nss_sin_espacios = preg_replace('/\D/', '', $nss);

    if(empty($nss)){
        $errores[] = "El campo del número de la seguridad social (NSS) es obligatorio para los pacientes.";
    }elseif (strlen($nss_sin_espacios) !== 12){
        $errores[] = "El número de la seguridad social (NSS) debe tener exactamente 12 dígitos.";
    }else{
        //COMPROBAMOS QUE NO EXISTA EL NSS YA EN LA BASE DE DATOS.
        $nss_limpio = mysqli_real_escape_string($conexion, $nss_sin_espacios);
        $sql = "SELECT id_paciente FROM pacientes WHERE REPLACE(nss, ' ', '') = '$nss_limpio'";
        $resultado = mysqli_query($conexion, $sql);

        if($resultado && mysqli_num_rows($resultado) > 0){
            $errores[] = "Este número de la seguridad social (NSS) ya está existe en nuestro sistema.";
        }
    }
}

if($rol === "paciente"){
    if(empty($fecha_nacimiento)){
        $errores[] = "El campo de la fecha de nacimiento es obligatoria para los pacientes.";
    }else{
        //COMPROBAMOS QUE EL USUARIO SEA MAYOR DE EDAD
        $hoy = new DateTime();
        $fecha = new DateTime($fecha_nacimiento);
        //CACULAMOS LA DIFERENCIA DE AÑOS DE LA FECHA ACTUAL CON LA FECHA QUE SE INTRODUCE.
        $edad = $hoy->diff($fecha)->y;

        if($edad < 18){
            $errores[] = "Debes tener al menos 18 años para poder registrarte.";
        }
    }

    if(empty($direccion)){
        $errores[] = "El campo de la dirección es obligatoria para pacientes.";
    }elseif(!preg_match('/^[A-Za-z0-9 ]+$/', $direccion)){
        $errores[] = "La dirección solo puede contener letras y números.";
    }
}

//AHORA VALIDAMOS SI ES MÉDICO
//RECIBIMOS EL NÚMERO DE COLEGIADO.
if(isset($_POST["numero_colegiado"])){
    $numero_colegiado = trim($_POST["numero_colegiado"]);
}else{
    $numero_colegiado = "";
}

//RECIBIMOS LA ESPECIALIDAD
if(isset($_POST["id_especialidad"])){
    $id_especialidad = $_POST["id_especialidad"];
}else{
    $id_especialidad = "";
}

if($rol === "medico"){
    if (empty($numero_colegiado)){
        $errores[] = "El campo de número de colegiado es obligatorio para los médicos.";
    }elseif (!preg_match('/^[0-9]{9}$/', $numero_colegiado)) {
        $errores[] = "El número de colegiado debe contener exactamente 9 números y sin espacios.";
    }

    if(empty($id_especialidad)){
        $errores[] = "Si eres médico, debes seleccionar una especialidad obligatoriamente.";
    }
}

//COMPROBAMOS TAMBIÉN QUE EL NÚMERO DE COLEGIADO DEL MÉDICO NO EXISTA YA EN LA BASE DE DATOS.
if($rol === "medico"){
    $numColegiado_limpio = mysqli_real_escape_string($conexion, $numero_colegiado);

    $sql = "SELECT id_medico FROM medicos WHERE numero_colegiado = '$numColegiado_limpio'";
    $resultado = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($resultado) > 0) {
        $errores[] = "Este número de colegiado ya se encuentra registrado.";
    }
}

//VALIDAMOS QUE HAYA FOTO
if(!isset($_FILES["foto"]) || $_FILES["foto"]["error"] !== 0){
    $errores[] = "La foto de perfil es obligatoria.";
}

//PARA GUARDAR LOS VALORES DE LOS CAMPOS CADA VEZ QUE SALTE ALGÚN ERROR Y NO SE RESETEEN Y TENGA QUE VOLVER A RELLENARLOS
$_SESSION['valores'] = [];

//GUARDAMOS EL NOMBRE.
if(isset($_POST['nombre'])){
    $_SESSION['valores']['nombre'] = $_POST['nombre'];
}else {
    $_SESSION['valores']['nombre'] = '';
}

//GUARDAMOS LOS APELLIDOS.
if(isset($_POST['apellidos'])){
    $_SESSION['valores']['apellidos'] = $_POST['apellidos'];
}else {
    $_SESSION['valores']['apellidos'] = '';
}

//GUARDAMOS EL CORREO.
if(isset($_POST['correo'])){
    $_SESSION['valores']['correo'] = $_POST['correo'];
}else {
    $_SESSION['valores']['correo'] = '';
}

//GUARDAMOS EL TELEFONO.
if(isset($_POST['telefono'])){
    $_SESSION['valores']['telefono'] = $_POST['telefono'];
}else {
    $_SESSION['valores']['telefono'] = '';
}

//GUARDAMOS EL TIPO DE ROL DEL USUARIO.
if(isset($_POST['rol'])) {
    $_SESSION['valores']['rol'] = $_POST['rol'];
}else {
    $_SESSION['valores']['rol'] = '';
}

//GUARDAMOS LA FECHA DE NACIMIENTO.
if(isset($_POST['fecha_nacimiento'])){
    $_SESSION['valores']['fecha_nacimiento'] = $_POST['fecha_nacimiento'];
}else {
    $_SESSION['valores']['fecha_nacimiento'] = '';
}

//GUARDAMOS LA DIRECCIÓN.
if(isset($_POST['direccion'])){
    $_SESSION['valores']['direccion'] = $_POST['direccion'];
}else {
    $_SESSION['valores']['direccion'] = '';
}

//GUARDAMOS EL NÚMERO DE LA SEGURIDAD SOCIAL.
if(isset($_POST['nss'])){
    $_SESSION['valores']['nss'] = $_POST['nss'];
}else{
    $_SESSION['valores']['nss'] = '';
}

//GUARDAMOS EL NÚMERO DE COLEGIADO.
if(isset($_POST['numero_colegiado'])){
    $_SESSION['valores']['numero_colegiado'] = $_POST['numero_colegiado'];
}else{
    $_SESSION['valores']['numero_colegiado'] = '';
}

//GUARDAMOS LA ESPECIALIDAD.
if(isset($_POST['id_especialidad'])){
    $_SESSION['valores']['id_especialidad'] = $_POST['id_especialidad'];
}else {
    $_SESSION['valores']['id_especialidad'] = '';
}

//SUBIMOS LA IMAGEN VALIDANDO QUE SOLO PUEDA SER JPG O PNG Y TAMBIÉN QUE SOLO PUEDA OCUPAR 2MB COMO MÁXIMO.
$nombreArchivo = "";

if(isset($_FILES["foto"]) && $_FILES["foto"]["error"] == 0){
    $tamano = $_FILES["foto"]["size"];
    $rutaTmp = $_FILES["foto"]["tmp_name"];
    //SE COMPRUEBA QUE LO QUE SE SUBE ES UNA IMAGEN
    $infoImagen = getimagesize($rutaTmp);
    if ($infoImagen === false){
        $errores[] = "El archivo que intentas subir debe ser una imagen válida (.JPG o .PNG).";
    }else {
        //ESTO ES PARA LOS TIPOS DE IMAGEN QUE SE PUEDEN SUBIR, YO SOLO PERMITO FORMATO JPG O PNG.
        $tipo = $infoImagen['mime'];
        if (!in_array($tipo, ['image/jpeg', 'image/png'])){
            $errores[] = "Solo se permiten imágenes en formato .JPG o .PNG";
        }
    }

    //QUE SEA COMO MÁXIMO 2MB.
    if ($tamano > 2 * 1024 * 1024){
        $errores[] = "Tu foto de perfil no puede superar los 2MB.";
    }

    //SI SE CUMPLE CON LO ANTERIOR, SE SUBE A LA CARPETA UPLOADS.
    if (empty($errores)){
        //CON EL UNIQUID LE METEMOS UN ID ALEATORIO DE LETRAS Y NÚMEROS AL NOMBRE DE LA IMÁGEN.
        $nombreArchivo = uniqid() . '-' . $_FILES["foto"]["name"];
        $rutaDestino = '../../uploads/perfiles/' . $nombreArchivo;
        move_uploaded_file($rutaTmp, $rutaDestino);
    }
}else{
    $errores[] = "La foto de perfil es obligatoria para todos los usuarios.";
}

//LANZAMOS ERRORES
if(!empty($errores)){
    $_SESSION['errores'] = $errores;
    header("Location: ../../registro.php");
    exit;
}

//GUARDAMOS LOS DATOS EN LA BASE DE DATOS.
if(registrarUsuario($conexion, $nombre, $apellidos, $correo, $contrasena, $rol, $telefono, $fecha_nacimiento, $direccion, $nss, $numero_colegiado, $id_especialidad, $nombreArchivo)) {
    header("Location: ../../despues-de-registro.php");
    exit();
}
?>