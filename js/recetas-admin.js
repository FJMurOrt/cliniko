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

//FUNCIÓN PARA CARGAR UN LISTA U OTRA DEPENDIENDO DEL TIPO DE DOCUMENTO POR EL QUE SE FILTRE
function mostrarDocumentos(pagina){
    if(!pagina){
       pagina = 1; 
    }

    var tipo = document.getElementById("filtro-tipo-documento").value;

    if(tipo === "historial"){
        mostrarHistoriales(pagina);
    }else{
        mostrarRecetas(pagina);
    }
}

//FUNCITÓN PARA MOSTRAR LAS RECETAS SI EL TIPO SELECCIONADO ES RECETAS
function mostrarRecetas(pagina){
    var peticion = crearObjetoPeticion();

    if(!peticion){
        return;
    }

    //MÁS FILTROS
    var busqueda_paciente = document.getElementById("filtro-paciente-recetas").value.trim();
    var busqueda_medico = document.getElementById("filtro-medico-recetas").value.trim();
    var fecha = document.getElementById("filtro-fecha-recetas").value;

    var url = "../../controladores/ajax-recetas-admin.php?pagina="+pagina;

    if(busqueda_paciente){
        url += "&busqueda_paciente="+encodeURIComponent(busqueda_paciente);
    }
    if(busqueda_medico){
        url += "&busqueda_medico="+encodeURIComponent(busqueda_medico);
    }
    if(fecha){
        url += "&fecha="+fecha;
    }

    peticion.open("GET", url, true);

    peticion.onreadystatechange = function(){
        if(peticion.readyState === 4 && peticion.status === 200){
            var respuesta = JSON.parse(peticion.responseText);
            var lista_de_recetas = "";

            if(respuesta.recetas.length === 0){
                lista_de_recetas = "<div class='col-12 text-center' style='color: #2C2C3E;'><p>No se encontró ningún documento.</p></div>";
            }else{
                respuesta.recetas.forEach(function(r){
                    //FORMATEO DE LA FECHA DE SUBIDA DE LA RECETA
                    var partes = r.fecha_creacion.split(" ")[0].split("-");
                    var fecha_formateada = partes[2]+"/"+partes[1]+"/"+partes[0];

                    //FORMATEO DE LA FECHA DE LA CITA DE LA RECETA
                    var partes_cita = r.fecha_cita.split(" ")[0].split("-");
                    var fecha_cita = partes_cita[2]+"/"+partes_cita[1]+"/"+partes_cita[0];

                    var url_pdf = window.location.origin+"/uploads/recetas/"+r.archivo_pdf;
                    var url_google = "https://docs.google.com/viewer?url="+encodeURIComponent(url_pdf);

                    lista_de_recetas +=
                        "<div class='col-12 mb-4'>"+
                            "<div class='card tarjeta-usuario-nuevo'>"+
                                "<div class='card-body'>"+
                                    "<div class='row align-items-center'>"+
                                        "<div class='col-md-8'>"+
                                            "<p class='mb-3'><span class='tipo_usuario'>Receta</span></p>"+
                                            "<p class='mb-3'><span class='etiqueta-filtro mr-2'>Paciente</span>"+r.nombre_paciente+" "+r.apellidos_paciente+"</p>"+
                                            "<p class='mb-3'><span class='etiqueta-filtro mr-2'>Médico</span>"+r.nombre_medico+" "+r.apellidos_medico+"</span></p>"+
                                            "<p class='mb-3'><span class='etiqueta-filtro mr-2'>Cita</span>"+fecha_cita+"</p>"+
                                            "<p class='mb-0'><span class='etiqueta-filtro mr-2'>Registro de la Receta</span>"+fecha_formateada+"</p>"+
                                        "</div>"+
                                        "<div class='col-md-4 text-md-end text-center mt-3 mt-md-0 d-flex flex-column align-items-center'>"+
                                            "<a href='"+url_google+"' target='_blank' class='btn boton-cuadrado btn-form mb-2'>Ver</a>"+
                                            "<a href='../../../uploads/recetas/"+r.archivo_pdf+"' download class='btn boton-cuadrado mb-2'>Descargar</a>"+
                                            "<button class='btn boton-cuadrado-eliminar' onclick='eliminarReceta("+r.id_receta+")'>Eliminar</button>"+
                                        "</div>"+
                                    "</div>"+
                                "</div>"+
                            "</div>"+
                        "</div>";
                });
            }

            document.getElementById("contenedor-documentos-admin").innerHTML = lista_de_recetas;
            var botones = "";
            for(var i = 1; i <= respuesta.total_paginas; i++){
                botones += "<button class='btn btn-sm boton-pagina mr-1' onclick='mostrarDocumentos("+i+")'>"+i+"</button>";
            }
            document.getElementById("paginacion-documentos-admin").innerHTML = botones;
        }
    };
    peticion.send();
}

