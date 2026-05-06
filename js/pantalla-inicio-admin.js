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

//FUNCIÓN PARA CARGAR CADA TARJETA DE LA PANTALLA DEL INICIO DEL PANEL
function cargarTarjetasInicio(){
    var peticion = crearObjetoPeticion();

    if(!peticion){
        return;
    }

    peticion.open("GET", "../../controladores/ajax-inicio-admin.php", true);

    peticion.onreadystatechange = function(){
        if(peticion.readyState === 4 && peticion.status === 200){
            var respuesta = JSON.parse(peticion.responseText);

            //TARJETA DE LA GRÁFICA DEL TOTAL DE USUARIOS HABILITADOS Y NO HABILITADOS
            var grafica_usuarios_habilitados_y_no_habilitados = document.getElementById("grafica-pacientes").getContext("2d");
            new Chart(grafica_usuarios_habilitados_y_no_habilitados, {
                type: "doughnut",
                data: {
                    labels: ["Habilitados", "Deshabilitados"],
                    datasets: [{
                        data: [respuesta.usuarios_habilitados, respuesta.usuarios_deshabilitados],
                        backgroundColor: ["#2C2C3E", "#D47B5E"],
                        borderWidth: 1
                    }]
                }
            });

            //TARJETA DE ÚLTIMAS NOTIFICACIONES RECIBIDAS
            if(respuesta.notificaciones.length === 0){
                document.getElementById("ultimas-notificaciones").innerHTML =
                    "<p style='color: #2C2C3E;'>No tienes notificaciones sin leer.</p>";
            }else{
                var contenido = "";
                respuesta.notificaciones.forEach(function(notificacion){
                    var partes_fecha = notificacion.fecha.split(" ");
                    var partes = partes_fecha[0].split("-");
                    var fecha = partes[2]+"/"+partes[1]+"/"+partes[0];
                    var hora = partes_fecha[1].substring(0, 5);

                    contenido += "<p style='color: #2C2C3E;'>"+notificacion.mensaje+"</p>";
                    contenido += "<span class='etiqueta-filtro'>"+fecha+" - "+hora+"</span><hr>";
                });
                document.getElementById("ultimas-notificaciones").innerHTML = contenido;
            }

            //TARJETA DE ÚLTIMAS VALORACIONES REPORTADAS
            if(respuesta.valoraciones_reportadas.length === 0){
                document.getElementById("total-reportadas").innerHTML =
                    "<p style='color: #2C2C3E;'>No hay valoraciones reportadas.</p>";
            }else{
                var valoraciones_reportadas = "";
                respuesta.valoraciones_reportadas.forEach(function(val){
                    valoraciones_reportadas += "<p style='color: #2C2C3E;'>El paciente <span class='tipo_usuario'>"+val.nombre+" "+val.apellidos+"</span> tiene la siguiente valoración reportada:</p>";
                    valoraciones_reportadas += "<p class='etiqueta-filtro'>"+val.comentario+"</p>";
                    valoraciones_reportadas += "<hr>";
                });
                document.getElementById("total-reportadas").innerHTML = valoraciones_reportadas;
            }

            //TARJETA DE DE LA GRÁFICA DEL TOTAL DE CITAS POR ESTADO
            var grafica_citas_por_estado = document.getElementById("grafica-citas-estado").getContext("2d");
            new Chart(grafica_citas_por_estado, {
                type: "doughnut",
                data: {
                    labels: ["Pendiente", "Confirmada", "Cancelada", "Realizada", "No atendida"],
                    datasets: [{
                        data: [
                            respuesta.citas_pendiente,
                            respuesta.citas_confirmada,
                            respuesta.citas_cancelada,
                            respuesta.citas_realizada,
                            respuesta.citas_no_atendida
                        ],
                        options: {
                            maintainAspectRatio: false
                        },
                        backgroundColor: ["#F39C12", "#27AE60", "#E74C3C", "#2C2C3E", "#D47B5E"],
                        borderWidth: 1
                    }]
                }
            });

            //TOTAL DE DOCUMENTOS SUBIDOS HOY
            var grafica_documentos_subidos = document.getElementById("grafica-documentos").getContext("2d");
            new Chart(grafica_documentos_subidos, {
                type: "bar",
                data: {
                    labels: ["Recetas", "Historiales"],
                    datasets: [{
                        label: "Documentos subidos hoy",
                        data: [respuesta.recetas_hoy, respuesta.historiales_hoy],
                        backgroundColor: ["#2C2C3E", "#D47B5E"],
                        borderWidth: 1
                    }]
                }
            });

            //CANTIDAD DE VALORACIONES POR ESTRELLAS
            var grafica_valoraciones_por_estrellas = document.getElementById("grafica-estrellas").getContext("2d");
            new Chart(grafica_valoraciones_por_estrellas, {
                type: "horizontalBar",
                data: {
                    labels: ["5 estrellas", "4 estrellas", "3 estrellas", "2 estrellas", "1 estrella"],
                    datasets: [{
                        label: "Valoraciones",
                        data: [
                            respuesta.estrellas_5,
                            respuesta.estrellas_4,
                            respuesta.estrellas_3,
                            respuesta.estrellas_2,
                            respuesta.estrellas_1
                        ],
                        backgroundColor: ["#2C2C3E", "#27AE60", "#F39C12", "#D47B5E", "#E74C3C"],
                        borderWidth: 1
                    }]
                }
            });
        }
    };
    peticion.send();
}

//EVENTO Y FUNCIÓN PARA CARGAR LAS TARJETAS CUANDO CARGUE EL DOM
document.addEventListener("DOMContentLoaded", function(){
    cargarTarjetasInicio();
});