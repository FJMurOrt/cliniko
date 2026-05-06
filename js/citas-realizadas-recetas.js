//FUNCIÓN PARA CREAR EL OBJETO DE LA PETICIÓN
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

//MOSTRAR CITAS
function mostrarCitas(pagina){
    if(!pagina){
        pagina = 1;
    }

    var peticion = crearObjetoPeticion();

    if(!peticion){
        return;
    }
    
    var url = "../../controladores/ajax-citas-realizadas-medico.php?pagina="+pagina;

    var busqueda = document.getElementById("busqueda-paciente").value.trim();
    var fecha = document.getElementById("filtro-fecha-recetas-medico").value;
    var receta = document.getElementById("filtro-receta-medico").value;
    var tiene_observaciones = document.getElementById("filtro-receta-obervaciones").value;

    if(busqueda){
        url += "&busqueda="+encodeURIComponent(busqueda);
    }
    if(fecha){
        url += "&fecha="+fecha;
    }
    if(receta){
        url += "&receta="+receta;
    }
    if(tiene_observaciones){
        url += "&observaciones="+tiene_observaciones;
    }
    peticion.open("GET", url, true);

    peticion.onreadystatechange = function(){
        if(peticion.readyState === 4 && peticion.status === 200){
            var respuesta = JSON.parse(peticion.responseText);
            var informacion_de_la_cita = "";

            if(respuesta.citas.length === 0){
                informacion_de_la_cita = "<div class='col-12 text-center'><p style='color: #013d69;'>No hay citas realizadas.</p></div>";
            }else{
                respuesta.citas.forEach(function(cita){
                    var nombre = cita.nombre+" "+cita.apellidos;

                    //FORMATEO LAS FECHA AL FORMATO ESPAÑOL
                    var partes_de_la_fecha = cita.fecha.split("-");
                    var fecha_formato_bueno = partes_de_la_fecha[2]+"/"+partes_de_la_fecha[1]+"/"+partes_de_la_fecha[0];

                    var partes_de_la_hora = cita.hora.split(":");
                    var hora_sin_segundos = partes_de_la_hora[0]+":"+partes_de_la_hora[1];

                    var foto = "../../../uploads/perfiles/por_defecto.png";
                    if(cita.foto){
                        foto = "../../../uploads/perfiles/"+cita.foto;
                    }

                    //BOTÓN PARA PODER VER RECETA
                    var boton_ver = "";
                    if(cita.archivo_pdf){
                        boton_ver = "<button class='btn boton-cuadrado btn-form' onclick='verReceta("+'"'+cita.archivo_pdf+'"'+")'>Ver receta</button>";
                    }

                    //EN CASO DE QUE HAYA NOTA PARA LA CITA, SE MUESTRA EN UN DIV.
                    var div_para_la_nota = "";
                    if(cita.nota){
                        div_para_la_nota = 
                                    "<div class='alert mt-3 mb-0 bordes-observaciones text-center'>"+
                                        "<span class='observaciones'>Información Adicional</span> "+
                                        "<div class='mt-3' style='min-height:50px;'>"+cita.nota+"</div>"+
                                        "<br><button class='btn boton-cuadrado-eliminar mt-2' style='max-width: 100%;' onclick='eliminarNota("+cita.id_cita+")'>Eliminar nota</button>"+
                                    "</div>";
                    }

                    informacion_de_la_cita +=
                        "<div class='col-12 mb-4'>"+
                            "<div class='card tarjeta-paciente'>"+
                                "<div class='card-body'>"+
                                    "<div class='row align-items-center'>"+
                                        "<div class='col-md-2 text-center'>"+
                                            "<img src='"+foto+"' class='img-fluid rounded-circle foto-paciente-historiales' style='width:100px;height:100px;object-fit:cover;'>"+
                                        "</div>"+
                                        "<div class='col-md-6'>"+
                                            "<h5 class='mb-1'>"+nombre+"</h5>"+
                                            "<p class='mb-0 fecha-cita-receta d-inline-block' style='max-width: 100%;'>"+fecha_formato_bueno+" - "+hora_sin_segundos+"</p>"+
                                        "</div>"+
                                        "<div class='col-md-4 text-md-end text-center mt-3 mt-md-0'>"+
                                            "<button class='btn boton-cuadrado btn-form mb-2' onclick='subirReceta("+cita.id_cita+")'>Subir receta</button>"+
                                            "<button class='btn boton-cuadrado btn-form mb-2' onclick='agregarNota("+cita.id_cita+")'>Añadir nota</button>"+
                                            "<button class='btn boton-cuadrado btn-form mb-2' onclick='abrirModalGenerarReceta("+cita.id_cita+")'>Generar receta</button>"+
                                            boton_ver+
                                        "</div>"+
                                    "</div>"+
                                    div_para_la_nota+
                                "</div>"+
                            "</div>"+
                        "</div>";
                });
            }
            document.getElementById("contenedor-citas").innerHTML = informacion_de_la_cita;

            //PAGINACIÓN
            var botones = "";
            for(var i = 1; i <= respuesta.total_paginas; i++){
                botones += "<button class='btn btn-sm boton-pagina m-1' onclick='mostrarCitas("+i+")'>"+i+"</button>";
            }
            document.getElementById("paginacion").innerHTML = botones;
        }
    };
    peticion.send();
}

