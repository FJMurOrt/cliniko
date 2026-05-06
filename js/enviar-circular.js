function crearObjetoPeticion(){
    var objeto_peticion = false;
    try{
        objeto_peticion = new XMLHttpRequest();
    }catch(error_1){
        try{
            objeto_peticion = new ActiveXObject("Msxml2.XMLHTTP");
        }catch(error_2){
            try{
                objeto_peticion = new ActiveXObject("Microsoft.XMLHTTP");
            }catch(error_3){
                objeto_peticion = false;
            }
        }
    }
    return objeto_peticion;
}

//FUNCIÓN PARA ENVIAR LA CIRCULAR
function enviarCircular(){
    //RECOJO EL ASUNTO Y EL MENSAJE DEL FORMULARIO
    var asunto = document.getElementById("asunto-circular").value.trim();
    var mensaje = document.getElementById("mensaje-del-correo-circular").value.trim();

    if(asunto === ""){
        document.getElementById("mensaje-al-enviar-correo").innerHTML = "<p style='color: red;'>Debes escribir un asunto.</p>";
        return;
    }

    if(mensaje === ""){
        document.getElementById("mensaje-al-enviar-correo").innerHTML = "<p style='color: red;'>Debes escribir un mensaje.</p>";
        return;
    }

    var peticion = crearObjetoPeticion();
    if(!peticion){
       return; 
    }

    peticion.open("POST", "../../controladores/ajax-circular.php", true);

    peticion.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    peticion.onreadystatechange = function(){
        if(peticion.readyState === 4 && peticion.status === 200){
            var respuesta = JSON.parse(peticion.responseText);
            if(respuesta.enviado){
                document.getElementById("mensaje-al-enviar-correo").innerHTML = "<p style='color: green;'>El correo circular fue enviado correctamente a todos los usuarios.</p>";
                document.getElementById("asunto-circular").value = "";
                document.getElementById("mensaje-del-correo-circular").value = "";
                document.getElementById("contador-circular").textContent = "0/1000";
            }else{
                document.getElementById("mensaje-al-enviar-correo").innerHTML = "<p style='color: red;'>"+respuesta.error+"</p>";
            }
        }
    };
    peticion.send("asunto="+encodeURIComponent(asunto)+"&mensaje="+encodeURIComponent(mensaje));
}

document.getElementById("mensaje-del-correo-circular").addEventListener("input", function(){
    document.getElementById("contador-circular").textContent = this.value.length+"/1000";
});