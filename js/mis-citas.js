function crearObjetoPeticion(){
    var obeto_peticion = false;
    try{
        obeto_peticion = new XMLHttpRequest();
    }catch(error_1){
        try{
            obeto_peticion = new ActiveXObject("Msxml2.XMLHTTP");
        }catch(error_2){
            try{
                obeto_peticion = new ActiveXObject("Microsoft.XMLHTTP"); 
            }catch(error_3){
                obeto_peticion = false; 
            }
        }
    }
    return obeto_peticion;
}

//FUNCIÓN PARA MOSTRAR LAS CITAS DEL PACIENTE
function mostrarMisCitas(pagina){
    if(pagina == null){
        pagina = 1;
    }

    var fecha = document.getElementById("filtro-fecha").value;
    var estado = document.getElementById("filtro-estado").value;
    var orden = document.getElementById("orden-nombre-miscitas").value;
    var turno = document.getElementById("ordenar-turno").value;

    var peticion = crearObjetoPeticion();

    if(!peticion){
        return;
    }

    var url = "../../controladores/ajax-mis-citas.php?pagina="+pagina;
    if(fecha != ""){
        url = url+"&fecha="+fecha;
    }
    if(estado != ""){
        url = url+"&estado="+estado;
    }

    if(orden !== ""){
        url += "&orden="+orden;
    }

    if(turno !== ""){
        url += "&turno="+turno;
    }


    peticion.open("GET", url, true);

    peticion.onreadystatechange = function(){
        if(peticion.readyState === 4 && peticion.status === 200){
            var respuesta = JSON.parse(peticion.responseText);
            var tabla = "<div class='table-responsive'>"+
                        "<table class='table table-borderless'>"+
                        "<thead>"+
                        "<tr>"+
                            "<th></th>"+
                            "<th>Médico</th>"+
                            "<th>Fecha</th>"+
                            "<th>Hora</th>"+
                            "<th>Motivo</th>"+
                            "<th>Estado</th>"+
                            "<th>¿Cancelar?</th>"+
                        "</tr>"+
                        "</thead><tbody>";

            if(respuesta.citas.length === 0){
                tabla += "<tr><td colspan='7' class='text-center' style='color: #48325A;'>No se encontraron citas.</td></tr>";
            }else{
                respuesta.citas.forEach(function(cita){
                    var partes_de_la_fecha = cita.fecha.split("-");
                    var fecha_formato_bueno = partes_de_la_fecha[2]+"/"+partes_de_la_fecha[1]+"/"+partes_de_la_fecha[0];

                    var partes_de_la_hora = cita.hora.split(":");
                    var hora_sin_segundos = partes_de_la_hora[0]+":"+partes_de_la_hora[1];

                    var nombre_doctor = cita.nombre+" "+cita.apellidos;

                    var ahora = new Date();
                    var fecha_cita = new Date(cita.fecha+" "+cita.hora);

                    var boton_cancelar = "";
                    if((cita.estado == "pendiente" || cita.estado == "confirmada") && fecha_cita > ahora){
                        boton_cancelar = "<button class='btn boton-cancelar-resenia' onclick='cancelarCita("+cita.id_cita+")'>Cancelar</button>";
                    }

                    var boton_justificante = "";
                    if(cita.estado == "realizada"){
                        boton_justificante = "<button class='btn btn-sm boton-justificante-cita' onclick='descargarJustificante("+cita.id_cita+")'>Justificante</button>";
                    }

                    //SEGUNDO EL ESTADO QUE SEA, LE PONGO UNA CLASE QUE LUEGO CON CSS MODIFICO PARA DARLE UN COLOR
                    var color_estado = "";
                    switch(cita.estado){
                        case "pendiente": 
                            color_estado = "pendiente"; 
                            break;
                        case "confirmada": 
                            color_estado = "confirmada"; 
                            break;
                        case "realizada": 
                            color_estado = "realizada"; 
                            break;
                        case "no_atendida": 
                            color_estado = "no_atendida"; 
                            break;
                        case "cancelada": 
                            color_estado = "cancelada"; 
                            break;

                        default: 
                            color_estado = "clase_sin_color"; 
                            break;
                    }

                    if(cita.estado == "pendiente"){ 
                        if(fecha_cita < ahora){
                            estado_de_la_cita = "Reembolso por confirmación";
                        }else{
                            estado_de_la_cita = "Sin confirmar"; 
                        }
                    }
                    if(cita.estado == "confirmada"){ 
                        estado_de_la_cita = "Activa"; 
                    }
                    if(cita.estado == "realizada"){ 
                        estado_de_la_cita = "Atendida"; 
                    }
                    if(cita.estado == "no_atendida") { 
                        estado_de_la_cita = "No atendida"; 
                    }
                    if(cita.estado == "cancelada"){ 
                        estado_de_la_cita = "Cancelada"; 
                    }

                    tabla += "<tr>"+
                                "<td>"+boton_justificante+"</td>"+
                                "<td>"+nombre_doctor+"</td>"+
                                "<td>"+fecha_formato_bueno+"</td>"+
                                "<td>"+hora_sin_segundos+"</td>"+
                                "<td>"+cita.motivo+"</td>"+
                                "<td><span class='estado-cita "+color_estado+"'>"+estado_de_la_cita+"</span></td>"+
                                "<td>"+boton_cancelar+"</td>"+
                             "</tr>";
                });
            }

            tabla += "</tbody></table></div>";
            document.getElementById("tabla-mis-citas").innerHTML = tabla;

            //PAGINACIÓN
            var botones = "";
            for(var i = 1; i <= respuesta.total_paginas; i++){
                botones += "<button class='btn btn-sm boton-pagina mr-1' onclick='mostrarMisCitas("+i+")'>"+i+"</button>";
            }
            document.getElementById("paginacion-citas").innerHTML = botones;
        }
    };
    peticion.send();
}

