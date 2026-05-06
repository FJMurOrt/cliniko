<?php
header("Content-Type: application/json; charset=utf-8");
require_once "../configuracion/config.php";
require_once "../modelos/ajax-valoraciones-admin-modelo.php";
session_start();

if(!isset($_SESSION["id_usuario"])){
    exit;
}

$loquesevaahacer = isset($_GET["loquesevaahacer"]) ? $_GET["loquesevaahacer"] : "";

if($loquesevaahacer === "editar"){
    $id_valoracion = intval($_POST["id_valoracion"]);
    $comentario = trim($_POST["comentario"]);
    if($comentario === ""){
        echo json_encode([
            "editada" => false, 
            "error" => "El comentario no puede estar vacío."
            ]);
        exit;
    }
    $resultado = editarValoracionAdmin($conexion, $id_valoracion, $comentario);
    echo json_encode([
        "editada" => $resultado
        ]);

}else if($loquesevaahacer === "eliminar"){
    $id_valoracion = intval($_GET["id_valoracion"]);
    
    $datos = obtenerDatosValoracionParaEliminar($conexion, $id_valoracion);
    
    $mensaje_noti = "Tu valoración acerca del médico ".$datos["nombre"]." ".$datos["apellidos"]." fue eliminada por no cumplir con el lenguaje esperado.";

    $sql_noti = "INSERT INTO notificaciones (id_usuario, tipo, mensaje) VALUES (?, 'valoracion_eliminada', ?)";

    $prep_noti = mysqli_prepare($conexion, $sql_noti);
    mysqli_stmt_bind_param($prep_noti, "is", $datos["id_paciente"], $mensaje_noti);
    mysqli_stmt_execute($prep_noti);

    mysqli_stmt_close($prep_noti);
    
    $resultado = eliminarValoracionAdmin($conexion, $id_valoracion);

    echo json_encode([
        "eliminada" => $resultado
        ]);
}else{
    //SI NO PULSAMMOS NINGÚN BOTÓN PUES CARGAMOS LA LISTA CON LOS FILTROS QUE SEAN, ES DECIR, QUE SE VA CARGAR POR DEFECTO SÍ O SÍ.
    $pagina = 1;
    if(isset($_GET["pagina"])){
        $pagina = intval($_GET["pagina"]); 
    }

    $registros = 4;
    $inicio = ($pagina - 1) * $registros;

    $fecha = "";
    if(isset($_GET["fecha"]) && $_GET["fecha"] !== ""){
        $fecha = $_GET["fecha"];
    }

    $puntuacion = "";
    if(isset($_GET["puntuacion"]) && $_GET["puntuacion"] !== ""){
        $puntuacion = $_GET["puntuacion"];
    }

    $orden = "";
    if(isset($_GET["orden"]) && $_GET["orden"] !== ""){
        $orden = $_GET["orden"];
    }

    $estado = "";
    if(isset($_GET["estado"]) && $_GET["estado"] !== ""){
        $estado = $_GET["estado"];
    }

    $total = contarValoracionesAdmin($conexion, $fecha, $puntuacion, $orden, $estado);
    $total_paginas = ceil($total / $registros);
    $valoraciones = obtenerValoracionesAdmin($conexion, $inicio, $registros, $fecha, $puntuacion, $orden, $estado);

    echo json_encode([
        "valoraciones" => $valoraciones,
        "total_paginas" => $total_paginas
    ]);
}
?>