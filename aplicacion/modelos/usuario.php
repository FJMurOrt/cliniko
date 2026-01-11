<?php
require_once '../configuracion/config.php';

function registrarUsuario($conexion, $nombre, $apellidos, $correo, $contrasena, $rol, $telefono, $fecha_nacimiento, $direccion, $nss, $numero_colegiado, $id_especialidad, $foto) {
    //GUARDAMOS LA INFROMACIÓN EN LA TABLA USUARIOS.
    $sql = "INSERT INTO usuarios (nombre, apellidos, correo, contrasena, telefono, rol, foto_perfil) 
            VALUES ('$nombre', '$apellidos', '$correo', '$contrasena', '$telefono', '$rol', '$foto')";

    $resultado = mysqli_query($conexion, $sql);

    if($resultado) {
        //COGEMOS EL ID QUE SE HA GENERADO EN LA TABLA USUARIOS Y LO USAMOS COMO ID DE PACIENTE O MEDICO, DEPENDE DE QUE SEA PARA QUE TENGA EL MISMO ID.
        $id_usuario = mysqli_insert_id($conexion);

        //SI EL ROL SELECCIONA ES PACIENTE, LA INFORMACIÓN SE GUARDA EN LA TABLA PACIENTES.
        if($rol == "paciente") {
            $sqlPaciente = "INSERT INTO pacientes (id_paciente, fecha_nacimiento, direccion, nss, telefono_contacto) 
                            VALUES ($id_usuario, '$fecha_nacimiento', '$direccion', '$nss', '$telefono')";
            mysqli_query($conexion, $sqlPaciente);
        }

        //SI ES MÉDICO, EN LA TABLA DE MÉDICOS.
        if($rol == "medico") {
            $sqlMedico = "INSERT INTO medicos (id_medico, id_especialidad, numero_colegiado) 
                          VALUES ($id_usuario, '$id_especialidad', '$numero_colegiado')";
            mysqli_query($conexion, $sqlMedico);
        }
    }
    return $resultado;
}
?>