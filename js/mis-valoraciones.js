//FUNCIÓN PARA CREAR EL OBJETO DE LA PETICIÓN
function crearObjetoPeticion(){
    var objeto_peticion = false;
    try{ 
        objeto_peticion = new XMLHttpRequest(); 
    }catch (error_1){
        try{ 
            objeto_peticion = new ActiveXObject("Msxml2.XMLHTTP"); 
        }catch (error_2){
            try{ 
                objeto_peticion = new ActiveXObject("Microsoft.XMLHTTP"); 
            }catch (error_3){ 
                objeto_peticion = false; 
            }
        }
    }
    return objeto_peticion;
}

var id_valoracion_actual = null;

//FUNCIÓN PARA CARGAR LAS ESPEICALIDADES EN EL SELECT
function cargarEspecialidadesValoraciones(){
    var peticion = crearObjetoPeticion();
    if(!peticion){
        return;
    }

    peticion.open("GET", "../../controladores/ajax-especialidades.php", true);
    peticion.onreadystatechange = function(){
        if(peticion.readyState === 4 && peticion.status === 200){
            var especialidades = JSON.parse(peticion.responseText);
            var select = document.getElementById("filtro-especialidad-valoraciones");
            especialidades.forEach(function(e){
                var opcion = document.createElement("option");
                opcion.value = e.id_especialidad;
                opcion.textContent = e.nombre;
                select.appendChild(opcion);
            });
        }
    };
    peticion.send();
}

//PALABROTAS QUE SI SE ESCRIBEN EN LA RESEÑA, LAS PONGO CON ASTERISCOS ****
var palabras_prohibidas = [
    "puta", "puto", "mierda", "joder", "hostia", "gilipollas",
    "cabrón", "cabron", "imbécil", "imbecil", "idiota", "estúpido",
    "estupido", "zorra", "capullo", "maricón", "maricon", "coño",
    "cono", "tonto", "culo", "polla", "verga", "facha", "desgraciado"
];

//CON UNA EXPRESIÓN REGEX SUSTITUYO LA PALABRA POR ASTERISCOS
function filtrarPalabras(texto){
    var resultado = texto;
    palabras_prohibidas.forEach(function(palabra){
        var regex = new RegExp(palabra, "gi");
        var asteriscos = "";
        for(var i = 0; i < palabra.length; i++){
            asteriscos += "*";
        }
        resultado = resultado.replace(regex, asteriscos);
    });
    return resultado;
}

//PARA 
function generarEstrellas(puntuacion){
    var estrellas = "";
    for(var i = 1; i <= 5; i++){
        if(i <= puntuacion){
            estrellas += "<i class='fas fa-star' style='color: #f4c542;'></i>";
        }else{
            estrellas += "<i class='far fa-star' style='color: #f4c542;'></i>";
        }
    }
    return estrellas;
}