//FUNCIÓN PARA VER LA RECETA
function verReceta(nombre){
    var url_pdf = window.location.origin+"/uploads/recetas/"+nombre;
    var url_final = "https://docs.google.com/viewer?url="+encodeURIComponent(url_pdf);
    window.open(url_final, "_blank");
}

//FUNCIÓN PARA SUBIR LA RECETA
function subirReceta(id_cita){
    var subir_receta = document.createElement("input");
    subir_receta.type = "file";
    subir_receta.accept = "application/pdf";

    subir_receta.onchange = function(e){
        var archivo = e.target.files[0];

        if(!archivo){
            return;
        }

        var datos_para_subir_el_archivo = new FormData();
        datos_para_subir_el_archivo.append("archivo", archivo);
        datos_para_subir_el_archivo.append("id_cita", id_cita);

        var peticion = crearObjetoPeticion();
        peticion.open("POST", "../../controladores/subir_receta.php", true);

        peticion.onload = function(){
            if(peticion.status === 200){
                var respuesta = JSON.parse(peticion.responseText);
                if(respuesta.se_sube_la_receta){
                    document.getElementById("mensaje-receta").innerHTML = "<p style='color: green;'>La receta fue subida correctamente.</p>";
                    mostrarCitas();
                }else{
                    document.getElementById("mensaje-receta").innerHTML = "<p style='color: red;'>"+respuesta.no_se_sube_la_receta+"</p>";
                }
            }else{
                document.getElementById("mensaje-receta").innerHTML = "<p style='color: red;'>Hubo un error al intentar establecer la conexión con el servidor.</p>";
            }
        };
        peticion.send(datos_para_subir_el_archivo);
    };
    subir_receta.click();
}

function abrirModalGenerarReceta(id_cita){
    document.getElementById("id-cita-receta-pdf").value = id_cita;
    document.getElementById("medicamento-receta").value = "";
    document.getElementById("dosis-receta").value = "";
    document.getElementById("frecuencia-receta").value = "";
    document.getElementById("duracion-receta").value = "";
    document.getElementById("observaciones-receta").value = "";
    
    $("#modal-generar-receta").modal("show");
}

