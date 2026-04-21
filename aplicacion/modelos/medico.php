<?php
require_once "../../configuracion/config.php";

//FUNCIÓN PARA OBTENER EL MÉDICO CON EL 
function obtenerMedicoPorID($conexion, $id_medico){
    $sql = "SELECT u.nombre, u.apellidos, u.foto_perfil, e.nombre AS especialidad FROM usuarios u
            INNER JOIN medicos m ON u.id_usuario = m.id_medico
            LEFT JOIN especialidades e ON m.id_especialidad = e.id_especialidad
            WHERE u.id_usuario = $id_medico";

    $resultado = mysqli_query($conexion, $sql);
    return mysqli_fetch_assoc($resultado);
}

//FUNCIÓN APRA OBTENER LA DISPONIBILIDAD DEL MÉDICO
function obtener_disponibilidad_medico($conexion, $id_medico){
    $sql = "SELECT fecha, turno, hora_inicio, hora_fin FROM disponibilidad_medicos 
    WHERE id_medico = $id_medico ORDER BY fecha ASC";

    return mysqli_query($conexion, $sql);
}

//FUNCIÓN APRA OBTENER LA MEDIA DE PUNTUACIÓN QUE TENGA EL MEDICO DE LAS VALORACIONES
function obtenerMediaValoracion($conexion, $id_medico){
    $sql = "SELECT AVG(puntuacion) AS media, COUNT(*) AS total FROM valoraciones 
            WHERE id_medico = $id_medico";

    $resultado = mysqli_query($conexion, $sql);
    return mysqli_fetch_assoc($resultado);
}
?>