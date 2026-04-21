//FUNCIÓN PARA CREAR EL OBJETO AJAX
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

//FUNCIÓN PARA MOSTRAR LAS CITAS ACTIVAS
function mostrarCitasActivas(pagina){
    //LA PÁGINA POR DEFECTO DE LA FUNCIÓN SERÁ LA PRIMERA
    if(pagina == null){
        pagina = 1;
    }

    var fecha = document.getElementById("filtro-fecha").value;
    var turno = document.getElementById("filtro-turno").value;
    var busqueda = document.getElementById("filtro-paciente-citas-activas").value.trim();
    var orden = document.getElementById("filtro-orden-citas-activas").value;

    var peticion = crearObjetoPeticion();

    if(!peticion){
        return;
    }

    //URL
    var url = "../../controladores/ajax-citas-activas.php?pagina="+pagina;

    if(fecha != ""){
        url = url+"&fecha="+fecha;
    }
    if(turno != ""){
        url = url+"&turno="+turno;
    }
    if(busqueda != ""){
        url += "&busqueda="+encodeURIComponent(busqueda);
    }

    if(orden != ""){
        url += "&orden="+orden;
    }

    peticion.open("GET", url, true);

    peticion.onreadystatechange = function(){
        if(peticion.readyState === 4 && peticion.status === 200){
            var respuesta = JSON.parse(peticion.responseText);

            var tabla = "<div class='table-responsive'>"+
                        "<table class='table table-borderless'>"+
                        "<thead>"+
                        "<tr>"+
                            "<th>Contacto</th>"+
                            "<th>Nombre del Paciente</th>"+
                            "<th>Fecha</th>"+
                            "<th>Hora</th>"+
                            "<th>Motivo</th>"+
                            "<th>¿Atendiste la cita?</th>"+
                        "</tr>"+
                        "</thead>"+
                        "<tbody>";

            if(respuesta.citas.length === 0){
                tabla += "<tr><td colspan='6' class='text-center' style='color: #064635;'>No hay citas activas.</td></tr>";
            }else{
                respuesta.citas.forEach(function(cita){
                    var partes_de_la_fecha = cita.fecha.split("-");
                    var fecha_formato_bueno = partes_de_la_fecha[2]+"/"+partes_de_la_fecha[1]+"/"+partes_de_la_fecha[0];

                    var partes_de_la_hora = cita.hora.split(":");
                    var hora_sin_segundos = partes_de_la_hora[0]+":"+partes_de_la_hora[1];

                    var motivo_de_cita = cita.motivo;
                    var nombre_completo = cita.nombre+" "+cita.apellidos;
                    var boton_ver = "<a class='btn btn-sm boton-ver' href='ver-paciente.php?id="+cita.id_paciente+"'>Ver</a>";

                    var fecha_ahora = new Date();
                    var fecha_de_la_cita = new Date(cita.fecha+" "+cita.hora);

                    var botones_estado = "";
                    if(fecha_de_la_cita < fecha_ahora){
                        var botones_estado = "<button class='btn boton-cuadrado2 btn-sm btn-form2 mb-2' onclick='marcarRealizada("+cita.id_cita+")'>Atendida</button>" +
                                            "<button class='btn boton-cancelar2 btn-sm btn-form2' onclick='marcarNoAtendida("+cita.id_cita+")'>No atendida</button>";
                    }

                    tabla += "<tr class='datos-cita'>"+
                                "<td>"+boton_ver+"</td>"+
                                "<td>"+nombre_completo+"</td>"+
                                "<td>"+fecha_formato_bueno+"</td>"+
                                "<td>"+hora_sin_segundos+"</td>"+
                                "<td>"+motivo_de_cita+"</td>"+
                                "<td>"+botones_estado+"</td>"+
                             "</tr>"+
                             "<tr><td colspan='6'><hr></td></tr>";
                });
            }
            tabla += "</tbody></table></div>";
            document.getElementById("tabla-citas-activas").innerHTML = tabla;

            //PAGINACIÓN
            var botones = "";

            for(var i = 1; i <= respuesta.total_paginas; i++){
                botones += "<button class='btn btn-sm boton-pagina mr-1' onclick='mostrarCitasActivas("+i+")'>"+i+"</button>";
            }
            document.getElementById("paginacion-citas").innerHTML = botones;
        }
    };
    peticion.send();
}

function marcarRealizada(id_cita){
    var peticion = new XMLHttpRequest();

    peticion.open("GET", "../../controladores/ajax-actualizar-cita.php?id_cita="+id_cita+"&nuevo_estado=realizada", true);

    peticion.onreadystatechange = function(){
        if(peticion.readyState === 4 && peticion.status === 200){
            var respuesta = JSON.parse(peticion.responseText);
            if(respuesta.la_cita_se_actualizo){
                mostrarCitasActivas();
            }else{
                alert("Error: "+respuesta.error);
            }
        }
    };
    peticion.send();
}

function marcarNoAtendida(id_cita){
    var peticion = new XMLHttpRequest();
    
    peticion.open("GET", "../../controladores/ajax-actualizar-cita.php?id_cita="+ id_cita+"&nuevo_estado=no_atendida", true);

    peticion.onreadystatechange = function(){
        if(peticion.readyState === 4 && peticion.status === 200){
            var respuesta = JSON.parse(peticion.responseText);
            if(respuesta.la_cita_se_actualizo){
                mostrarCitasActivas();
            }else{
                alert("Ocurrió un error: "+respuesta.error);
            }
        }
    };
    peticion.send();
}

//EVENTOS Y FUNCIONES DE LOS FILTROS FILTROS
document.getElementById("filtro-fecha").addEventListener("change", function(){
    mostrarCitasActivas();
});

document.getElementById("filtro-turno").addEventListener("change", function(){
    mostrarCitasActivas();
});

document.getElementById("filtro-paciente-citas-activas").addEventListener("input", function(){
    mostrarCitasActivas();
});

document.getElementById("filtro-orden-citas-activas").addEventListener("change", function(){
    mostrarCitasActivas();
});

//PARA MOSTRAR LA TABLA POR DEFECTO
document.addEventListener("DOMContentLoaded", function(){
    mostrarCitasActivas();
});