function generarRecetaPDF(){
    var id_cita = document.getElementById("id-cita-receta-pdf").value;
    var medicamento = document.getElementById("medicamento-receta").value.trim();
    var dosis = document.getElementById("dosis-receta").value.trim();
    var frecuencia = document.getElementById("frecuencia-receta").value.trim();
    var duracion = document.getElementById("duracion-receta").value.trim();
    var observaciones = document.getElementById("observaciones-receta").value.trim();

    if(medicamento === "" || dosis === "" || frecuencia === "" || duracion === ""){
        document.getElementById("mensaje-generar-receta").innerHTML = "<p style='color: red;'>Necesitas rellenar los campos obligatorios.</p>";
        return;
    }

    var peticion = crearObjetoPeticion();

    if(!peticion){
       return; 
    }

    peticion.open("GET", "../../controladores/ajax-datos-receta-pdf.php?id_cita="+id_cita, true);

    peticion.onreadystatechange = function(){
        if(peticion.readyState === 4 && peticion.status === 200){
            var datos = JSON.parse(peticion.responseText);

            var partes = datos.fecha_cita.split(" ");
            var fecha_partes = partes[0].split("-");
            var fecha = fecha_partes[2]+"/"+fecha_partes[1]+"/"+fecha_partes[0];
            var hora = partes[1].substring(0,5);

            var hoy = new Date();
            var fecha_emision = ("0"+hoy.getDate()).slice(-2)+"/"+("0"+(hoy.getMonth()+1)).slice(-2)+"/"+hoy.getFullYear();

            var documento_pdf = new PDF24Doc();
            documento_pdf.setCharset("UTF-8");
            documento_pdf.setFilename("Receta_Medica_Cliniko");
            documento_pdf.setPageSize(210, 297);

            var contenido_pdf = new PDF24Element();
            contenido_pdf.setTitle("Clíniko - Receta Médica");
            contenido_pdf.setAuthor("Clíniko");

            var html = "<div style='margin: 30px; font-family: Roboto, sans-serif;'>";
            html += "<h2 style='text-align: center; color: #01497C;'><u>Receta Médica</u></h2>";
            html += "<hr style='border-color: #D47B5E;'>";
            html += "<p><b style='color: #01497C;'>Fecha de emisión:</b> "+fecha_emision+"</p>";
            html += "<p><b style='color: #01497C;'>Nombre del médico que le atendió:</b> "+datos.nombre_medico+" "+datos.apellidos_medico+"</p>";
            html += "<p><b style='color: #01497C;'>Nombre del paciente atendido:</b> "+datos.nombre_paciente+" "+datos.apellidos_paciente+"</p>";
            html += "<p><b style='color: #01497C;'>Fecha de la cita:</b> "+fecha+" a las "+hora+"</p>";
            html += "<hr style='border-color: #D47B5E;'>";
            html += "<h4 style='color: #01497C;'>Prescripción</h4>";
            html += "<p><b style='color: #01497C;'>Medicamento:</b> "+medicamento+"</p>";
            html += "<p><b style='color: #01497C;'>Dosis que se debe seguir del medicamento:</b> "+dosis+"</p>";
            html += "<p><b style='color: #01497C;'>Frecuencia por cada toma:</b> "+frecuencia+"</p>";
            html += "<p><b style='color: #01497C;'>Tiempo:</b> "+duracion+"</p>";
            if(observaciones !== ""){
                html += "<p><b style='color: #01497C;'>Observaciones:</b> "+observaciones+"</p>";
            }
            html += "<hr style='border-color: #D47B5E;'>";
            html += "<p style='margin-top: 40px; text-align: right;'><b style='color: #01497C;'>Firmado:</b> "+datos.nombre_medico+" "+datos.apellidos_medico+"</p>";
            html += "</div>";

            contenido_pdf.setBody(html);
            documento_pdf.addElement(contenido_pdf);
            documento_pdf.create();

            $("#modal-generar-receta").modal("hide");
        }
    };
    peticion.send();
}

function agregarNota(id_cita){
    document.getElementById("id-cita-nota").value = id_cita;
    document.getElementById("textarea-nota").value = "";
    $("#modal-agregar-nota").modal("show");
}

