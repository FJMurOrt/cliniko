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

function mostrarValoraciones(pagina){
    if(!pagina){
       pagina = 1; 
    }

    var peticion = crearObjetoPeticion();
    if(!peticion){
       return; 
    }

    var fecha = document.getElementById("filtro-fecha-valoraciones").value;
    var puntuacion = document.getElementById("filtro-puntuacion-valoraciones").value;
    var orden = document.getElementById("filtro-orden-valoraciones").value;
    var estado = document.getElementById("filtro-estado-valoraciones").value;

    var url = "../../controladores/ajax-valoraciones-admin.php?pagina="+pagina;
    if(fecha){
        url += "&fecha="+fecha; 
    }
    if(puntuacion){
        url += "&puntuacion="+puntuacion;  
    }
    if(orden){
        url += "&orden="+orden; 
    }
    if(estado){
        url += "&estado="+estado;
    } 

    peticion.open("GET", url, true);

    peticion.onreadystatechange = function(){
        if(peticion.readyState === 4 && peticion.status === 200){
            var respuesta = JSON.parse(peticion.responseText);
            var contenido = "";

            if(respuesta.valoraciones.length === 0){
                contenido = "<div class='col-12 text-center' style='color: #2C2C3E;'><p>No se encontraron valoraciones.</p></div>";
            }else{
                respuesta.valoraciones.forEach(function(v){
                    var partes_fecha = v.fecha.split(" ")[0].split("-");
                    var fecha_formateada = partes_fecha[2]+"/"+partes_fecha[1]+"/"+partes_fecha[0];

                    //ASI MUESTRO LOS ICONITOS DE LAS ESTRELLAS
                    var estrellas = "";
                    for(var i = 1; i <= 5; i++){
                        if(i <= v.puntuacion){
                            estrellas += '<i class="fas fa-star" style="color: #f4c542;"></i>';
                        }else{
                            estrellas += '<i class="far fa-star" style="color: #f4c542;"></i>';
                        }
                    }

                    //PARA LAS FOTOS
                    var foto_paciente = "../../../uploads/perfiles/por_defecto.png";
                    if(v.foto_paciente){
                        foto_paciente = "../../../uploads/perfiles/"+v.foto_paciente;
                    }

                    var foto_medico = "../../../uploads/perfiles/por_defecto.png";
                    if(v.foto_medico){
                       foto_medico = "../../../uploads/perfiles/"+v.foto_medico; 
                    }

                    var estado_valoracion = "";
                    if(v.estado === "reportada"){
                        estado_valoracion = "<span class='etiqueta_reportada'>Reportada</span>";
                        contenido +=
                        "<div class='col-12 mb-4'>"+
                            "<div class='card tarjeta-valoracion-reportada'>"+
                                "<div class='card-body'>"+
                                    "<div class='row align-items-center'>"+
                                        "<div class='col-md-8'>"+
                                            "<div class='d-flex align-items-center flex-wrap'>"+
                                                "<div class='d-flex align-items-center mr-3'>"+
                                                    "<img src='"+foto_paciente+"' class='img-fluid rounded-circle mr-2 fotos-valoraciones'>"+
                                                    "<span style='word-break: break-word;'>"+v.nombre_paciente+" "+v.apellidos_paciente+"</span>"+
                                                "</div>"+
                                                "<div class='d-flex align-items-center'>"+
                                                    "<img src='"+foto_medico+"' class='img-fluid rounded-circle mr-2 fotos-valoraciones'>"+
                                                    "<span style='word-break: break-word;'>"+v.nombre_medico+" "+v.apellidos_medico+"</span>"+
                                                "</div>"+
                                            "</div>"+
                                            "<div>"+estrellas+"</div>"+
                                            "<p class='mt-2 mb-0 etiqueta-filtro d-inline-block'>"+v.comentario+"</p>"+
                                            "<p class='mt-3'>"+fecha_formateada+" — "+estado_valoracion+"</p>"+
                                        "</div>"+
                                        "<div class='col-md-4 text-md-end text-center mt-3 mt-md-0'>"+
                                            "<button class='btn boton-cuadrado btn-form mb-2' onclick='abrirModalEditar("+v.id_valoracion+", "+JSON.stringify(v.comentario)+")'>Editar</button>"+
                                            "<button class='btn boton-cuadrado-eliminar btn-form' onclick='abrirModalEliminar("+v.id_valoracion+")'>Eliminar</button>"+
                                        "</div>"+
                                    "</div>"+
                                "</div>"+
                            "</div>"+
                        "</div>";
                    }else{
                        contenido +=
                        "<div class='col-12 mb-4'>"+
                            "<div class='card tarjeta-usuario-nuevo'>"+
                                "<div class='card-body'>"+
                                    "<div class='row align-items-center'>"+
                                        "<div class='col-md-8'>"+
                                            "<div class='d-flex align-items-center flex-wrap'>"+
                                                "<div class='d-flex align-items-center mr-3'>"+
                                                    "<img src='"+foto_paciente+"' class='img-fluid rounded-circle mr-2 fotos-valoraciones'>"+
                                                    "<span style='word-break: break-word;'>"+v.nombre_paciente+" "+v.apellidos_paciente+"</span>"+
                                                "</div>"+
                                                "<div class='d-flex align-items-center'>"+
                                                    "<img src='"+foto_medico+"' class='img-fluid rounded-circle mr-2 fotos-valoraciones'>"+
                                                    "<span style='word-break: break-word;'>"+v.nombre_medico+" "+v.apellidos_medico+"</span>"+
                                                "</div>"+
                                            "</div>"+
                                            "<div>"+estrellas+"</div>"+
                                            "<p class='mt-2 mb-0 etiqueta-filtro d-inline-block'>"+v.comentario+"</p>"+
                                            "<p class='mt-3'>"+fecha_formateada+"</span></p>"+
                                        "</div>"+
                                        "<div class='col-md-4 text-md-end text-center mt-3 mt-md-0'>"+
                                            "<button class='btn boton-cuadrado btn-form mb-2' onclick='abrirModalEditar("+v.id_valoracion+", "+JSON.stringify(v.comentario)+")'>Editar</button>"+
                                            "<button class='btn boton-cuadrado-eliminar btn-form' onclick='abrirModalEliminar("+v.id_valoracion+")'>Eliminar</button>"+
                                        "</div>"+
                                    "</div>"+
                                "</div>"+
                            "</div>"+
                        "</div>";
                    }
                });
            }

            document.getElementById("contenedor-valoraciones-admin").innerHTML = contenido;

            var botones = "";
            for(var i = 1; i <= respuesta.total_paginas; i++){
                botones += "<button class='btn btn-sm boton-pagina mr-1' onclick='mostrarValoraciones("+i+")'>"+i+"</button>";
            }
            document.getElementById("paginacion-valoraciones-admin").innerHTML = botones;
        }
    };
    peticion.send();
}

