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

function cargarEspecialidades(){
    var peticion = crearObjetoPeticion();

    if(!peticion){
       return; 
    }

    peticion.open("GET", "../../controladores/ajax-gestionar-especialidades.php?loquesevaahacer=obtener", true);

    peticion.onreadystatechange = function(){
        if(peticion.readyState === 4 && peticion.status === 200){
            var respuesta = JSON.parse(peticion.responseText);
            var lista_de_especialidades = "";

            if(respuesta.especialidades.length === 0){
                lista_de_especialidades = "<div class='col-12 text-center' style='color: #2C2C3E;'><p>No se encontraron especialidades.</p></div>";
            }else{
                respuesta.especialidades.forEach(function(especialidad){
                    lista_de_especialidades +=
                        "<div class='col-12 col-md-6 mb-3' id='especialidad-"+especialidad.id_especialidad+"'>"+
                            "<div class='card tarjeta-usuario-nuevo'>"+
                                "<div class='card-body justify-content-between align-items-center flex-wrap'>"+
                                    "<div>"+
                                        "<p><span class='tipo_usuario'>"+especialidad.nombre+"</span></p>"+
                                        "<p>Médicos que tienen esta especialidad: <span class='etiqueta-filtro'>"+especialidad.total_medicos+"</span></p>"+
                                    "</div>"+
                                    "<div>"+
                                        "<button class='btn boton-cuadrado btn-sm mb-1' onclick='mostrarCampoEditarEspecialidad("+especialidad.id_especialidad+")'>Editar</button>"+
                                        "<button class='btn boton-cuadrado-eliminar btn-sm' onclick='eliminarEspecialidad("+especialidad.id_especialidad+")'>Eliminar</button>"+
                                    "</div>"+
                                "</div>"+
                                "<div id='formulario-para-editar-la-especialidad-"+especialidad.id_especialidad+"' style='display:none;' class='card-body'>"+
                                    "<div>"+
                                        "<label class='etiqueta-filtro mr-2'>Introduce un nuevo nombre</label>"+
                                        "<input class='mb-1 form-control' type='text' id='campo-para-el-nuevo-nombre-de-la-especialidad"+especialidad.id_especialidad+"'>"+
                                        "<div>"+
                                            "<button class='btn boton-cuadrado btn-sm mb-1' style='max-width: 100%;' onclick='guardarNombreNuevo("+especialidad.id_especialidad+")'>Guardar cambios</button>"+
                                            "<button class='btn boton-cuadrado-eliminar btn-sm' onclick='cancelarEditarLaEspecialidad("+especialidad.id_especialidad+")'>Cancelar</button>"+
                                        "</div>"+
                                    "</div>"+
                                "</div>"+
                                "<div id='mensaje-error-especialidad"+especialidad.id_especialidad+"' class='text-center'></div>"+
                            "</div>"+
                        "</div>";
                });
            }
            document.getElementById("contenedor-especialidades").innerHTML = lista_de_especialidades;
        }
    };
    peticion.send();
}

//FUNCIÓN PARA AÑADIR UNA ESPECIALDIAD NUEVA
function añadirEspecialidad(){
    var nombre = document.getElementById("campo-para-añadir-nueva-especialidad").value.trim();

    if(nombre === ""){
        document.getElementById("mensaje-especialidad").innerHTML = "<p style='color: red;'>Debes introducir un nombre para la especialidad.</p>";
        return;
    }

    var expresion_solo_letras = new RegExp("^[a-zA-ZáéíóúÁÉÍÓÚñÑ\\s]+$");
    if(!expresion_solo_letras.test(nombre)){
        document.getElementById("mensaje-especialidad").innerHTML = "<p style='color: red;'>El nombre solo puede contener letras y espacios.</p>";
        return;
    }

    var peticion = crearObjetoPeticion();

    if(!peticion){
       return; 
    }

    peticion.open("POST", "../../controladores/ajax-gestionar-especialidades.php?loquesevaahacer=añadir", true);

    peticion.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    peticion.onreadystatechange = function(){
        if(peticion.readyState === 4 && peticion.status === 200){
            var respuesta = JSON.parse(peticion.responseText);
            if(respuesta.añadida){
                document.getElementById("mensaje-especialidad").innerHTML = "<p style='color: green;'>Especialidad añadida correctamente.</p>";
                document.getElementById("campo-para-añadir-nueva-especialidad").value = "";
                cargarEspecialidades();
            }else{
                document.getElementById("mensaje-especialidad").innerHTML = "<p style='color: red;'>"+respuesta.mensaje_de_error+"</p>";
            }
        }
    };
    peticion.send("nombre="+encodeURIComponent(nombre));
}