function guardarNota(){
    var id_cita_actual = document.getElementById("id-cita-nota").value;
    var texto = document.getElementById("textarea-nota").value.trim();

    if(texto === ""){
        document.getElementById("mensaje-nota").innerHTML = "<p style='color: red;'>No puedes guardar una nota vacía.</p>";
        return;
    }

    var datos_que_envio_al_controlador = new FormData();
    datos_que_envio_al_controlador.append("id_cita", id_cita_actual);
    datos_que_envio_al_controlador.append("nota", texto);

    var peticion = crearObjetoPeticion();
    peticion.open("POST", "../../controladores/agregar-nota.php", true);

        peticion.onload = function(){
            if(peticion.status === 200){
            var respuesta = JSON.parse(peticion.responseText);
            if(respuesta.la_nota_se_sube){
                $("#modal-agregar-nota").modal("hide");
                document.getElementById("mensaje-nota").innerHTML = "<p style='color: green;'>Se agregaron las observaciones correctamente.</p>";
                mostrarCitas();
            }else{
                document.getElementById("mensaje-nota").innerHTML = "<p style='color: red;'>"+respuesta.la_nota_no_se_sube+"</p>";
            }
        }else{
            document.getElementById("mensaje-nota").innerHTML = "<p style='color: red;'>Hubo un error al intentar agregar la nota.</p>";
        }
    };
    peticion.send(datos_que_envio_al_controlador);
}

//FUNCIÓN PARA ELIMINAR LA NOTA DE OBSERVACIONES
function eliminarNota(id_cita){
    var datos_que_envio_al_controlador = new FormData();
    datos_que_envio_al_controlador.append("id_cita", id_cita);

    var peticion = crearObjetoPeticion();
    peticion.open("POST", "../../controladores/eliminar-nota.php", true);

    peticion.onload = function(){
        if(peticion.status === 200){
            var respuesta = JSON.parse(peticion.responseText);
            if(respuesta.la_nota_se_elimina){
                document.getElementById("mensaje-nota").innerHTML = "<p style='color: green;'>Las observaciones fueron eliminadas.</p>";
                mostrarCitas();
            }else{
                document.getElementById("mensaje-nota").innerHTML = "<p style='color: red;'>"+respuesta.la_nota_no_se_elimina+"</p>";
            }
        }else{
            document.getElementById("mensaje-nota").innerHTML = "<p style='color: red;'>Hubo un error al intentar eliminar la nota.</p>";
        }
    };
    peticion.send(datos_que_envio_al_controlador);
}

//EVENTO Y FUNCIÓN PRAA FILTRAR LAS CITAS POR FECHAS CON EL INPUT DE LA FECHA
document.getElementById("filtro-fecha-recetas-medico").addEventListener("change", function(){
    mostrarCitas();
});

//EVENTO PARA EL BOTON DE BUSCAR EL PACIENTE
document.getElementById("busqueda-paciente").addEventListener("input", function(){
    mostrarCitas();
});

//EVENTO Y FUNCIÓN PARA CONTAR QUE EL TEXTAREA NO LLEGUE A MÁS DE 200.
document.getElementById("textarea-nota").addEventListener("input", function(){
    document.getElementById("contador-nota").textContent = this.value.length + "/200";
});

//FILTROS DE SI TIENE RECETA O SI TIENE OBERSERVACIONES
document.getElementById("filtro-receta-medico").addEventListener("change", function(){
    mostrarCitas();
});
document.getElementById("filtro-receta-obervaciones").addEventListener("change", function(){
    mostrarCitas();
});

//CUANDO CARGA LA PÁGINA
document.addEventListener("DOMContentLoaded", function(){
    var hoy = new Date();
    var mes = ("0"+(hoy.getMonth()+1)).slice(-2);
    var dia = ("0"+hoy.getDate()).slice(-2);
    var fecha_hoy = hoy.getFullYear()+"-"+mes+"-"+dia;
    document.getElementById("filtro-fecha-recetas-medico").value = fecha_hoy;
    mostrarCitas();
});