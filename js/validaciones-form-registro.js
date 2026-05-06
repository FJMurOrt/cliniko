//ACCEDEMOS AL BOTÓN Y AL FORMULARIO
var form_registro = document.getElementById("form-registro");

//EXPRESIONES REGEXP PARA VALIDAR DESDE EL FRONTEND LOS CAMPOS
var solo_2_palabras_nombre_registro = new RegExp("^[A-ZÑa-zñÁÉÍÓÚáéíóúÑñ]{1,20}(\\s[A-ZÑa-zñÁÉÍÓÚáéíóúÑñ]{1,20})?$");
var expresion_correo_registro = new RegExp("^[A-Za-z0-9._-]+@[A-Za-z0-9.-]+\\.[A-Za-z]{2,}$");
var expresion_telefono_registro = new RegExp("^[0-9]{9}$");
var expresion_contrasena_registro = new RegExp("^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[._-]).{8,}$");
var expresion_direccion_registro = new RegExp("^[A-Za-z0-9ÁÉÍÓÚáéíóúÑñ\\s]+$");
var expresion_nss_registro = new RegExp("^[0-9]{12}$");
var expresion_colegiado_registro = new RegExp("^[0-9]{9}$");

form_registro.addEventListener("submit", function(evento){
    //CADA VEZ QUE PULSEMOS, LIMPIAMOS LOS CAMPOS DE LOS ERRORES
    document.getElementById("error-nombre").innerHTML = "";
    document.getElementById("error-apellidos").innerHTML = "";
    document.getElementById("error-correo").innerHTML = "";
    document.getElementById("error-telefono").innerHTML = "";
    document.getElementById("error-contrasena").innerHTML = "";
    document.getElementById("error-contrasena2").innerHTML = "";
    document.getElementById("error-rol").innerHTML = "";
    document.getElementById("error-foto").innerHTML = "";
    document.getElementById("error-fecha").innerHTML = "";
    document.getElementById("error-direccion").innerHTML = "";
    document.getElementById("error-nss").innerHTML = "";
    document.getElementById("error-colegiado").innerHTML = "";
    document.getElementById("error-especialidad").innerHTML = "";
    document.getElementById("error-privacidad").innerHTML = "";

    //PARA SABER SI TENEMOS ERRORES O NO CUANDO PULSEMOS EL BOTÓN DE REGITRARSE, Y SI LOS HAY, NO SE HACE EL SUBMIT
    var errores = false;

    //PARA EL NOMBRE
    var nombre = document.getElementById("nombre").value.trim();
    
    if(nombre == ""){
        document.getElementById("error-nombre").innerHTML = "Debes introducir tu nombre.";
        errores = true;
    }else if(!solo_2_palabras_nombre_registro.test(nombre)){
        document.getElementById("error-nombre").innerHTML = "El nombre solo puede contener 2 palabras y máximo 20 letras.";
        errores = true;
    }

    //PARA EL APELLIDO
    var apellidos = document.getElementById("apellidos").value.trim();

    if(apellidos == ""){
        document.getElementById("error-apellidos").innerHTML = "Debes introducir tus apellidos.";
        errores = true;
    }else if(!solo_2_palabras_nombre_registro.test(apellidos)){
        document.getElementById("error-apellidos").innerHTML = "Los apellidos solo pueden contener 2 palabras y máximo 20 letras.";
        errores = true;
    }

    //PARA EL CORREO
    var correo = document.getElementById("correo").value.trim();

    if(correo == ""){
        document.getElementById("error-correo").innerHTML = "Debes introducir un correo electrónico.";
        errores = true;
    }else if(!expresion_correo_registro.test(correo)){
        document.getElementById("error-correo").innerHTML = "El correo debe tener el formato correcto.";
        errores = true;
    }

    //PARA EL TELÉFONO
    var telefono = document.getElementById("telefono").value.trim();

    if(telefono == ""){
        document.getElementById("error-telefono").innerHTML = "Debes introducir un número de teléfono.";
        errores = true;
    }else if(!expresion_telefono_registro.test(telefono)){
        document.getElementById("error-telefono").innerHTML = "El número de teléfono debe contener 9 números.";
        errores = true;
    }

    //PARA LA CONTRASEÑA
    var contrasena = document.getElementById("contrasena").value.trim();

    if(contrasena == ""){
        document.getElementById("error-contrasena").innerHTML = "Debes introducir una contraseña.";
        errores = true;
    }else if(!expresion_contrasena_registro.test(contrasena)){
        document.getElementById("error-contrasena").innerHTML = "La contraseña debe contener mínimo 8 caracteres. Letras minúsuclas, mayúsculas, números y caracteres especiales.";
        errores = true;
    }

    //VALIDAR QUE EL SEGUNDO CAMPO PARA LA CONTRASEÑA COINCIDA CON EL PRIMERO
    var contrasena2 = document.getElementById("contrasena2").value.trim();

    if(contrasena2 == ""){
        document.getElementById("error-contrasena2").innerHTML = "Debes confirmar tu contraseña introducida.";
        errores = true;
    }else if(contrasena2 != contrasena){
        document.getElementById("error-contrasena2").innerHTML = "Las contraseñas no coinciden.";
        errores = true;
    }
    
    //PARA QUE SE SELECCIONE UN ROL DE USUARIO
    var rol = document.getElementById("rol").value;

    if(rol == ""){
        document.getElementById("error-rol").innerHTML = "Debes elegir un tipo de usuario.";
        errores = true;
    }

    //PARA LA FOTO
    var foto = document.getElementById("foto_perfil");

    if (!foto.files || foto.files.length === 0) {
        document.getElementById("error-foto").innerHTML = "Debes subir una foto de perfil.";
        errores = true;
    } else {
        var archivo = foto.files[0];
        if (archivo.size > 2 * 1024 * 1024) {
            document.getElementById("error-foto").innerHTML = "La foto no puede superar 2MB.";
            errores = true;
        }
        //PARA VALIDAR QUE EL FORMATO SÓLO SEA .JPG O .PNG.
        var formatos_permitidos_registro = ["image/jpeg", "image/png"];
        if (!formatos_permitidos_registro.includes(archivo.type)) {
            document.getElementById("error-foto").innerHTML = "Solo se permiten imágenes en formato .JPG o .PNG.";
            errores = true;
        }
    }

    //VALIDACIONES PARA CUANDO ERES PACIENTE
    //FECHA
    var fecha = document.getElementById("fecha_nacimiento").value;

    if(rol == "paciente" && fecha == ""){
        document.getElementById("error-fecha").innerHTML = "Debes introducir tu fecha de nacimiento.";
        errores = true;
    }else if (rol == "paciente"){
        var hoy = new Date();
        var fechaNac = new Date(fecha);

        var edad = hoy.getFullYear() - fechaNac.getFullYear();
        var mes = hoy.getMonth() - fechaNac.getMonth();

        //VEMOS SI YA HA CUMPLIDO AÑOS O NO
        if(mes < 0 || (mes === 0 && hoy.getDate() < fechaNac.getDate())){
            edad--;
        }
        if(edad < 18){
            document.getElementById("error-fecha").innerHTML = "Debes ser mayor de 18 años.";
            errores = true;
        }
    }
    //DIRECCIÓN
    var direccion = document.getElementById("direccion").value.trim();

    if(rol == "paciente" && direccion == ""){
        document.getElementById("error-direccion").innerHTML = "Debes introducir tu dirección.";
        errores = true;
    }else if(rol == "paciente" && !expresion_direccion_registro.test(direccion)){
        document.getElementById("error-direccion").innerHTML = "La dirección sólo puede contener letras, números y espacios.";
        errores = true;
    }

    //PARA EL NÚMERO DE LA SEGURIDAD SOCIAL QUE SERÍA UN CAMPO OPCIONAL
    var nss = document.getElementById("nss").value.trim();

    if(nss !== "" && !expresion_nss_registro.test(nss)){
        document.getElementById("error-nss").innerHTML = "El NSS debe contener exactamente 12 dígitos sin espacios.";
        errores = true;
    }

    //VALIDACIONES AHORA CUANDO ERES MÉDICO
    //NÚMERO DE COLEGIADO
    var numero_colegiado = document.getElementById("numero_colegiado").value.trim();

    if(rol == "medico" && numero_colegiado == ""){
        document.getElementById("error-colegiado").innerHTML = "Debes introducir tu número de colegiado.";
        errores = true;
    }else if(rol == "medico" && !expresion_colegiado_registro.test(numero_colegiado)){
        document.getElementById("error-colegiado").innerHTML = "El número de colegiado debe contener 9 dígitos sin espacios.";
        errores = true;
    }

    //ESPECIALIDAD DEL MÉDICO
    var especialidad = document.getElementById("id_especialidad").value.trim();

    if(rol == "medico" && especialidad == ""){
        document.getElementById("error-especialidad").innerHTML = "Debes seleccionar una especialidad.";
        errores = true;
    }

    //PARA QUE HAYA QUE ACEPTAR LA POLÍTICA DE PRIVACIDAD
    var acepta = document.getElementById("acepta_politica");

    if(!acepta.checked){
        document.getElementById("error-privacidad").innerHTML = "Debes aceptar la política de privacidad.";
        errores = true;
    }

    if(errores){
        evento.preventDefault();
    }
});