//FUNCIÓN APRA ABRIR LA VENTANA DEL MODAL PARA EDITAR LA VALORACIÓN
function abrirModalEditar(id_valoracion, comentario){
    //GUARDO EL ID DE LA VALORAICÓN QUE VOY A ELIMINAR Y SE LA PASO AL MODAL QUE ESTA EN EL HTML DE LA VISTA CON EL INPUT HIDDEN
    document.getElementById("id-valoracion-editar").value = id_valoracion;
    document.getElementById("textarea-editar-valoracion").value = comentario;
    document.getElementById("contador-editar-valoracion").textContent = comentario.length+"/200";
    $("#modal-editar-valoracion").modal("show");
}

//FUNCIÓN PARA GUARDAR LA EDICIÓN DE LA VALORACIÓN
function guardarEdicionValoracion(){
    var comentario = document.getElementById("textarea-editar-valoracion").value.trim();

    if(comentario === ""){
        document.getElementById("mensaje-valoraciones-admin").innerHTML = "<p style='color: red;'>El comentario no puede estar vacío.</p>";
        return;
    }

    var peticion = crearObjetoPeticion();

    if(!peticion){
        return; 
    }

    peticion.open("POST", "../../controladores/ajax-valoraciones-admin.php?loquesevaahacer=editar", true);

    peticion.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    peticion.onreadystatechange = function(){
        if(peticion.readyState === 4 && peticion.status === 200){
            var respuesta = JSON.parse(peticion.responseText);
            if(respuesta.editada){
                $("#modal-editar-valoracion").modal("hide");
                document.getElementById("mensaje-valoraciones-admin").innerHTML = "<p style='color: green;'>Valoración editada correctamente.</p>";
                mostrarValoraciones();
            }else{
                document.getElementById("mensaje-valoraciones-admin").innerHTML = "<p style='color: red;'>"+respuesta.error+"</p>";
            }
        }
    };
    //GUARDO EL ID DE LA VALORAICÓN QUE VOY A ELIMINAR Y SE LA PASO AL MODAL QUE ESTA EN EL HTML DE LA VISTA CON EL INPUT HIDDEN
    var id_valoracion = document.getElementById("id-valoracion-editar").value;
    peticion.send("id_valoracion="+id_valoracion+"&comentario="+encodeURIComponent(comentario));
}

