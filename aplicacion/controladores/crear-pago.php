<?php
require_once "../configuracion/config.php";
require_once "../../vendor/autoload.php"; //ESTO ES EL ARCHIVO QUE NECESITO CARGAR LAS LIBRERIAS DE STRIPE QUE LO HACE CON AUTOLOAD.

//ESTA ES MI CLAVE SECRETA DE LA API DE STRIPE
\Stripe\Stripe::setApiKey("sk_test_51T7RuPLxdshS43I6AazXEv9HuVe9Va1jRyrY9pKgVcZ0EFPyNEvRtqE2zZeDZZbA8oVKJcEooWERrgD78JZcwZjG009EVPJrog");

//RECOGEMOS LOS DATOS DEL FORMULARIO DE LA SOLICITUD DE LA CITA
session_start();
$id_medico = intval($_POST["id_medico"]);
$id_paciente = intval($_POST["id_paciente"]);
$motivo = $_POST["motivo"];
$fecha = $_POST["fecha"];
$turno = $_POST["turno"];
$hora = $_POST["hora"];

if(empty($motivo)){
    $motivo = "No se especifica el motivo.";
}

//LO GUARDAMOS EN EL SESION MIENTRAS PAGAMOS Y SI PAGAMOS, YA LUEGO HACEMOS EL INSERT ACACCIDIENDO A LOS DATOS DE NUEVO CON SESSION
$_SESSION["cita_solicitada"] = [
    "id_medico" => $id_medico,
    "id_paciente" => $id_paciente,
    "motivo" => $motivo,
    "fecha" => $fecha,
    "turno" => $turno,
    "hora" => $hora
];

//ESTA ESTRUCTURA ES PREDEFINIDA POR STRIPE PARA PASAR A LA PASARELA
$sesion_stripe_pasarela = \Stripe\Checkout\Session::create([
    "payment_method_types" => ["card"],
    "line_items" => [[
        "price_data" => [
            "currency" => "eur",
            "product_data" => [
                "name" => "Reserva de cita médica",
            ],
            "unit_amount" => 5000,
        ],
        "quantity" => 1,
    ]],
    "mode" => "payment",
    "success_url" => "http://localhost/cliniko_copia_con_datos_para_local-copia/aplicacion/vistas/paciente/pago-exitoso.php",
    "cancel_url" => "http://localhost/cliniko_copia_con_datos_para_local-copia/aplicacion/vistas/paciente/solicitar-cita-lista.php",
]);

//DEVOLVEMOS EL ID DE LA SESIÓN DE LA PASARELA DE PAGO
echo json_encode(["id" => $sesion_stripe_pasarela->id]);
?>