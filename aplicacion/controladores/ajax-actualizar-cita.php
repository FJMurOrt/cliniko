<?php
header("Content-Type: application/json; charset=utf-8");
require_once "../configuracion/config.php";
require_once "../modelos/ajax-actualizar-cita-modelo.php";

session_start();
$id_medico = $_SESSION['id_usuario'];

if(isset($_GET['id_cita']) && isset($_GET['nuevo_estado'])){
    $id_cita = intval($_GET['id_cita']);
    $nuevo_estado = $_GET['nuevo_estado'];

    $actualizada = actualizarEstadoCita($conexion, $id_cita, $id_medico, $nuevo_estado);

    if($actualizada){
        //COJO LOS DATOS DE LA CITA
        $sql_cita = "SELECT id_paciente, fecha_cita FROM citas WHERE id_cita = ?";

        $prep_cita = mysqli_prepare($conexion, $sql_cita);
        mysqli_stmt_bind_param($prep_cita, "i", $id_cita);
        mysqli_stmt_execute($prep_cita);

        $resultado_cita = mysqli_stmt_get_result($prep_cita);
        $cita_datos = mysqli_fetch_assoc($resultado_cita);

        mysqli_stmt_close($prep_cita);

        $fecha_formato = date("d/m/Y", strtotime($cita_datos["fecha_cita"]));
        $hora_formato = date("H:i", strtotime($cita_datos["fecha_cita"]));

        $id_paciente = $cita_datos["id_paciente"];

        //Y DESPUÉS INSERTO LA NOTIFICACIÓN EN LA TABLA DE NOTIFICACIONS
        if($nuevo_estado === "no_atendida"){
            $mensaje = "Tu cita del $fecha_formato a las $hora_formato fue marcada como no atendida";
            $sql_notificacion = "INSERT INTO notificaciones (id_usuario, tipo, mensaje, id_cita) VALUES (?, 'no_atendida', ?, ?)";
            
            $prep_noti = mysqli_prepare($conexion, $sql_notificacion);
            mysqli_stmt_bind_param($prep_noti, "isi", $id_paciente, $mensaje, $id_cita);
            mysqli_stmt_execute($prep_noti);

            mysqli_stmt_close($prep_noti);
        }

        //Y ESTE IF ES PARA QEU CUANDO EL MÉDICO MARQUE UNA CITA COMO REALIZADA, A ÉL MISMO LE LLEGUE UNA NTOFIACIÓN PARA RECORDARLE QUE SUBE UNA RECETA SI LA TIENE
        if($nuevo_estado === "realizada"){
            $mensaje_para_el_medico_de_la_receta = "Recuerda subirle la receta a tu paciente de la cita del $fecha_formato a las $hora_formato que atendiste si fuera necesario darle una.";

            $sql_notificacion_medico = "INSERT INTO notificaciones (id_usuario, tipo, mensaje, id_cita) VALUES (?, 'receta_subida', ?, ?)";
            
            $preparacion_notifiacion_medico = mysqli_prepare($conexion, $sql_notificacion_medico);
            mysqli_stmt_bind_param($preparacion_notifiacion_medico, "isi", $id_medico, $mensaje_para_el_medico_de_la_receta, $id_cita);
            mysqli_stmt_execute($preparacion_notifiacion_medico);

            mysqli_stmt_close($preparacion_notifiacion_medico);
        }

        echo json_encode([
            "la_cita_se_actualizo" => true
        ]);
    }else{
        echo json_encode([
            "la_cita_se_actualizo" => false,
            "error" => "No se pudo actualizar o el estado al que se quiso cambiar no es válido."
        ]);
    }
}else{
    echo json_encode([
        "la_cita_se_actualizo" => false,
        "error" => "Hubo un problema al intentar actualizar la cita."
    ]);
}
?>