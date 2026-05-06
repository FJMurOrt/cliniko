var formulario_inicio_de_sesion = document.getElementById("form-login");

//EXPRESION REGEXP CON LAS QUE VAMOS A VALIDAR LOS CAMPOS
var expresion_correo_login = new RegExp("^[A-Za-z0-9._-]+@[A-Za-z0-9.-]+\\.[A-Za-z]{2,}$");

formulario_inicio_de_sesion.addEventListener("submit", function(evento){
    //CADA VEZ QUE PULSEMOS, LIMPIAMOS LOS CAMPOS DE LOS ERRORES
    document.getElementById("error-correo").innerHTML = "";
    document.getElementById("error-contrasena").innerHTML = "";

    //PARA SABER SI TENEMOS ERRORES O NO CUANDO PULSEMOS EL BOTÓN DE REGITRARSE, Y SI LOS HAY, NO SE HACE EL SUBMIT
    var errores = false;

    //PARA EL CORREO
    var correo = document.getElementById("correo").value.trim();

    if(correo == ""){
        document.getElementById("error-correo").innerHTML = "Debes introducir tu correo.";
        errores = true;
    }else if(!expresion_correo_login.test(correo)){
        document.getElementById("error-correo").innerHTML = "El correo debe tener el formato correcto.";
        errores = true;
    }

    //PARA LA CONTRASEÑA
    var contrasena = document.getElementById("contrasena").value.trim();

    if(contrasena == ""){
        document.getElementById("error-contrasena").innerHTML = "Debes introducir tu contraseña.";
        errores = true;
    }

    if(errores){
        evento.preventDefault();
    }
});