//FUNCIÓN PARA GUARDAR EL NOMBRE NUEVO QUE SE LE HAYA PUESTO A UNA ESPECIALIDAD
function guardarNombreNuevo(id_especialidad){
    var nombre = document.getElementById("campo-para-el-nuevo-nombre-de-la-especialidad"+id_especialidad).value.trim();

    if(nombre === ""){
        document.getElementById("mensaje-especialidad").innerHTML = "<p style='color: red;'>El nombre no puede estar vacío.</p>";
        return;
    }
    var expresion_solo_letras = new RegExp("^[a-zA-ZáéíóúÁÉÍÓÚñÑ\\s]+$");

    if(!expresion_solo_letras.test(nombre)){
        document.getElementById("mensaje-error-especialidad"+id_especialidad).innerHTML = "<p style='color: red;'>El nombre solo puede contener letras y espacios.</p>";
        return;
    }


    var peticion = crearObjetoPeticion();

    if(!peticion){
       return; 
    }

    peticion.open("POST", "../../controladores/ajax-gestionar-especialidades.php?loquesevaahacer=editar", true);

    peticion.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    peticion.onreadystatechange = function(){
        if(peticion.readyState === 4 && peticion.status === 200){
            var respuesta = JSON.parse(peticion.responseText);
            if(respuesta.guardada){
                document.getElementById("mensaje-especialidad").innerHTML = "<p style='color: green;'>Especialidad editada correctamente.</p>";
                cargarEspecialidades();
            }else{
                document.getElementById("mensaje-especialidad").innerHTML = "<p style='color: red;'>"+respuesta.mensaje_de_error+"</p>";
            }
        }
    };
    peticion.send("nombre="+encodeURIComponent(nombre)+"&id_especialidad="+id_especialidad);
}

//FUNCIÓN PARA ELIMINAR UNA ESPECIALIDAD
function eliminarEspecialidad(id_especialidad){
    var peticion = crearObjetoPeticion();

    if(!peticion){
       return; 
    }

    peticion.open("GET", "../../controladores/ajax-gestionar-especialidades.php?loquesevaahacer=eliminar&id_especialidad="+id_especialidad, true);

    peticion.onreadystatechange = function(){
        if(peticion.readyState === 4 && peticion.status === 200){
            var respuesta = JSON.parse(peticion.responseText);
            if(respuesta.eliminada){
                document.getElementById("mensaje-especialidad").innerHTML = "<p style='color: green;'>Especialidad eliminada correctamente.</p>";
                cargarEspecialidades();
            }else{
                document.getElementById("mensaje-error-especialidad"+id_especialidad).innerHTML = "<p style='color: red;'>"+respuesta.mensaje_de_error+"</p>";
            }
        }
    };
    peticion.send();
}


//FUNCIÓN PARA HACER VISIBLE EL CAMPO PARA EDITAR LA ESPECIALDIDAD CUANDO SE PULSA EN EL BOTÓN EDITAR EN UNA ESPECIALIDAD
function mostrarCampoEditarEspecialidad(id_especialidad){
    document.getElementById("formulario-para-editar-la-especialidad-"+id_especialidad).style.display = "block";
}

//FUNCIÓN PARA DEJAR DE HACER VISIBLE EL CAMPO DE EDITAR LA ESPECIALIDAD CUANDO CANCELO Y NO QUIERO EDITAR LA ESPECIALIDAD
function cancelarEditarLaEspecialidad(id_especialidad){
    document.getElementById("formulario-para-editar-la-especialidad-"+id_especialidad).style.display = "none";
}

//PARA QUE CARGUE LA LISTA CUANDO EL DOM ESTÉ CARGANDO SIN PROBLEMAS
document.addEventListener("DOMContentLoaded", function(){
    cargarEspecialidades();
});