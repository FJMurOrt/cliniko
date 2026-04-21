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
                informacion_de_la_cita = "<div class='col-12 text-center'><p style='color: #064635;'>No hay citas realizadas.</p></div>";
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
                        boton_ver = "<button class='btn boton-ver-receta btn-form' onclick='verReceta("+'"'+cita.archivo_pdf+'"'+")'>Ver receta</button>";
                    }

                    //EN CASO DE QUE HAYA NOTA PARA LA CITA, SE MUESTRA EN UN DIV.
                    var div_para_la_nota = "";
                    if(cita.nota){
                        div_para_la_nota = 
                                    "<div class='alert mt-3 mb-0 bordes-observaciones text-center'>"+
                                        "<span class='observaciones'>Observaciones</span> "+
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
                                            "<button class='btn boton-subir-receta btn-form mb-2' onclick='subirReceta("+cita.id_cita+")'>Subir receta</button>"+
                                            "<button class='btn boton-agregar-nota btn-form mb-2' onclick='agregarNota("+cita.id_cita+")'>Añadir nota</button>"+
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

//FUNCIÓN PARA AGREGAR LA NOTA DE OBSERVACIONES
var id_cita_actual = null;

function agregarNota(id_cita){
    id_cita_actual = id_cita;
    document.getElementById("textarea-nota").value = "";
    $("#modalNota").modal("show");
}

function guardarNota(){
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
                $("#modalNota").modal("hide");
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
    mostrarCitas();
});