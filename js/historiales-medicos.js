//FUNCIÓN AJAX (la misma que usas)
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

//FUNCIÓN PARA MOSTRAR PACIENTES
function mostrarPacientes(pagina){
    if(pagina == null){
        pagina = 1;
    }

    var peticion = crearObjetoPeticion();

    if(!peticion){
        return;
    }

    var busqueda = document.getElementById("busqueda-paciente-historial").value.trim();
    var historial = document.getElementById("filtro-historial-pacientes").value;
    var orden = document.getElementById("filtro-orden-pacientes").value;
    var edad = document.getElementById("filtro-edad-pacientes").value;

    var url = "../../controladores/ajax-pacientes-medico.php?pagina="+pagina;

    if(busqueda){
        url += "&busqueda="+encodeURIComponent(busqueda);
    }
    if(historial){
        url += "&historial="+historial; 
    } 
    if(orden){
        url += "&orden="+orden;
    }
    if(edad){
        url += "&edad="+edad; 
    }

    peticion.open("GET", url, true);

    peticion.onreadystatechange = function(){
        if(peticion.readyState === 4 && peticion.status === 200){
            var respuesta = JSON.parse(peticion.responseText);

            var info_del_paciente = "";

            if(respuesta.pacientes.length === 0){
                info_del_paciente = "<div class='col-12 text-center'><p style='color: #013d69;'>No se encotraron pacientes.</p></div>";
            }else{
                respuesta.pacientes.forEach(function(paciente){
                    var nombre_completo = paciente.nombre+" "+paciente.apellidos;

                    var fecha_formateada = "";
                    if(paciente.fecha_nacimiento){
                        var partes = paciente.fecha_nacimiento.split("-");
                        fecha_formateada = partes[2]+"/"+partes[1]+"/"+partes[0];
                    }

                    var foto = "../../../uploads/perfiles/por_defecto.png";
                    if (paciente.foto) {
                        foto = "../../../uploads/perfiles/"+paciente.foto;
                    }

                    var boton_ver_historial = "";

                    var boton_ver_historial = "";
                    if(paciente.archivo_pdf){
                        boton_ver_historial = "<button class='btn boton-cuadrado btn-form' onclick='verHistorial("+'"'+paciente.archivo_pdf+'"'+")'>Ver historial</button>";
                    }

                    info_del_paciente += 
                        "<div class='col-12 mb-4'>"+
                            "<div class='card tarjeta-paciente'>"+
                                "<div class='card-body'>"+
                                    "<div class='row align-items-center'>"+
                                        "<div class='col-md-2 text-center'>"+
                                            "<img src='"+foto+"' class='img-fluid rounded-circle foto-paciente-historiales' style='width:100px;height:100px;object-fit:cover;'>"+
                                        "</div>"+
                                        "<div class='col-md-6'>"+
                                            "<h5 class='mb-1'>"+nombre_completo+"</h5>"+
                                            "<p class='fecha-tarjeta-paciente d-inline-block' style='max-width: 100%;'>"+fecha_formateada+"</p>"+
                                        "</div>"+
                                        "<div class='col-md-4 text-md-end text-center mt-3 mt-md-0'>"+
                                            "<button class='btn boton-cuadrado btn-form mb-2' onclick='subirHistorialMedico("+paciente.id_paciente+")'>Subir historial médico</button>"+
                                            "<button class='btn boton-cuadrado btn-form mb-2' onclick='generarHistorialPDF("+paciente.id_paciente+", "+'"'+paciente.nombre+" "+paciente.apellidos+'"'+")'>Generar historial</button>"+
                                            boton_ver_historial+
                                        "</div>"+
                                    "</div>"+
                                "</div>"+
                            "</div>"+
                        "</div>";
                });
            }
            document.getElementById("info_del_paciente-pacientes").innerHTML = info_del_paciente;

            //PAGINACIÓN
            var botones = "";
            for(var i = 1; i <= respuesta.total_paginas; i++){
                botones += "<button class='btn btn-sm boton-pagina mr-1' onclick='mostrarPacientes("+i+")'>"+i+"</button>";
            }
            document.getElementById("paginacion-pacientes").innerHTML = botones;
        }
    };
    peticion.send();
}