//LA FUNCIÓN PARA CARGAR LOS MÉDICOS Y POR DEJAR LA RESEÑA
function cargarMedicosValoraciones(pagina){
    if(!pagina){
        pagina = 1;
    }

    var peticion = crearObjetoPeticion();
    if(!peticion){
        return;
    }

    var especialidad = document.getElementById("filtro-especialidad-valoraciones").value;
    var busqueda = document.getElementById("filtro-medico-valoraciones").value.trim();
    var valoracion = document.getElementById("filtro-valoracion-mejores").value;
    var orden = document.getElementById("filtro-orden-valoraciones").value;

    var url = "../../controladores/ajax-medicos-valoraciones.php?pagina="+pagina+"&especialidad="+especialidad+"&busqueda="+encodeURIComponent(busqueda)+"&valoracion="+valoracion+"&orden="+orden;


    peticion.open("GET", url, true);

    peticion.onreadystatechange = function (){
        if(peticion.readyState === 4 && peticion.status === 200){
            var respuesta = JSON.parse(peticion.responseText);
            var medicos = "";

            if(respuesta.medicos.length === 0){
                medicos = "<div class='col-12'><div class='d-flex justify-content-center'><p style='color: #48325A;'>No tienes médicos para valorar.</p></div>";
            }else{
                respuesta.medicos.forEach(function (medico){
                    var nombre_completo = medico.nombre+" "+medico.apellidos;
                    var especialidad;
                    if(medico.especialidad){
                        especialidad = medico.especialidad;
                    }else{
                        especialidad = "Sin especialidad";
                    }

                    var foto = "../../../uploads/perfiles/por_defecto.png";
                    if(medico.foto){
                        foto = "../../../uploads/perfiles/"+medico.foto;
                    }else{
                        foto = "";
                    }

                    var bloque_botones = "";
                    var bloque_valoracion_existente = "";

                    if(medico.id_valoracion){
                        //SI EL MEDICO YA TIENE UNA VALORACIÓN HECHA, GENERO LAS ESTRELLA CON LA FUNCIÓN QUE HICE ANTES.
                        bloque_valoracion_existente =
                            "<div class='mt-2'>"+generarEstrellas(medico.puntuacion)+
                            "<p class='mt-1 mb-0' style='color: #48325A;'>"+medico.comentario+"</p>"+
                            "</div>";

                        bloque_botones =
                            "<div><button class='btn boton-editar-resenia btn-form' onclick='mostrarFormulario("+medico.id_medico+", "+medico.puntuacion+", "+JSON.stringify(medico.comentario)+", "+medico.id_valoracion+")'>Editar reseña</button></div>" +
                            "<div><button class='btn boton-cancelar-resenia btn-form mt-2' onclick='eliminarValoracion("+medico.id_valoracion+", "+medico.id_medico+")'>Eliminar reseña</button></div>";
                    }else{
                        //SI EL MÉDICO NO TIENE RESEÑA
                        bloque_botones =
                            "<button class='btn btn-form boton-dejar-resenia mt-2' onclick='mostrarFormulario("+medico.id_medico+", null, null, null)'>Dejar reseña</button>";
                    }

                    medicos +=
                        "<div class='col-12 mb-4' id='tarjeta-medico-"+medico.id_medico+"'>"+
                            "<div class='card tarjeta-cita-receta'>"+
                                "<div class='card-body'>"+
                                    "<div class='row align-items-center'>"+
                                        "<div class='col-md-2 text-center'>"+
                                            "<img src='"+foto+"' class='img-fluid rounded-circle foto-medico-resenia' style='width:90px;height:90px;object-fit:cover;'>" +
                                        "</div>"+
                                        "<div class='col-md-7'>"+
                                            "<h6 class='mb-0'>"+nombre_completo+"</h6>"+
                                            "<span class='espe-tabla mt-2 d-inline-block' style='max-width:100%;'>"+especialidad+"</span>"+
                                            bloque_valoracion_existente+
                                            "<div id='form-valoracion-"+medico.id_medico+"' style='display:none;' class='mt-3 text-left'>"+
                                                "<div class='form-group mb-1'>"+
                                                    "<label class='mb-2'>Puntuación</label>"+
                                                    "<select class='form-control form-control-sm' id='puntuacion-"+medico.id_medico+"'>"+
                                                        "<option value='5'>&#9733;&#9733;&#9733;&#9733;&#9733; Lo recomendaría</option>"+
                                                        "<option value='4'>&#9733;&#9733;&#9733;&#9733; Genial atención</option>"+
                                                        "<option value='3'>&#9733;&#9733;&#9733; Pudo ayudarme</option>"+
                                                        "<option value='2'>&#9733;&#9733; Mala experiencia</option>"+
                                                        "<option value='1'>&#9733; No lo recomendaría</option>"+
                                                    "</select>"+
                                                "</div>"+
                                                "<div class='form-group mb-1'>" +
                                                    "<label class='mt-2'>Comentario</label>"+
                                                    "<textarea id='comentario-"+medico.id_medico+"' class='form-control form-control-sm' maxlength='200' rows='3' placeholder='Escribe tu opinión...'></textarea>"+
                                                    "<span id='contador-"+medico.id_medico+"'>0 / 200</span>"+
                                                "</div>"+
                                                "<button class='btn btn-form boton-descargar-receta btn-block mt-1' onclick='guardarValoracion("+medico.id_medico+")'>Guardar</button>"+
                                                "<button class='btn btn-form boton-cancelar-resenia btn-block mt-1' onclick='ocultarFormulario("+medico.id_medico+")'>Cancelar</button>"+
                                            "</div>"+
                                        "</div>"+
                                        "<div class='col-md-3 text-md-end text-center mt-3 mt-md-0'>"+
                                            "<div class='mt-2'>"+bloque_botones+"</div>"+
                                        "</div>"+
                                    "</div>"+
                                "</div>"+
                            "</div>"+
                        "</div>";
                });
            }
            document.getElementById("lista-medicos-valoraciones").innerHTML = medicos;

            //EVENTO Y FUNCIÓN PARA CONTAR QUE SE ESCRIBEN SOLO 200 CARACTERES
            respuesta.medicos.forEach(function (medico){
                var textarea = document.getElementById("comentario-"+medico.id_medico);
                var contador = document.getElementById("contador-"+medico.id_medico);

                if(textarea && contador){
                    textarea.addEventListener("input", function(){
                        contador.innerHTML = textarea.value.length+" / 200";
                    });
                }
            });

            //PARA LA PAGINACIÓN
            var botones_paginacion = "";
            for (var i = 1; i <= respuesta.total_paginas; i++){
                botones_paginacion += "<button class='btn btn-sm boton-pagina mr-1' onclick='cargarMedicosValoraciones("+i+")'>"+i+"</button>";
            }
            document.getElementById("paginacion-valoraciones").innerHTML = botones_paginacion;
        }
    };
    peticion.send();
}

