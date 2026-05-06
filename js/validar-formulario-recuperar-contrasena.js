var formulario_recuperar_contrasenia = document.getElementById("form-recuperar");

//EXPRESION REGEXP CON LAS QUE VAMOS A VALIDAR LOS CAMPOS
var expresion_correo_recuperar = new RegExp("^[A-Za-z0-9._-]+@[A-Za-z0-9.-]+\\.[A-Za-z]{2,}$");

formulario_recuperar_contrasenia.addEventListener("submit", function(evento){
    //CADA VEZ QUE PULSEMOS, LIMPIAMOS LOS CAMPOS DE LOS ERRORES
    document.getElementById("error-correo").innerHTML = "";

    //PARA SABER SI TENEMOS ERRORES O NO CUANDO PULSEMOS EL BOTÓN DE REGITRARSE, Y SI LOS HAY, NO SE HACE EL SUBMIT
    var errores = false;

    //PARA EL CORREO
    var correo = document.getElementById("correo").value.trim();

    if(correo == ""){
        document.getElementById("error-correo").innerHTML = "Debes introducir tu correo.";
        errores = true;
    }

    if(!expresion_correo_recuperar.test(correo)){
        document.getElementById("error-correo").innerHTML = "El correo debe tener el formato correcto.";
        errores = true;
    }
    
    if(errores){
        evento.preventDefault();
    }
});