function abrirModalEliminar(id_valoracion){
    //GUARDO EL ID DE LA VALORAICÓN QUE VOY A ELIMINAR Y SE LA PASO AL MODAL QUE ESTA EN EL HTML DE LA VISTA CON EL INPUT HIDDEN
    document.getElementById("id-valoracion-eliminar").value = id_valoracion;
    $("#modal-eliminar-valoracion").modal("show");
}

//FUNCIÓN PARA CONFIRMAR LA ELIMIANCIÓND DE LA VALORACIÓN
function confirmarEliminarValoracion(){
    var peticion = crearObjetoPeticion();

    if(!peticion){
        return;  
    }

    //GUARDO EL ID DE LA VALORAICÓN QUE VOY A ELIMINAR Y SE LA PASO AL MODAL QUE ESTA EN EL HTML DE LA VISTA CON EL INPUT HIDDEN
    var id_valoracion = document.getElementById("id-valoracion-eliminar").value;

    peticion.open("GET", "../../controladores/ajax-valoraciones-admin.php?loquesevaahacer=eliminar&id_valoracion="+id_valoracion, true);

    peticion.onreadystatechange = function(){
        if(peticion.readyState === 4 && peticion.status === 200){
            var respuesta = JSON.parse(peticion.responseText);
            if(respuesta.eliminada){
                $("#modal-eliminar-valoracion").modal("hide");
                document.getElementById("mensaje-valoraciones-admin").innerHTML = "<p style='color: green;'>Valoración eliminada correctamente.</p>";
                mostrarValoraciones();
            }else{
                document.getElementById("mensaje-valoraciones-admin").innerHTML = "<p style='color: red;'>Error al eliminar la valoración.</p>";
            }
        }
    };
    peticion.send();
}

//EVENTOS Y FUNCIONES PARA LOS FILTROS Y EL DOM
document.getElementById("filtro-fecha-valoraciones").addEventListener("change", function(){
    mostrarValoraciones();
});

document.getElementById("filtro-puntuacion-valoraciones").addEventListener("change", function(){
    mostrarValoraciones();
});

document.getElementById("filtro-orden-valoraciones").addEventListener("change", function(){
    mostrarValoraciones();
});

document.getElementById("filtro-estado-valoraciones").addEventListener("change", function(){
    mostrarValoraciones();
});

document.getElementById("textarea-editar-valoracion").addEventListener("input", function(){
    document.getElementById("contador-editar-valoracion").textContent = this.value.length+"/200";
});

document.addEventListener("DOMContentLoaded", function(){
    mostrarValoraciones();
});