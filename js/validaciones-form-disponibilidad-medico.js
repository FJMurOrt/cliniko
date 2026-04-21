//ACCEDEMOS AL BOTÓN Y AL FORMULARIO
let formulario = document.getElementById("form-disponibilidad");

formulario.addEventListener("submit", function(evento){
    //CADA VEZ QUE PULSEMOS, LIMPIAMOS LOS CAMPOS DE LOS ERRORES
    document.getElementById("error-turno").innerHTML = "";
    document.getElementById("error-inicio").innerHTML = "";
    document.getElementById("error-fin").innerHTML = "";
    document.getElementById("error-fecha").innerHTML = "";

    //PARA SABER SI TENEMOS ERRORES O NO CUANDO PULSEMOS EL BOTÓN DE REGITRARSE, Y SI LOS HAY, NO SE HACE EL SUBMIT
    let errores = false;

    //QUE EL SELECT DE LA HORA DE INICIO NO SE QUEDE VACÍO
    let hora_inicio = document.getElementById("hora_inicio").value;

    if(hora_inicio == ""){
        document.getElementById("error-inicio").innerHTML = "Debes seleccionar una hora de inicio.";
        errores = true;
    }

    //QUE EL SELECT DE LA HORA DE FIN NO SE QUEDE VACÍO
    let hora_fin = document.getElementById("hora_fin").value;

    if(hora_fin == ""){
        document.getElementById("error-fin").innerHTML = "Debes seleccionar una hora de fin.";
        errores = true;
    }

    //QUE EL SELECT DE LA HORA DE FIN NO SE QUEDE VACÍO
    let turno = document.getElementById("turno").value;

    if(turno == ""){
        document.getElementById("error-turno").innerHTML = "Debes seleccionar una hora de fin.";
        errores = true;
    }

    //QUE EL SELECT DE LA HORA DE FIN NO SE QUEDE VACÍO
    let fecha = document.getElementById("fecha").value;

    if(fecha == ""){
        document.getElementById("error-fecha").innerHTML = "Debes introducir una fecha.";
        errores = true;
    }

    if(errores){
        evento.preventDefault();
    }
});