//FUNCIÓN PARA CANCELAR UNA CITA
function cancelarCita(id_cita){
    var peticion = crearObjetoPeticion();
    if(!peticion){
        alert("AJAX no es compatible con tu navegador.");
        return;
    }

    var url = "../../controladores/ajax-cancelar-cita.php?id_cita="+id_cita;

    peticion.open("GET", url, true);

    peticion.onreadystatechange = function(){
        if(peticion.readyState === 4 && peticion.status === 200){
            var respuesta = JSON.parse(peticion.responseText);
            if(respuesta.cita_cancelada){
                document.getElementById("mensaje-citas").innerHTML = "<p style='color: green;'>La cita fue cancelada correctamente.</p>";
                mostrarMisCitas();
            }else{
                document.getElementById("mensaje-citas").innerHTML = "<p style='color: red;'>Hubo un error al intentar cancelar la cita.</p>";
            }
        }
    };
    peticion.send();
}

//FUNCIÓN PARA CREAR EL JUSTIFICANTE EN FORMA DE REDACTADO
function descargarJustificante(id_cita){
    var peticion = crearObjetoPeticion();
    
    if(!peticion){
        alert("AJAX no es compatible con tu navegador.");
        return;
    }

    var url = "../../controladores/ajax-justificante.php?id_cita="+id_cita;

    peticion.open("GET", url, true);

    peticion.onreadystatechange = function(){
        if(peticion.readyState === 4 && peticion.status === 200){
            var cita = JSON.parse(peticion.responseText);

            if(!cita.error){
                var documento_pdf = new PDF24Doc();
                documento_pdf.setCharset("UTF-8");
                documento_pdf.setFilename("Justificante_Cita_"+cita.id_cita);
                documento_pdf.setPageSize(210, 297);

                var contenido_pdf = new PDF24Element();
                contenido_pdf.setTitle("Cíniko - Justificante");
                contenido_pdf.setAuthor("Clíniko");
                var hoy = new Date();
                var fecha_formateada = ("0"+hoy.getDate()).slice(-2)+"/"+("0"+(hoy.getMonth()+1)).slice(-2)+"/"+hoy.getFullYear();

                contenido_pdf.setDateTime("Justificante emitido durante el día "+fecha_formateada);

                //CONTENIDO EN FORMA DE REDACTADO
                var informacion_contenido = "<div style='margin: 20px;'>";
                informacion_contenido += "<h2 style='text-align:center; margin-bottom: 20px;'>Justificante de Atención Médica</h2>";
                informacion_contenido += "<p>Con este documento se justifica la asistencia médica de la persona <strong>" 
                                        +cita.nombre_paciente+" "+cita.apellidos_paciente 
                                        +"</strong> con número de la seguridad social " +cita.nss+ ", atendida por el profesional <strong>" 
                                        +cita.nombre_medico+" "+cita.apellidos_medico 
                                        +"</strong> durante el día <strong>" +cita.fecha 
                                        +"</strong> a las " +cita.hora+" horas."
                                        +" El motivo de la consulta médica fue: " +cita.motivo 
                                        +".</p>";
                informacion_contenido += "<p style='margin-top:40px; text-align:right;'>Firmado: "+cita.nombre_medico+" "+cita.apellidos_medico+"</p>";
                informacion_contenido += "</div>";

                contenido_pdf.setBody(informacion_contenido);
                documento_pdf.addElement(contenido_pdf);
                documento_pdf.create();

            }else{
                document.getElementById("mensaje-citas").innerHTML = "<p style='color: red;'>No se pudo crear el justificante PDF.: "+cita.error+"</p>";
            }
        }
    };
    peticion.send();
}

//EVENTOS
document.getElementById("filtro-fecha").addEventListener("change", function(){
    mostrarMisCitas();
});

document.getElementById("filtro-estado").addEventListener("change", function(){
    mostrarMisCitas();
});

document.getElementById("orden-nombre-miscitas").addEventListener("change", function(){
    mostrarMisCitas();
});

document.getElementById("ordenar-turno").addEventListener("change", function() {
    mostrarMisCitas();
});

document.addEventListener("DOMContentLoaded", function(){
    mostrarMisCitas();
});