//LA FUNCIÓN PARA DEJAR LA RESEÑA, ES DECIR, PARA QUE SE MUESTRE EL FORMULARIO DEL TEXTAREA
function mostrarFormulario(id_medico, puntuacion, comentario, id_valoracion){
    var formulario = document.getElementById("form-valoracion-"+id_medico);
    if (!formulario){
        return;
    }

    formulario.style.display = "block";

    id_valoracion_actual = id_valoracion;

    //SI EL MEDICO YA TIENE UNA RESEÑA HECHA, MOSTRAMOS LA PUNTUACIÓN QUE TIENE EN EL SELECT Y EL COMENTARIO DE ANTES TAMBIÉN.
    if(puntuacion){
        document.getElementById("puntuacion-"+id_medico).value = puntuacion;
    }
    if(comentario){
        var textarea = document.getElementById("comentario-"+id_medico);
        textarea.value = comentario;
        document.getElementById("contador-"+id_medico).innerHTML = comentario.length+" / 200";
    }
}

//FUNCIÓN PARA CERRAR EL FORMUALRIO SI LE DAMOS A CANCELAR.
function ocultarFormulario(id_medico) {
    var formulario = document.getElementById("form-valoracion-"+id_medico);
    if(formulario){
        formulario.style.display = "none";
    }
}

//FUNCIÓN PARA GUARDAR LA VALORACIÓN
function guardarValoracion(id_medico) {
    var puntuacion = document.getElementById("puntuacion-"+id_medico).value;
    var comentario_original = document.getElementById("comentario-"+id_medico).value.trim();
    var comentario = filtrarPalabras(comentario_original);
    var form = document.getElementById("form-valoracion-"+id_medico);

    if(comentario === ""){
        document.getElementById("mensaje-valoracion").innerHTML = "<p style='color: red;'>Debes escribir un comentario.</p>";
        return;
    }

    var peticion = crearObjetoPeticion();
    if(!peticion){
        return;
    }

    var url = "../../controladores/ajax-guardar-valoracion.php";

    var id_val;
    if(id_valoracion_actual){
        id_val = id_valoracion_actual;
    }else{
        id_val = "";
    }

    var parametrosurl = "id_medico="+id_medico+"&puntuacion="+puntuacion+"&comentario="+encodeURIComponent(comentario)+"&id_valoracion="+encodeURIComponent(id_val);

    peticion.open("POST", url, true);
    peticion.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    peticion.onreadystatechange = function (){
        if(peticion.readyState === 4 && peticion.status === 200){
            var respuesta = JSON.parse(peticion.responseText);
            if(respuesta.respuestaOk){
                document.getElementById("mensaje-valoracion").innerHTML = "<p style='color: green;'>La valoración se guardó correctamente.</p>";
                cargarMedicosValoraciones();
            }else{
                document.getElementById("mensaje-valoracion").innerHTML = "<p style='color: red;'>Error: "+respuesta.respuestaNOOK+"</p>";
            }
        }
    };
    peticion.send(parametrosurl);
}

//FUNCIÓN PARA ELIMINAR LA VALORACIÓN
function eliminarValoracion(id_valoracion, id_medico){
    var peticion = crearObjetoPeticion();

    if(!peticion){
        return;
    }

    var url = "../../controladores/ajax-guardar-valoracion.php";
    var parametrosurl = "borrar=eliminar&id_valoracion="+id_valoracion;

    peticion.open("POST", url, true);
    peticion.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    peticion.onreadystatechange = function (){
        if(peticion.readyState === 4 && peticion.status === 200){
            var respuesta = JSON.parse(peticion.responseText);
            if(respuesta.respuestaOk){
                document.getElementById("mensaje-valoracion").innerHTML = "<p style='color: green;'>La reseña fue eliminada correctamente.</p>";
                cargarMedicosValoraciones();
            }else{
                document.getElementById("mensaje-valoracion").innerHTML = "<p style='color: red;'>Error: "+respuesta.respuestaNOOK+"</p>";
            }
        }
    };
    peticion.send(parametrosurl);
}

//EVENTOS Y FUNCIONES DE LOS FILTROS
document.getElementById("filtro-especialidad-valoraciones").addEventListener("change", function(){
    cargarMedicosValoraciones();
});

document.getElementById("filtro-medico-valoraciones").addEventListener("input", function(){
    cargarMedicosValoraciones();
});

document.getElementById("filtro-valoracion-mejores").addEventListener("change", function(){
    cargarMedicosValoraciones();
});

document.getElementById("filtro-orden-valoraciones").addEventListener("change", function(){
    cargarMedicosValoraciones();
});

//PARA CARGAR LOS MÉDICOS
document.addEventListener("DOMContentLoaded", function (){
    cargarMedicosValoraciones();
    cargarEspecialidadesValoraciones();
});