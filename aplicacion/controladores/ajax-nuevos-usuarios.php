<?php
header("Content-Type: application/json; charset=utf-8");
require_once "../configuracion/config.php";
require_once "../modelos/ajax-nuevos-usuarios-modelo.php";
session_start();

//VERIFICO EL ID DEL USUARIO Y SI HAY ALGÚN PROBLEMA PUES NO DEVUELVO NADA
if(!isset($_SESSION["id_usuario"])){
    exit;
}

//GUARDO EL ID DEL ADMIN PARA LEUGO USARLO EN LA FUNCIÓN PORQUE EVITARÉ QUE MUESTRE AL USUARIO QUE ESTA EN EL PANEL EN LA LISTA
$id_admin = $_SESSION["id_usuario"];

$pagina = 1;
if(isset($_GET["pagina"])){
    $pagina = intval($_GET["pagina"]);
}

$registros = 4;
$inicio = ($pagina - 1) * $registros;

//FILTROS
$busqueda = "";
if(isset($_GET["busqueda"]) && $_GET["busqueda"] !== ""){
    $busqueda = trim($_GET["busqueda"]);
}

$tipo_usuario = "";
if(isset($_GET["tipo_de_usuario"]) && $_GET["tipo_de_usuario"] !== ""){
    $tipo_usuario = $_GET["tipo_de_usuario"];
}

$fecha = "";
if(isset($_GET["fecha"]) && $_GET["fecha"] !== ""){
    $fecha = $_GET["fecha"];
}

$estado = "";
if(isset($_GET["estado"]) && $_GET["estado"] !== ""){
    $estado = $_GET["estado"];
}

//LLAMO A LAS FUNCIONES Y GUARDO LOS RESULTADOS DE LOS RETURN DE CADA UNA EN UNA VARIBALE PARA LUEGO DEVOLVERLO EN EL JSON
$total = contarNuevosUsuarios($conexion, $busqueda, $tipo_usuario, $fecha, $id_admin, $estado);
$total_paginas = ceil($total / $registros);
$usuarios = obtenerNuevosUsuarios($conexion, $inicio, $registros, $busqueda, $tipo_usuario, $fecha, $estado, $id_admin);

echo json_encode([
    "usuarios" => $usuarios,
    "total_paginas" => $total_paginas
]);
?>