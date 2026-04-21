//FUNCIÓN PARA CREAR EL OBJETO DE LA PETICIÓN
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

//FUNCIÓN PARA MOSTRAR LAS NOTIFICACIONES
function mostrarNotificaciones(){
    var peticion = crearObjetoPeticion();

    if(!peticion){
        return;
    }

    peticion.open("GET", "../../controladores/ajax-notificaciones.php", true);

    peticion.onreadystatechange = function(){
        if(peticion.readyState === 4 && peticion.status === 200){
            var respuesta = JSON.parse(peticion.responseText);
            var informacion_de_la_notificacion = "";

            if(respuesta.notificaciones.length === 0){
                informacion_de_la_notificacion = "<div class='col-12 text-center'><p style='color: #064635;'>No tienes notificaciones.</p></div>";
            }else{
                respuesta.notificaciones.forEach(function(notificacion){
                    var partes_fecha = notificacion.fecha.split(" ");
                    var partes = partes_fecha[0].split("-");
                    var fecha = partes[2]+"/"+partes[1]+"/"+partes[0];
                    var hora = partes_fecha[1].substring(0,5);

                    var boton_leida = "<button class='btn boton-leida mt-2' onclick='marcarLeida("+notificacion.id_notificacion+")'>¡Leída!</button>";

                    informacion_de_la_notificacion +=
                        "<div class='col-12 mb-3' id='notificacion"+notificacion.id_notificacion+"'>"+
                            "<div class='card tarjeta-notificaciones'>"+
                                "<div class='card-body'>"+
                                    "<div class='row align-items-center'>"+
                                        "<div class='col-md-2 text-center'>"+
                                            "<i class='fa fa-bell' style='font-size: 40px; color: #D47B5E;'></i>"+
                                        "</div>"+
                                        "<div class='col-md-7'>"+
                                            "<p class='mb-1'>"+notificacion.mensaje+"</p>"+
                                            "<span class='etiqueta-filtro'>"+fecha+" - "+hora+"</span>"+
                                        "</div>"+
                                        "<div class='col-md-3 text-md-end text-center mt-3 mt-md-0'>"+
                                            boton_leida+
                                        "</div>"+
                                    "</div>"+
                                "</div>"+
                            "</div>"+
                        "</div>";
                });
            }
            document.getElementById("contenedor-notificaciones").innerHTML = informacion_de_la_notificacion;
        }
    };
    peticion.send();
}

//PARA QUITAR LAS NOTIFICACIONES AL DARLE AL BOTÓN DE LEÍDA
function marcarLeida(id_notificacion){
    var peticion = crearObjetoPeticion();
    
    if(!peticion){
        return;
    }

    peticion.open("GET", "../../controladores/ajax-marcar-notificacion-leida.php?id_notificacion="+id_notificacion, true);
    peticion.onreadystatechange = function(){
        if(peticion.readyState === 4 && peticion.status === 200){
            var respuesta = JSON.parse(peticion.responseText);
            if(respuesta.leida){
                document.getElementById("notificacion"+id_notificacion).remove();
            }
        }
    };
    peticion.send();
}

//CARGO LAS NOTIFIACIONES AL CARGAR EL DOM
document.addEventListener("DOMContentLoaded", function(){
    mostrarNotificaciones();
});