//FUNCIÓN PARA GENERAR EL HISTORIAL MÉDICO
function generarHistorialPDF(id_paciente, nombre_paciente){
    var peticion = crearObjetoPeticion();

    if(!peticion){
        return;
    }

    peticion.open("GET", "../../controladores/ajax-generar-historial-pdf.php?id_paciente="+id_paciente, true);

    peticion.onreadystatechange = function(){
        if(peticion.readyState === 4 && peticion.status === 200){
            var datos = JSON.parse(peticion.responseText);

            var hoy = new Date();
            var fecha_emision = ("0"+hoy.getDate()).slice(-2)+"/"+("0"+(hoy.getMonth()+1)).slice(-2)+"/"+hoy.getFullYear();

            var partes_nacimiento = datos.paciente.fecha_nacimiento.split("-");
            var fecha_nacimiento = partes_nacimiento[2]+"/"+partes_nacimiento[1]+"/"+partes_nacimiento[0];

            var nss = "No proporcionado";
            if (datos.paciente.nss && datos.paciente.nss !== "El usuario no lo introdujo") {
                nss = datos.paciente.nss;
            }

            var documento_pdf = new PDF24Doc();
            documento_pdf.setCharset("UTF-8");
            documento_pdf.setFilename("Historial_Medico_"+nombre_paciente.replace(/ /g, "_"));
            documento_pdf.setPageSize(210, 297);

            var contenido_pdf = new PDF24Element();
            contenido_pdf.setTitle("Clíniko - Historial Médico");
            contenido_pdf.setAuthor("Clíniko");

            var informacion_del_pdf = "<div style='margin: 30px; font-family: Roboto, sans-serif;'>";
            informacion_del_pdf += "<h2 style='text-align: center; color: #01497C;'><u>Historial Médico</u></h2>";

            informacion_del_pdf += "<hr style='border-color: #D47B5E;'>";
            informacion_del_pdf += "<div style='text-align: center;'><h4 style='color: #01497C;'>Datos del Paciente</h4></div>";
            informacion_del_pdf += "<p><b style='color: #01497C;'>Nombre:</b> "+datos.paciente.nombre+" "+datos.paciente.apellidos+"</p>";
            informacion_del_pdf += "<p><b style='color: #01497C;'>Fecha de nacimiento:</b> "+fecha_nacimiento+"</p>";
            informacion_del_pdf += "<p><b style='color: #01497C;'>Dirección:</b> "+datos.paciente.direccion+"</p>";
            informacion_del_pdf += "<p><b style='color: #01497C;'>Teléfono:</b> "+datos.paciente.telefono+"</p>";
            informacion_del_pdf += "<p><b style='color: #01497C;'>NSS:</b> "+nss+"</p>";
            informacion_del_pdf += "<hr style='border-color: #D47B5E;'>";

            informacion_del_pdf += "<div style='text-align: center;'><h4 style='color: #01497C;'>Citas Realizadas</h4></div>";

            if(datos.citas.length === 0){
                informacion_del_pdf += "<p style ='color: #01497C;'>No hay citas realizadas con este paciente.</p>";
            }else{
                informacion_del_pdf += "<table style='width:100%; border-collapse: collapse;'>";
                informacion_del_pdf += "<thead>";
                informacion_del_pdf += "<tr style='background-color: #01497C; color: white;'>";
                informacion_del_pdf += "<th style='padding: 8px; border: 1px solid #01497C;'>Fecha</th>";
                informacion_del_pdf += "<th style='padding: 8px; border: 1px solid #01497C;'>Hora</th>";
                informacion_del_pdf += "<th style='padding: 8px; border: 1px solid #01497C;'>Motivo</th>";
                informacion_del_pdf += "</tr>";
                informacion_del_pdf += "</thead>";
                informacion_del_pdf += "<tbody>";

                datos.citas.forEach(function(cita){
                    var partes = cita.fecha_cita.split(" ");
                    var fecha_partes = partes[0].split("-");
                    var fecha = fecha_partes[2]+"/"+fecha_partes[1]+"/"+fecha_partes[0];
                    var hora = partes[1].substring(0, 5);
                    
                    var motivo = "No se especifica";
                    if(cita.motivo){
                        motivo = cita.motivo;
                    }

                    informacion_del_pdf += "<tr>";
                    informacion_del_pdf += "<td style='padding: 8px; border: 1px solid #01497C;'>"+fecha+"</td>";
                    informacion_del_pdf += "<td style='padding: 8px; border: 1px solid #01497C;'>"+hora+"</td>";
                    informacion_del_pdf += "<td style='padding: 8px; border: 1px solid #01497C;'>"+motivo+"</td>";
                    informacion_del_pdf += "</tr>";
                });
                informacion_del_pdf += "</tbody></table>";
            }

            informacion_del_pdf += "<hr style='border-color: #D47B5E;'>";
            informacion_del_pdf += "<div style='text-align: center;'><h4 style='color: #01497C;'>Datos del Médico</h4></div>";
            informacion_del_pdf += "<p><b style='color: #01497C;'>Nombre:</b> "+datos.medico.nombre+" "+datos.medico.apellidos+"</p>";
            informacion_del_pdf += "<p><b style='color: #01497C;'>Especialidad:</b> "+datos.medico.especialidad+"</p>";
            informacion_del_pdf += "<p><b style='color: #01497C;'>Fecha de emisión:</b> "+fecha_emision+"</p>";
            informacion_del_pdf += "</div>";

            contenido_pdf.setBody(informacion_del_pdf);
            documento_pdf.addElement(contenido_pdf);
            documento_pdf.create();
        }
    };
    peticion.send();
}

