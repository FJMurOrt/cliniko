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

function cargarTarjetasInicio(){
    var peticion = crearObjetoPeticion();
    if(!peticion){
        return;
    }

    peticion.open("GET", "../../controladores/ajax-pantalla-inicio-medico.php", true);

    peticion.onreadystatechange = function(){
        if(peticion.readyState === 4 && peticion.status === 200){
            var respuesta = JSON.parse(peticion.responseText);

            //LA PRIMERA TARJETA ES APRA MOSTRAR LA PRÓXIMA CITA QUE LE TOCA
            if(respuesta.proxima_cita){
                var cita = respuesta.proxima_cita;

                //DIVIDO LA FECHA DE LA HORA Y FORMATEO LA FECHA
                var partes = cita.fecha_cita.split(" ");
                var fecha_partes = partes[0].split("-");

                var fecha = fecha_partes[2]+"/"+fecha_partes[1]+"/"+fecha_partes[0];
                var hora = partes[1].substring(0,5);

                var foto_cita = "../../../uploads/perfiles/por_defecto.png";
                if(cita.foto_perfil){
                    foto_cita = "../../../uploads/perfiles/"+cita.foto_perfil;
                }

                document.getElementById("proxima-cita").innerHTML =
                    "<img src='"+foto_cita+"' class='img-fluid rounded-circle imagen-perfil-info mb-2'>"+
                    "<p class='nombre-medico-tarjeta-inicio-proxima-cita ml-2'>"+cita.nombre+" "+cita.apellidos+"</p>"+
                    "<p class='fecha-cita-receta mt-3'>Tu próxima cita la tienes el día "+fecha+" a las "+hora+". ¡Que no se te olvide!</p>";
            }else{
                document.getElementById("proxima-cita").innerHTML = "<p>No tienes citas por atender en los próximos días por ahora.</p>";
            }

            //LA TARJETA PARA MOSTRAR CUÁNTAS CITAS QUE EL MÉDICO HA ATENDIDO HOY
            if(respuesta.citas_hoy === 0){
                document.getElementById("citas-hoy").innerHTML = "<p>Hoy no has atendido ninguna cita durante el día de hoy.</p>";
            }else{
                document.getElementById("citas-hoy").innerHTML = "<p class='fecha-cita-receta'>¡Hoy has atendido un total de <span style='font-size: 5vw'>"+respuesta.citas_hoy+"</span> citas!</p>";
            }

            //PARA MOSTRAR CUANTAS CITAS TIENE AÚN PENDIENTE POR CONFIRMAR
            document.getElementById("citas-pendientes").innerHTML =
                "<p class='fecha-cita-receta'>¡Tienes un total de <span style='font-size: 5vw'>"+respuesta.citas_pendientes+"</span> citas que requieren tu confirmación!</p>";

            //AQUÍ MUESTRO A CUANTOS PACIENTES HA LLEGADO A ATENDER EL MÉDICO
            if(respuesta.total_pacientes === 0){
                document.getElementById("total-pacientes").innerHTML = "<p class='fecha-cita-receta'>Aún no has atendido a ningún paciente.</p>";
            }else{
                document.getElementById("total-pacientes").innerHTML = "<p class='fecha-cita-receta'>¡Has llegado a atender un total de <span style='font-size: 5vw; max-width: 100%;'>"+respuesta.total_pacientes+"</span> pacientes!</p>";
            }

            //CUÁL FUE EL ÚLTIMO PACIENTE AL QUE ATENDIÓ
            if(respuesta.ultimo_paciente){
                var paciente = respuesta.ultimo_paciente;

                var foto_paciente = "../../../uploads/perfiles/por_defecto.png";
                if(paciente.foto_perfil) foto_paciente = "../../../uploads/perfiles/"+paciente.foto_perfil;

                var partes_fecha = paciente.fecha_cita.split(" ")[0].split("-");
                var fecha_paciente = partes_fecha[2]+"/"+partes_fecha[1]+"/"+partes_fecha[0];

                document.getElementById("ultimo-paciente").innerHTML =
                    "<img src='"+foto_paciente+"' class='img-fluid rounded-circle imagen-perfil-info mb-2' style='width:80px;height:80px;object-fit:cover;'>"+
                    "<p class='nombre-medico-tarjeta-inicio-proxima-cita ml-2'>"+paciente.nombre+" "+paciente.apellidos+"</p>"+
                    "<p class='fecha-cita-receta'>"+fecha_paciente+"</p>";
            }else{
                document.getElementById("ultimo-paciente").innerHTML = "<p>Aún no has atendido a ningún paciente.</p>";
            }

            //LA NOTA MEDIA QUE TIENE EL MÉDICO DE LAS VALORACIONES QUE TENGA HECHAS
            if(respuesta.puntuacion_media){
                var estrellas = "";
                var media = Math.round(respuesta.puntuacion_media);
                for(var i = 1; i <= 5; i++){
                    if(i <= media){
                        estrellas += '<i class="fas fa-star" style="color: #f4c542;"></i>';
                    }else{
                        estrellas += '<i class="far fa-star" style="color: #f4c542;"></i>';
                    }
                }
                document.getElementById("puntuacion-media").innerHTML =
                    "<p style='width:100px; font-size: 50px; height:100px; border-radius:50%; border: 2px solid #064635; display:flex; align-items:center; justify-content:center; margin: 0 auto;' class='mb-3'>"+respuesta.puntuacion_media+"</p>"+
                    "<div>"+estrellas+"</div>";
            }else{
                document.getElementById("puntuacion-media").innerHTML = "<p>Aún no te han dejado ninguna valoración.</p>";
            }

            //PARA VER LAS ÚLTIMAS VALORACIONES QUE HA RECIBIDO
            if(respuesta.ultimas_valoraciones.length > 0){
                var valoraciones_recibidas = "";
                respuesta.ultimas_valoraciones.forEach(function(valoracion){
                    var estrellas_val = "";
                    for(var i = 1; i <= 5; i++){
                        if(i <= valoracion.puntuacion){
                            estrellas_val += '<i class="fas fa-star" style="color: #f4c542;"></i>';
                        }else{
                            estrellas_val += '<i class="far fa-star" style="color: #f4c542;"></i>';
                        }
                    }
                    valoraciones_recibidas += "<span>Lo que dijo </span><p class='nombre-medico-tarjeta-inicio-proxima-cita'>"+valoracion.nombre+" "+valoracion.apellidos+"</p> sobre ti:"+"<p>"+estrellas_val+"</p>"+"<p class='etiqueta-filtro mt-2'>"+valoracion.comentario+"</p><hr>";
                });
                document.getElementById("total-valoraciones").innerHTML = valoraciones_recibidas;
            }else{
                document.getElementById("total-valoraciones").innerHTML = "<p>Aún no te han dejado ninguna valoración.</p>";
            }

            //Y POR ÚLTIMO, PARA LA TARJETA DE LAS NOTIFICACIONES
            if(respuesta.notificaciones.length > 0){
                var contenido_tarjeta_notificaciones = "";
                respuesta.notificaciones.forEach(function(notifica){
                    contenido_tarjeta_notificaciones += "<p>"+notifica.mensaje+"</p><hr>";
                });
                document.getElementById("notificaciones-inicio").innerHTML = contenido_tarjeta_notificaciones;
            }else{
                document.getElementById("notificaciones-inicio").innerHTML = "<p>No tienes más notificaciones por ahora.</p>";
            }
        }
    };
    peticion.send();
}

document.addEventListener("DOMContentLoaded", function(){
    cargarTarjetasInicio();
});