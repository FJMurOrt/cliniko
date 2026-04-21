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

//FUNCIÓN PARA MOSTRAR LAS VALORACIONES
function mostrarValoraciones(pagina){
    if(!pagina){
        pagina = 1;
    }

    var peticion = crearObjetoPeticion();

    if(!peticion){
        return;
    }

    var busqueda = document.getElementById("filtro-paciente-valoraciones").value.trim();
    var puntuacion = document.getElementById("filtro-puntuacion-valoraciones").value;
    var orden = document.getElementById("filtro-orden-valoraciones").value;
    var fecha = document.getElementById("filtro-fecha-valoraciones").value;

    var url = "../../controladores/ajax-valoraciones-medico.php?pagina="+pagina;

    if(busqueda != ""){
        url += "&busqueda="+encodeURIComponent(busqueda);
    } 
    if(puntuacion != ""){
        url += "&puntuacion="+puntuacion;
    } 
    if(orden != ""){
        url += "&orden="+orden;
    } 
    if(fecha != ""){
        url += "&fecha="+fecha;
    }
    
    peticion.open("GET", url, true);

    peticion.onreadystatechange = function(){
        if(peticion.readyState === 4 && peticion.status === 200){
            var respuesta = JSON.parse(peticion.responseText);
            var informacion_de_la_valoracion = "";

            if(respuesta.valoraciones.length === 0){
                informacion_de_la_valoracion = "<div class='col-12 text-center'><p style='color: #064635;'>No tienes valoraciones aún.</p></div>";
            }else{
                respuesta.valoraciones.forEach(function(valoracion){
                    var foto = "../../../uploads/perfiles/por_defecto.png";

                    if(valoracion.foto_perfil){
                        foto = "../../../uploads/perfiles/"+valoracion.foto_perfil;
                    }

                    var partes_fecha = valoracion.fecha.split(" ")[0].split("-");
                    var fecha_formateada = partes_fecha[2]+"/"+partes_fecha[1]+"/"+partes_fecha[0];

                    var estrellas = "";
                    for(var i = 1; i <= 5; i++){
                        if(i <= valoracion.puntuacion){
                            estrellas += '<i class="fas fa-star" style="color: #f4c542;"></i>';
                        }else{
                            estrellas += '<i class="far fa-star" style="color: #f4c542;"></i>';
                        }
                    }

                    informacion_de_la_valoracion +=
                        "<div class='col-12 mb-4'>"+
                            "<div class='card tarjeta-paciente'>"+
                                "<div class='card-body'>"+
                                    "<div class='row align-items-center'>"+
                                        "<div class='col-md-2 text-center'>"+
                                            "<img src='"+foto+"' class='img-fluid rounded-circle foto-info-paciente'>"+
                                        "</div>"+
                                        "<div class='col-md-7'>"+
                                            "<h5 class='mb-1'>"+valoracion.nombre+" "+valoracion.apellidos+"</h5>"+
                                            "<div>"+estrellas+"</div>"+
                                            "<p class='mt-2 mb-0'>"+valoracion.comentario+"</p>"+
                                            "<p class='mt-2'>"+fecha_formateada+"</p>"+
                                        "</div>"+
                                        "<div class='col-md-3 text-md-end text-center mt-3 mt-md-0'>"+
                                            "<button class='btn boton-cuadrado-eliminar btn-form' onclick='reportarValoracion("+valoracion.id_valoracion+")'>Reportar</button>"+
                                        "</div>"+
                                    "</div>"+
                                "</div>"+
                            "</div>"+
                        "</div>";
                });
            }

            document.getElementById("contenedor-valoraciones").innerHTML = informacion_de_la_valoracion;

            var botones = "";
            for(var i = 1; i <= respuesta.total_paginas; i++){
                botones += "<button class='btn btn-sm boton-pagina mr-1' onclick='mostrarValoraciones("+i+")'>"+i+"</button>";
            }
            document.getElementById("paginacion-valoraciones").innerHTML = botones;
        }
    };
    peticion.send();
}

//FUNICÓN QUE USARÉ PARA REPORTAR (TODAVÍA NO LA HE HECHO)
function reportarValoracion(id_valoracion){
    alert("Aún no la he hechoooooooooo.");
}

//EVENTOS Y FUNCIONES DE LOS FILTROS
document.getElementById("filtro-paciente-valoraciones").addEventListener("input", function(){
    mostrarValoraciones();
});

document.getElementById("filtro-puntuacion-valoraciones").addEventListener("change", function(){
    document.getElementById("filtro-orden-valoraciones").value = "";
    document.getElementById("filtro-fecha-valoraciones").value = "";
    mostrarValoraciones();
});

document.getElementById("filtro-orden-valoraciones").addEventListener("change", function(){
    document.getElementById("filtro-puntuacion-valoraciones").value = "";
    document.getElementById("filtro-fecha-valoraciones").value = "";
    mostrarValoraciones();
});

document.getElementById("filtro-fecha-valoraciones").addEventListener("change", function(){
    document.getElementById("filtro-puntuacion-valoraciones").value = "";
    document.getElementById("filtro-orden-valoraciones").value = "";
    mostrarValoraciones();
});

//PARA CARGAR LAS VALORACIONES AL CARGAR EL DOM
document.addEventListener("DOMContentLoaded", function(){
    mostrarValoraciones();
});