//FUNCIÓN PARA SUBIR EL HISTORIAL
function subirHistorialMedico(id_paciente){
    var subir_pdf = document.createElement("input");
    subir_pdf.type = "file";
    subir_pdf.accept = "application/pdf";

    subir_pdf.onchange = function(event){
        var archivo = event.target.files[0];
        if(archivo == null || archivo == undefined){
            return;
        }

        var datos_del_archivo = new FormData();
        datos_del_archivo.append("archivo", archivo);
        datos_del_archivo.append("id_paciente", id_paciente);

        var peticion_subir_pdf = crearObjetoPeticion();
        peticion_subir_pdf.open("POST", "../../controladores/subir_historial.php", true);

        peticion_subir_pdf.onload = function(){
            if(peticion_subir_pdf.readyState === 4 && peticion_subir_pdf.status === 200){
                var respuesta = JSON.parse(peticion_subir_pdf.responseText);
                if(respuesta.se_sube_el_historial){
                    if(respuesta.se_sube_el_historial){
                        document.getElementById("mensaje-historial").innerHTML = "<p style='color: green;'>El historial médico se subió correctamente.</p>";
                        mostrarPacientes();
                    }else{
                        document.getElementById("mensaje-historial").innerHTML = "<p style='color: red;'>"+respuesta.mensaje_de_error+"</p>";
                    }
                    mostrarPacientes();
                }else{
                    alert(respuesta.mensaje_de_error);
                }
            }else{
                document.getElementById("mensaje-historial").innerHTML = "<p style='color: red;'>Hubo un error al intentar realizar la subida del historial.</p>";
            }
        };
        peticion_subir_pdf.send(datos_del_archivo);
    };
    subir_pdf.click();
}

//FUNCIÓN PARA VER EL HISTORIAL EN EL VISUALIZADOR DEL PDF
function verHistorial(nombre_del_pdf){
    var url_pdf = window.location.origin + "/uploads/historiales/"+nombre_del_pdf;
    var url_final = "https://docs.google.com/viewer?url=" + encodeURIComponent(url_pdf);
    window.open(url_final, "_blank");
}

//EVENTO Y FUNCIÓN PARA LOS FILTROS
document.getElementById("busqueda-paciente-historial").addEventListener("input", function(){
    mostrarPacientes();
});

document.getElementById("filtro-historial-pacientes").addEventListener("change", function(){
    mostrarPacientes();
});

document.getElementById("filtro-orden-pacientes").addEventListener("change", function(){
    mostrarPacientes();
});

document.getElementById("filtro-edad-pacientes").addEventListener("change", function(){
    mostrarPacientes();
});

//CUANDO CARGA LA PÁGINA
document.addEventListener("DOMContentLoaded", function(){
    mostrarPacientes();
});
