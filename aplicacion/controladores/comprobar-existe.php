<?php
require_once '../configuracion/config.php';

//OBTENEMOS LOS VALORES DEL JS.
if (isset($_GET["tipo"])) {
    $tipo = $_GET["tipo"];
} else {
    $tipo = "";
}

if (isset($_GET["valor"])) {
    $valor = $_GET["valor"];
} else {
    $valor = "";
}

$sql = "";

//CONSULTAMOS LOS VALORES.
if ($tipo == "correo") {
    $sql = "SELECT correo FROM usuarios WHERE correo='$valor'";
} elseif ($tipo == "nss") {
    $sql = "SELECT nss FROM pacientes WHERE nss='$valor'";
} elseif ($tipo == "colegiado") {
    $sql = "SELECT numero_colegiado FROM medicos WHERE numero_colegiado='$valor'";
}

//SI NO TENEMOS EL TIPO DE DATOS QUE VAMOS A CONSULTAR.
if ($sql == "") {
    echo "ok";
    exit;
}

//CUANDO YA CONSTRUIMOS LA CONSULTA, PUES LA EJECUTAMOS.
$resultado = mysqli_query($conexion, $sql);

if (mysqli_num_rows($resultado) > 0) {
    echo "existe";
} else {
    echo "ok";
}