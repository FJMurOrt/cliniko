//FUNCIÓN PARA CREAR OBJETO DE LA PETICIÓN AJAX
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
function cargarEspecialidades(){
    var peticion = crearObjetoPeticion();
    if(!peticion){ 
        alert("El navegador no es compatible con AJAX"); 
        return;
    }

    peticion.open("GET", "../../controladores/ajax-especialidades.php", true);
    peticion.onreadystatechange = function(){
        if(peticion.readyState === 4 && peticion.status === 200){
            var especialidades = JSON.parse(peticion.responseText);

            var select = document.getElementById("filtro-especialidad-recetas");
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

//MOSTRAR CITAS DEL PACIENTE
function mostrarCitas(pagina){
    if(!pagina){
        pagina = 1;
    }

    var peticion = crearObjetoPeticion();

    if(!peticion){
        return;
    }
    
    var fecha = document.getElementById("filtro-fecha").value;
    var medico = document.getElementById("filtro-medico").value.trim();
    var receta = document.getElementById("ordenar-turno").value;
    var especialidad = document.getElementById("filtro-especialidad-recetas").value;

    var url = "../../controladores/ajax-citas-realizadas-paciente.php?pagina="+pagina+"&fecha="+encodeURIComponent(fecha)+"&busqueda="+encodeURIComponent(medico)+"&receta="+encodeURIComponent(receta)+"&especialidad="+encodeURIComponent(especialidad);

    peticion.open("GET", url, true);

    peticion.onreadystatechange = function(){
        if(peticion.readyState === 4 && peticion.status === 200){
            var respuesta = JSON.parse(peticion.responseText);
            var informacion_cita = "";

            if(respuesta.citas.length === 0){
                informacion_cita = "<div class='col-12'><div class='d-flex justify-content-center'><p style='color: #48325A;'>No se encontraron citas realizadas.</p></div>";
            }else{
                respuesta.citas.forEach(function(cita){
                    var nombre = cita.nombre+" "+cita.apellidos;

                    //FORMATEO LA FECHA Y LA HORA
                    var partes_fecha = cita.fecha.split("-");
                    var fecha = partes_fecha[2]+"/"+partes_fecha[1]+"/"+partes_fecha[0];

                    var partes_hora = cita.hora.split(":");
                    var hora = partes_hora[0]+":"+partes_hora[1];

                    var foto = "../../../uploads/perfiles/por_defecto.png";
                    if(cita.foto){
                        foto = "../../../uploads/perfiles/"+cita.foto;
                    }

                    //SI HAY UN PDF SUBIDO, PONGO UN BOTÓN PARA PODER VERLO
                    var boton_ver = "";
                    var boton_descargar = "";

                    if(cita.archivo_pdf){
                        boton_ver = "<button class='btn boton-ver-receta btn-form mb-2' onclick='verReceta("+'"'+cita.archivo_pdf+'"'+")'>Ver receta</button>";
                        boton_descargar = "<a class='btn boton-descargar-receta btn-form mb-2' href='../../../uploads/recetas/"+cita.archivo_pdf+"' download>Descargar receta</a>";
                    }

                    //SI HAY NOTA DE OBSERVAICIONES, LA MUESTRO
                    var div_nota = "";
                    if(cita.nota){
                        div_nota = 
                            "<div class='alert mt-3 mb-0 nota-observaciones text-center'>"+
                                "<span class='recuerda'>¡Recuerda!</span>"+
                                "<div class='mt-2' style='min-height:50px;'>"+cita.nota+"</div>"+
                            "</div>";
                    }

                    informacion_cita +=
                        "<div class='col-12 mb-4'>"+
                            "<div class='card tarjeta-cita-receta'>"+
                                "<div class='card-body'>"+
                                    "<div class='row align-items-center'>"+
                                        "<div class='col-md-2 text-center'>"+
                                            "<img src='"+foto+"' class='img-fluid rounded-circle foto-medico-cita' style='width:100px;height:100px;object-fit:cover;'>"+
                                        "</div>"+
                                        "<div class='col-md-6'>"+
                                            "<h5 class='mb-1'>"+nombre+"</h5>"+
                                            "<p class='mb-1 espe-tabla d-inline-block mr-2' style='max-width: 100%;'>"+cita.especialidad+"</p>"+
                                            "<p class='mb-0 fecha-cita-receta d-inline-block' style='max-width: 100%;'>"+fecha+" - "+hora+"</p>"+
                                        "</div>"+
                                        "<div class='col-md-4 text-md-end text-center mt-3 mt-md-0'>"+
                                            boton_ver+
                                            boton_descargar+
                                        "</div>"+
                                    "</div>"+
                                    div_nota+
                                "</div>"+
                            "</div>"+
                        "</div>";
                });
            }
            document.getElementById("contenedor-citas").innerHTML = informacion_cita;

            //PAGINACIÓN
            var botones = "";
            for(var i=1; i<=respuesta.total_paginas; i++){
                botones += "<button class='btn btn-sm boton-pagina m-1' onclick='mostrarCitas("+i+")'>"+i+"</button>";
            }
            document.getElementById("paginacion").innerHTML = botones;
        }
    };
    peticion.send();
}

//FUNCIÓN PRA VER LA RECETA
function verReceta(nombre){
    var url_pdf = window.location.origin+"/uploads/recetas/"+nombre;
    var url_final = "https://docs.google.com/viewer?url="+encodeURIComponent(url_pdf);
    window.open(url_final, "_blank");
}

document.getElementById("filtro-fecha").addEventListener("change", function(){
    mostrarCitas();
});

//PARA BUSCAR AL MEDICO CON EL BUSCADOR
document.getElementById("filtro-medico").addEventListener("input", function(){
    mostrarCitas();
});

//PARA MOSTRAR SI TIENE LA RECETA
document.getElementById("ordenar-turno").addEventListener("change", function(){
    mostrarCitas();
});

//FILTRO ESPECIALDIADES
document.getElementById("filtro-especialidad-recetas").addEventListener("change", function(){
    mostrarCitas();
});

//PARA QUE CARGUE LA LISTA AL ABRIR LA PÁGINA
document.addEventListener("DOMContentLoaded", function(){
    cargarEspecialidades();
    mostrarCitas();
});

