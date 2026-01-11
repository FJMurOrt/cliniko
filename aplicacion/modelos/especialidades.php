<?php
require_once "aplicacion/configuracion/config.php";

function buscar_especialidades($conexion) {
    $sql = "SELECT id_especialidad, nombre FROM especialidades ORDER BY nombre ASC";
    $resultado = mysqli_query($conexion, $sql);
    return $resultado;
}
?>