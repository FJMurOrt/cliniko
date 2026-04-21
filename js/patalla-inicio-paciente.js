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

//FUNCIÓN MOSTRAR LAS TARJETAS CON SU CONTENIDO
function cargarTarjetasInicioPagina(){
    var peticion = crearObjetoPeticion();

    if(!peticion){
        return;
    }

    peticion.open("GET", "../../controladores/ajax-pantalla-inicio-paciente.php", true);

    peticion.onreadystatechange = function(){
        if(peticion.readyState === 4 && peticion.status === 200){
            var respuesta = JSON.parse(peticion.responseText);

            //PARA MOSTRAR LA PRÓXIMA CITA DEL PACIENTE
            if(respuesta.proxima_cita){
                var cita = respuesta.proxima_cita;

                var foto_cita = "../../../uploads/perfiles/por_defecto.png";
                if(cita.foto_perfil){
                    foto_cita = "../../../uploads/perfiles/"+cita.foto_perfil;
                }

                var partes = cita.fecha_cita.split(" ");
                var fecha_partes = partes[0].split("-");
                var fecha = fecha_partes[2]+"/"+fecha_partes[1]+"/"+fecha_partes[0];
                var hora = partes[1].substring(0,5);
                
                document.getElementById("proxima-cita").innerHTML =
                    "<img src='"+foto_cita+"' class='img-fluid rounded-circle imagen-perfil-info mb-2'>"+
                    "<p class='nombre-medico-tarjeta-inicio-proxima-cita ml-2'>"+cita.nombre+" "+cita.apellidos+"</p>"+
                    "<p class='fecha-cita-receta'>Tu próxíma cita la tienes el "+fecha+" a las "+hora+". ¡Que no se te olvide!</p>";
            }else{
                document.getElementById("proxima-cita").innerHTML = "<p>No tienes ningúna cita próxima por ahora.</p>";
            }

            //ÚLTIMAS NOTIFICACIONES
            if(respuesta.notificaciones.length > 0){
                var notificacion = "";
                respuesta.notificaciones.forEach(function(noti){
                    notificacion += "<p>"+noti.mensaje+"</p><hr>";
                });
                document.getElementById("notificaciones-inicio").innerHTML = notificacion;
            }else{
                document.getElementById("notificaciones-inicio").innerHTML = "<p>No tienes ninguna notifiación pendiente por leer.</p>";
            }

            //ÚLTIMO MÉDICO CON EL QUE SE TUVO UNA CITA
            if(respuesta.ultimo_medico){
                var medico = respuesta.ultimo_medico;

                var foto = "../../../uploads/perfiles/por_defecto.png";
                if(medico.foto_perfil){
                    foto = "../../../uploads/perfiles/"+medico.foto_perfil;
                }

                document.getElementById("ultimo-medico").innerHTML =
                    "<img src='"+foto+"' class='img-fluid rounded-circle imagen-perfil-info mb-2' style='width:80px;height:80px;object-fit:cover;'>"+
                    "<p class='nombre-medico-tarjeta-inicio-proxima-cita ml-2'>"+medico.nombre+" "+medico.apellidos+"</p>"+
                    "<p class='espe-tabla' style='max-width: 100%;'>"+medico.especialidad+"</p>";
            }else{
                document.getElementById("ultimo-medico").innerHTML = "<p>No se encontraron citas realizadas.</p>";
            }

            //PARA EL MÉDICO FAVORITO
            if(respuesta.medico_favorito){
                var medico_favorito = respuesta.medico_favorito;

                var foto_medico = "../../../uploads/perfiles/por_defecto.png";
                if(medico_favorito.foto_perfil){
                    foto_medico = "../../../uploads/perfiles/"+medico_favorito.foto_perfil;
                }

                document.getElementById("medico-favorito").innerHTML =
                    "<img src='"+foto_medico+"' class='img-fluid rounded-circle imagen-perfil-info mb-2' style='width:80px;height:80px;object-fit:cover;'>"+
                    "<p class='fecha-cita-receta nombre-medico-tarjeta-inicio-proxima-cita ml-2'>"+medico_favorito.nombre+" "+medico_favorito.apellidos+"</p>"+
                    "<p class='espe-tabla' style='max-width: 100%;'>"+medico_favorito.especialidad+"</p>"+
                    "<p class='fecha-cita-receta'>¡Has tenido un total de "+medico_favorito.total+" citas con este médico!</p>";
            }else{
                document.getElementById("medico-favorito").innerHTML = "<p>Sin datos aún.</p>";
            }

            //ÚLTIMA RECETA QUE LE HAYAN SUBIDO AL PACIENTE
            if(respuesta.ultima_receta){
                var receta = respuesta.ultima_receta;

                var fecha_receta_sin_formato = receta.fecha_creacion.split(" ")[0].split("-");
                var fecha_receta = fecha_receta_sin_formato[2]+"/"+fecha_receta_sin_formato[1]+"/"+fecha_receta_sin_formato[0];

                document.getElementById("ultima-receta").innerHTML =
                    "<p class='nombre-medico-tarjeta-inicio-proxima-cita'>"+receta.nombre+" "+receta.apellidos+"</p>"+
                    "<p class='fecha-cita-receta'>"+fecha_receta+"</p>"+
                    "<button class='btn boton-cuadrado btn-form' onclick='verReceta("+'"'+receta.archivo_pdf+'"'+")'>Ver receta</button>";
            }else{
                document.getElementById("ultima-receta").innerHTML = "<p>No tienes recetas subidas.</p>";
            }

            //ÚLTIMO HISTORIAL SUBIDO
            if(respuesta.ultimo_historial){
                var historial = respuesta.ultimo_historial;

                var fecha_historial_sin_formato = historial.fecha_registro.split(" ")[0].split("-");
                var fecha_historial = fecha_historial_sin_formato[2]+"/"+fecha_historial_sin_formato[1]+"/"+fecha_historial_sin_formato[0];

                document.getElementById("ultimo-historial").innerHTML =
                    "<p class='nombre-medico-tarjeta-inicio-proxima-cita'>"+historial.nombre+" "+historial.apellidos+"</p>"+
                    "<p class='fecha-cita-receta'>"+fecha_historial+"</p>"+
                    "<button class='btn boton-cuadrado btn-form' onclick='verHistorial("+'"'+historial.archivo_pdf+'"'+")'>Ver historial</button>";
            }else{
                document.getElementById("ultimo-historial").innerHTML = "<p>No tienes historiales subidos.</p>";
            }

            //TOTAL CITAS QUE LLEVA EL PACIENTE REALIZADAS
            document.getElementById("total-citas").innerHTML =
                "<p class='fecha-cita-receta'>¡Total de citas desde que estás en Clíniko! <span style='font-size: 5vw'>"+respuesta.total_citas+"</span></p>";

            //ÚLTIMAS VALORACIONES
            if(respuesta.valoraciones.length > 0){
                var valoracion = "";

                respuesta.valoraciones.forEach(function(valora){
                    var estrellas = "";

                    for(var i = 1; i <= 5; i++){
                        if(i <= valora.puntuacion){
                            estrellas += '<i class="fas fa-star" style="color: #f4c542;"></i>';
                        }else{
                            estrellas += '<i class="far fa-star" style="color: #f4c542;"></i>';
                        }
                    }
                    valoracion += "<p>Lo que dijiste sobre: "+"<span class='nombre-medico-tarjeta-inicio-proxima-cita'>"+valora.nombre+" "+valora.apellidos+"</span></p>"+estrellas+"<p class='fecha-cita-receta'>"+valora.comentario+"</p><hr>";
                });
                document.getElementById("ultimas-valoraciones").innerHTML = valoracion;
            }else{
                document.getElementById("ultimas-valoraciones").innerHTML = "<p>Aún no has dejado ningúna valoración.</p>";
            }
        }
    };
    peticion.send();
}

function verReceta(nombre){
    var url_pdf = window.location.origin+"/uploads/recetas/"+nombre;
    var url_final = "https://docs.google.com/viewer?url="+encodeURIComponent(url_pdf);
    window.open(url_final, "_blank");
}

function verHistorial(nombre){
    var url_pdf = window.location.origin+"/uploads/historiales/"+nombre;
    var url_final = "https://docs.google.com/viewer?url="+encodeURIComponent(url_pdf);
    window.open(url_final, "_blank");
}

document.addEventListener("DOMContentLoaded", function(){
    cargarTarjetasInicioPagina();
});