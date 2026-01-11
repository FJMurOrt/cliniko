<?php
//CONEXIÓN A LA BASE DE DATOS.
$host = "localhost";
$usuario = "root";
$contrasena = "";
$base_datos = "cliniko";

//GUARDAMOS EN ESTA VARIABLE LA PROPIA CONEXIÓN CON LOS DATOS DE ARRIBA.
$conexion = mysqli_connect($host, $usuario, $contrasena, $base_datos);

//VERIFICAMOS LA CONEXIÓN Y EN CASO DE QUE HAYA UN ERROR, LO MOSTRAMOS.
if (!$conexion) {
    die("Hubo un error al intentar conectar con la base de datos: " . mysqli_connect_error());
}
?>