//FUNCIÓN PARA MOTRAR LA LISTA DE HISTORIALES MÉDICOS SI EL TIPO DE DOCUMENTO ES HISTORIAL MÉDICO
function mostrarHistoriales(pagina){
    var peticion = crearObjetoPeticion();

    if(!peticion){
        return;
    }

    //FILTROS
    var busqueda_paciente = document.getElementById("filtro-paciente-recetas").value.trim();
    var busqueda_medico = document.getElementById("filtro-medico-recetas").value.trim();
    var fecha = document.getElementById("filtro-fecha-recetas").value;

    var url = "../../controladores/ajax-historiales-admin.php?pagina="+pagina;

    if(busqueda_paciente){
        url += "&busqueda_paciente="+encodeURIComponent(busqueda_paciente);
    }
    if(busqueda_medico){
        url += "&busqueda_medico="+encodeURIComponent(busqueda_medico);
    }
    if(fecha){
        url += "&fecha="+fecha;
    }

    peticion.open("GET", url, true);

    peticion.onreadystatechange = function(){
        if(peticion.readyState === 4 && peticion.status === 200){
            var respuesta = JSON.parse(peticion.responseText);
            var lista_de_historiales_medicos = "";

            if(respuesta.historiales.length === 0){
                lista_de_historiales_medicos = "<div class='col-12 text-center' style='color: #2C2C3E;'><p>No se encontró ningún documento.</p></div>";
            }else{
                respuesta.historiales.forEach(function(h){
                    var partes = h.fecha_registro.split(" ")[0].split("-");
                    var fecha_formateada = partes[2]+"/"+partes[1]+"/"+partes[0];

                    var url_pdf = window.location.origin+"/uploads/historiales/"+h.archivo_pdf;
                    var url_google = "https://docs.google.com/viewer?url="+encodeURIComponent(url_pdf);

                    lista_de_historiales_medicos +=
                        "<div class='col-12 mb-4'>"+
                            "<div class='card tarjeta-usuario-nuevo'>"+
                                "<div class='card-body'>"+
                                    "<div class='row align-items-center'>"+
                                        "<div class='col-md-8'>"+
                                            "<p class='mb-3'><span class='tipo_usuario'>Historial Médico</span></p>"+
                                            "<p class='mb-3'><span class='etiqueta-filtro mr-2'>Paciente</span>"+h.nombre_paciente+" "+h.apellidos_paciente+"</p>"+
                                            "<p class='mb-3'><span class='etiqueta-filtro mr-2'>Médico</span>"+h.nombre_medico+" "+h.apellidos_medico+"</p>"+
                                            "<p class='mb-0'><span class='etiqueta-filtro mr-2'>Registro del Historial Médico</span>"+fecha_formateada+"</p>"+
                                        "</div>"+
                                        "<div class='col-md-4 text-md-end text-center mt-3 mt-md-0 d-flex flex-column align-items-center'>"+
                                            "<a href='"+url_google+"' target='_blank' class='btn boton-cuadrado mb-2'>Ver</a>"+
                                            "<a href='../../../uploads/historiales/"+h.archivo_pdf+"' download class='btn boton-cuadrado btn-form mb-2'>Descargar</a>"+
                                            "<button class='btn boton-cuadrado-eliminar' onclick='eliminarHistorial("+h.id_historial+")'>Eliminar</button>"+
                                        "</div>"+
                                    "</div>"+
                                "</div>"+
                            "</div>"+
                        "</div>";
                });
            }

            document.getElementById("contenedor-documentos-admin").innerHTML = lista_de_historiales_medicos;
            var botones = "";
            for(var i = 1; i <= respuesta.total_paginas; i++){
                botones += "<button class='btn btn-sm boton-pagina mr-1' onclick='mostrarDocumentos("+i+")'>"+i+"</button>";
            }
            document.getElementById("paginacion-documentos-admin").innerHTML = botones;
        }
    };
    peticion.send();
}

//FUNCIÓN PARA ELIMINAR LA RECETA
function eliminarReceta(id_receta){
    var peticion = crearObjetoPeticion();
    if(!peticion){
        return; 
    }

    peticion.open("GET", "../../controladores/ajax-recetas-admin.php?loquesevaahacer=eliminar&id_receta="+id_receta, true);

    peticion.onreadystatechange = function(){
        if(peticion.readyState === 4 && peticion.status === 200){
            var respuesta = JSON.parse(peticion.responseText);
            if(respuesta.eliminada){
                document.getElementById("mensaje-documentos-admin").innerHTML = "<p style='color: green;'>La receta fue eliminada correctamente.</p>";
                mostrarDocumentos();
            }else{
                document.getElementById("mensaje-documentos-admin").innerHTML = "<p style='color: red;'>Hubo un error al intentar eliminar la receta.</p>";
            }
        }
    };
    peticion.send();
}

//FUNCIÓN PARA ELIMINAR EL HISTORIAL MÉDICO
function eliminarHistorial(id_historial){
    var peticion = crearObjetoPeticion();

    if(!peticion){
        return;
    }

    peticion.open("GET", "../../controladores/ajax-historiales-admin.php?loquesevaahacer=eliminar&id_historial="+id_historial, true);

    peticion.onreadystatechange = function(){
        if(peticion.readyState === 4 && peticion.status === 200){
            var respuesta = JSON.parse(peticion.responseText);
            if(respuesta.eliminada){
                document.getElementById("mensaje-documentos-admin").innerHTML = "<p style='color: green;'>Historial eliminado correctamente.</p>";
                mostrarDocumentos();
            }else{
                document.getElementById("mensaje-documentos-admin").innerHTML = "<p style='color: red;'>Error al eliminar el historial.</p>";
            }
        }
    };
    peticion.send();
}

//EVENTOS Y FUNCIONES DE LOS FILTROS Y DEL DOM
document.getElementById("filtro-paciente-recetas").addEventListener("input", function(){
    mostrarDocumentos();
});

document.getElementById("filtro-medico-recetas").addEventListener("input", function(){
    mostrarDocumentos();
});

document.getElementById("filtro-fecha-recetas").addEventListener("change", function(){
    mostrarDocumentos();
});

document.getElementById("filtro-tipo-documento").addEventListener("change", function(){
    mostrarDocumentos();
});

document.addEventListener("DOMContentLoaded", function(){
    mostrarDocumentos();
});