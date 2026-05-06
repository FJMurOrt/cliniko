//ACCEDEMOS AL BOTÓN Y AL FORMULARIO
var formulario_cambiar_contrasenia = document.getElementById("form-nueva-contrasena");

//EXPRESION PARA VALIDAR EL FORMATO DE LA CONTRASEÑA
var expresion_contrasena_cambiar = new RegExp("^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[._-]).{8,}$");

formulario_cambiar_contrasenia.addEventListener("submit", function(evento){
    document.getElementById("error-contrasena1").innerHTML = "";
    document.getElementById("error-contrasena2").innerHTML = "";

    var errores = false;

    var contrasena = document.getElementById("contra1").value.trim();

    if(contrasena == ""){
        document.getElementById("error-contrasena1").innerHTML = "El campo de la constraseña no puede quedar vacío.";
        errores = true;
    }

    if(!expresion_contrasena_cambiar.test(contrasena)){
        document.getElementById("error-contrasena1").innerHTML = "La contraseña debe contener mínimo 8 caracteres. Letras minúsuclas, mayúsculas, números y caracteres especiales.";
        errores = true;
    }

    var contrasena2 = document.getElementById("contra2").value.trim();

    if(contrasena2 == ""){
        document.getElementById("error-contrasena2").innerHTML = "Debes confirmar tu contraseña este campo.";
        errores = true;
    }

    if(contrasena2 != contrasena){
        document.getElementById("error-contrasena2").innerHTML = "Las contraseñas no coinciden.";
        errores = true;
    }

    if(errores){
        evento.preventDefault();
    }
});