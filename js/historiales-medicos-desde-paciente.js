//FUNCIÓN AJAX
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
//FUNCIÓN PARA CARGAR LAS ESPECIALIDADES
function cargarEspecialidadesHistoriales(){
    var peticion = crearObjetoPeticion();
    
    if(!peticion){
        return;
    }

    peticion.open("GET", "../../controladores/ajax-especialidades.php", true);
    peticion.onreadystatechange = function(){
        if(peticion.readyState === 4 && peticion.status === 200){
            var especialidades = JSON.parse(peticion.responseText);

            var select = document.getElementById("filtro-especialidades-historiales");
            select.innerHTML = "<option value=''>Todas</option>";
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

//FUNCIÓN PARA MOSTRAR MÉDICOS
function mostrarMedicos(pagina){
    if(pagina == null){
        pagina = 1;
    }

    var peticion = crearObjetoPeticion();

    if(!peticion){
        return;
    }

    var especialidad = document.getElementById("filtro-especialidades-historiales").value;
    var historial = document.getElementById("filtro-historial-medico").value;
    var busqueda = document.getElementById("buscador-medicos").value.trim();
    var orden = document.getElementById("filtro-orden-historiales").value;

    var url = "../../controladores/ajax-medicos-paciente.php?pagina="+pagina+"&especialidad="+especialidad+"&historial="+historial+"&busqueda="+encodeURIComponent(busqueda)+"&orden="+orden;

    peticion.open("GET", url, true);

    peticion.onreadystatechange = function(){
        if(peticion.readyState === 4 && peticion.status === 200){
            var respuesta = JSON.parse(peticion.responseText);

            var info_del_medico = "";

            if(respuesta.medicos.length === 0){
                info_del_medico = "<div class='col-12 text-center'><p style='color: #1A6B8A;'>No se encontraron médicos.</p></div>";
            }else{
                respuesta.medicos.forEach(function(medico){
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
                    }

                    var boton_descarga = "";

                    if(medico.archivo_pdf){
                        boton_descarga = 
                           "<button class='btn boton-cuadrado btn-form' onclick='verHistorial("+'"'+medico.archivo_pdf+'"'+")'>Ver mi historial</button>"+
                           "<a class='btn boton-cuadrado btn-form mt-2' href='../../../uploads/historiales/"+medico.archivo_pdf+"' download>Descargar historial</a>";
                    }else{
                        boton_descarga = "<p style='color: #1A6B8A;'>Tu médico aún no ha subido tu historial</p>";
                    }

                    //UN BOTÓN QUE MANDA A LA PÁGINA DE SOLITICAR CITA
                    var boton_solicitar_cita = "<a href='../paciente/solicitar-cita-lista.php'><button class='btn boton-cuadrado mt-2'>Solicitar cita</button></a>"

                    info_del_medico += 
                        "<div class='col-12 mb-4'>"+
                            "<div class='card tarjeta-cita-receta'>"+
                                "<div class='card-body'>"+
                                    "<div class='row align-items-center'>"+
                                        "<div class='col-md-2 text-center'>"+
                                            "<img src='"+foto+"' class='img-fluid rounded-circle foto-medico-cita' style='width:100px;height:100px;object-fit:cover;'>"+
                                        "</div>"+
                                        "<div class='col-md-6'>"+
                                            "<h5 class='mb-1'>"+nombre_completo+"</h5>"+
                                            "<p class='mb-1 espe-tabla d-inline-block mr-2' style='max-width: 100%;'>"+especialidad+"</p>"+
                                        "</div>"+
                                        "<div class='col-md-4 text-md-end text-center mt-3 mt-md-0'>"+
                                            boton_descarga+
                                            boton_solicitar_cita+
                                        "</div>"+
                                    "</div>"+
                                "</div>"+
                            "</div>"+
                        "</div>";
                });
            }
            document.getElementById("info_del_medico").innerHTML = info_del_medico;
            //PAGINACIÓN
            var botones = "";
            for(var i = 1; i <= respuesta.total_paginas; i++){
                botones += "<button class='btn btn-sm boton-pagina mr-1' onclick='mostrarMedicos("+i+")'>"+i+"</button>";
            }
            document.getElementById("paginacion-medicos").innerHTML = botones;
        }
    };
    peticion.send();
}

//FILTROS
document.getElementById("filtro-especialidades-historiales").addEventListener("change", function(){
    mostrarMedicos();
});

document.getElementById("filtro-historial-medico").addEventListener("change", function(){
    mostrarMedicos();
});

document.getElementById("buscador-medicos").addEventListener("input", function(){
    mostrarMedicos();
});

document.getElementById("filtro-orden-historiales").addEventListener("change", function(){
    mostrarMedicos();
});

//CUANDO CARGA LA PÁGINA
document.addEventListener("DOMContentLoaded", function(){
    cargarEspecialidadesHistoriales();
    mostrarMedicos();
});

//FUNCIÓN PARA VER EL HISTORIAL
function verHistorial(nombre_del_pdf){
    var url_pdf = window.location.origin + "/uploads/historiales/"+nombre_del_pdf;
    var url_final = "https://docs.google.com/viewer?url="+encodeURIComponent(url_pdf);
    window.open(url_final, "_blank");
}