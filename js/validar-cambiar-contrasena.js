//ACCEDEMOS AL BOTÓN Y AL FORMULARIO
let formulario = document.getElementById("form-nueva-contrasena");

//EXPRESION PARA VALIDAR EL FORMATO DE LA CONTRASEÑA
const expresion_contrasena = new RegExp("^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[._-]).{8,}$");

formulario.addEventListener("submit", function(evento){
    //CADA VEZ QUE PULSEMOS, LIMPIAMOS LOS CAMPOS DE LOS ERRORES
    document.getElementById("error-contrasena1").innerHTML = "";
    document.getElementById("error-contrasena2").innerHTML = "";

    //PARA SABER SI TENEMOS ERRORES O NO CUANDO PULSEMOS EL BOTÓN DE REGITRARSE, Y SI LOS HAY, NO SE HACE EL SUBMIT
    let errores = false;

    //PARA LA CONTRASEÑA
    let contrasena = document.getElementById("contra1").value.trim();

    if(contrasena == ""){
        document.getElementById("error-contrasena1").innerHTML = "El campo de la constraseña no puede quedar vacío.";
        errores = true;
    }

    if(!expresion_contrasena.test(contrasena)){
        document.getElementById("error-contrasena1").innerHTML = "La contraseña debe contener mínimo 8 caracteres. Letras minúsuclas, mayúsculas, números y caracteres especiales.";
        errores = true;
    }

    //VALIDAR QUE EL SEGUNDO CAMPO PARA LA CONTRASEÑA COINCIDA CON EL PRIMERO
    let contrasena2 = document.getElementById("contra2").value.trim();

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