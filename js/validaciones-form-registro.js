//ACCEDEMOS AL BOTÓN Y AL FORMULARIO
let formulario = document.getElementById("form-registro");

//EXPRESIONES REGEXP PARA VALIDAR DESDE EL FRONTEND LOS CAMPOS
const solo_2_palabras_nombre = new RegExp("^[A-Za-zÁÉÍÓÚáéíóúÑñ]{1,20}(\\s[A-Za-zÁÉÍÓÚáéíóúÑñ]{1,20})?$");
const expresion_correo = new RegExp("^[A-Za-z0-9._-]+@[A-Za-z0-9.-]+\\.[A-Za-z]{2,}$");
const expresion_telefono = new RegExp("^[0-9]{9}$");
const expresion_contrasena = new RegExp("^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[._-]).{8,}$");
const expresion_direccion = new RegExp("^[A-Za-z0-9ÁÉÍÓÚáéíóúÑñ\\s]+$");
const expresion_nss = new RegExp("^[0-9]{12}$");
const expresion_colegiado = new RegExp("^[0-9]{9}$");

formulario.addEventListener("submit", function(evento){
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
    let errores = false;

    //PARA EL NOMBRE
    let nombre = document.getElementById("nombre").value.trim();
    
    if(nombre == ""){
        document.getElementById("error-nombre").innerHTML = "El campo del nombre no puede quedar vacío.";
        errores = true;
    }

    if(!solo_2_palabras_nombre.test(nombre)){
        document.getElementById("error-nombre").innerHTML = "El nombre solo puede contener 2 palabras y máximo 20 letras.";
        errores = true;
    }

    //PARA EL APELLIDO
    let apellidos = document.getElementById("apellidos").value.trim();

    if(apellidos == ""){
        document.getElementById("error-apellidos").innerHTML = "El campo de los apellidos no puede quedar vacío.";
        errores = true;
    }

    if(!solo_2_palabras_nombre.test(apellidos)){
        document.getElementById("error-apellidos").innerHTML = "Los apellidos solo pueden contener 2 palabras y máximo 20 letras.";
        errores = true;
    }

    //PARA EL CORREO
    let correo = document.getElementById("correo").value.trim();

    if(correo == ""){
        document.getElementById("error-correo").innerHTML = "El campo del correo no puede quedar vacío.";
        errores = true;
    }

    if(!expresion_correo.test(correo)){
        document.getElementById("error-correo").innerHTML = "El correo debe tener el formato correcto.";
        errores = true;
    }

    //PARA EL TELÉFONO
    let telefono = document.getElementById("telefono").value.trim();

    if(telefono == ""){
        document.getElementById("error-telefono").innerHTML = "El campo del teléfono no puede quedar vacío.";
        errores = true;
    }

    if(!expresion_telefono.test(telefono)){
        document.getElementById("error-telefono").innerHTML = "El número de teléfono debe contener 9 números.";
        errores = true;
    }

    //PARA LA CONTRASEÑA
    let contrasena = document.getElementById("contrasena").value.trim();

    if(contrasena == ""){
        document.getElementById("error-contrasena").innerHTML = "El campo de la constraseña no puede quedar vacío.";
        errores = true;
    }

    if(!expresion_contrasena.test(contrasena)){
        document.getElementById("error-contrasena").innerHTML = "La contraseña debe contener mínimo 8 caracteres. Letras minúsuclas, mayúsculas, números y caracteres especiales.";
        errores = true;
    }

    //VALIDAR QUE EL SEGUNDO CAMPO PARA LA CONTRASEÑA COINCIDA CON EL PRIMERO
    let contrasena2 = document.getElementById("contrasena2").value.trim();

    if(contrasena2 == ""){
        document.getElementById("error-contrasena2").innerHTML = "Debes confirmar tu contraseña este campo.";
        errores = true;
    }

    if(contrasena2 != contrasena){
        document.getElementById("error-contrasena2").innerHTML = "Las contraseñas no coinciden.";
        errores = true;
    }
    
    //PARA QUE SE SELECCIONE UN ROL DE USUARIO
    let rol = document.getElementById("rol").value;

    if(rol == ""){
        document.getElementById("error-rol").innerHTML = "Debes elegir un tipo de usuario.";
        errores = true;
    }

    //PARA LA FOTO
    let foto = document.getElementById("foto_perfil");

    if (!foto.files || foto.files.length === 0) {
        document.getElementById("error-foto").innerHTML = "Debes subir una foto de perfil.";
        errores = true;
    } else {
        const archivo = foto.files[0];
        if (archivo.size > 2 * 1024 * 1024) {
            document.getElementById("error-foto").innerHTML = "La foto no puede superar 2MB.";
            errores = true;
        }
        //PARA VALIDAR QUE EL FORMATO SÓLO SEA .JPG O .PNG.
        const formatos_permitidos = ["image/jpeg", "image/png"];
        if (!formatos_permitidos.includes(archivo.type)) {
            document.getElementById("error-foto").innerHTML = "Solo se permiten imágenes en formato .JPG o .PNG.";
            errores = true;
        }
    }

    //VALIDACIONES PARA  CUANDO CUANDO ERES PACIENTE
    //FECHA
    let fecha = document.getElementById("fecha_nacimiento").value;

    if(rol == "paciente" && fecha == ""){
        document.getElementById("error-fecha").innerHTML = "El campo de la fecha no puede quedar vacío.";
        errores = true;
    }else if (rol == "paciente"){
        const hoy = new Date();
        const fechaNac = new Date(fecha);

        let edad = hoy.getFullYear() - fechaNac.getFullYear();
        const mes = hoy.getMonth() - fechaNac.getMonth();

        //VEMOS SI YA HA CUMPLIDO AÑOS O NO
        if (mes < 0 || (mes === 0 && hoy.getDate() < fechaNac.getDate())) {
            edad--;
        }
        if (edad < 18) {
            document.getElementById("error-fecha").innerHTML = "Debes ser mayor de 18 años.";
            errores = true;
        }
    }
    //DIRECCIÓN
    let direccion = document.getElementById("direccion").value.trim();

    if(rol == "paciente" && direccion == ""){
        document.getElementById("error-direccion").innerHTML = "El campo de la dirección no puede quedar vacío.";
        errores = true;
    }else if(rol == "paciente" && !expresion_direccion.test(direccion)){
        document.getElementById("error-direccion").innerHTML = "La dirección sólo puede contener letras, números y espacios.";
        errores = true;
    }

    //PARA EL NÚMERO DE LA SEGURIDAD SOCIAL
    let nss = document.getElementById("nss").value.trim();

    if(rol == "paciente" && nss == ""){
        document.getElementById("error-nss").innerHTML = "El campo del NSS no puede quedar vacío.";
        errores = true;
    }else if (rol == "paciente" && !expresion_nss.test(nss)) {
        document.getElementById("error-nss").innerHTML = "El NSS debe contener exactamente 12 dígitos sin espacios.";
        errores = true;
    }

    //VALIDACIONES AHORA CUANDO ERES MÉDICO
    //NÚMERO DE COLEGIADO
    let numero_colegiado = document.getElementById("numero_colegiado").value.trim();

    if(rol == "medico" && numero_colegiado == ""){
        document.getElementById("error-colegiado").innerHTML = "El campo del número de colegiado no puede quedar vacío.";
        errores = true;
    }else if(rol == "medico" && !expresion_colegiado.test(numero_colegiado)){
        document.getElementById("error-colegiado").innerHTML = "El número de colegiado debe contener 9 dígitos sin espacios.";
        errores = true;
    }

    //ESPECIALIDAD DEL MÉDICO
    let especialidad = document.getElementById("id_especialidad").value.trim();

    if(rol == "medico" && especialidad == ""){
        document.getElementById("error-especialidad").innerHTML = "Debes seleccionar una especialidad.";
        errores = true;
    }

    //PARA QUE HAYA QUE ACEPTAR LA POLÍTICA DE PRIVACIDAD
    let acepta = document.getElementById("acepta_politica");

    if (!acepta.checked) {
        document.getElementById("error-privacidad").innerHTML = "Debes aceptar la política de privacidad.";
        errores = true;
    }

    if(errores){
        evento.preventDefault();
    }
});