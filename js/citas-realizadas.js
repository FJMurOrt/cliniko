//FUNCIÓN PARA CREAR AJAX
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

//FUNCIÓN PARA MOSTRAR CITAS REALIZADAS
function mostrarCitasRealizadas(pagina){
    //LA PÁGINA POR DEFECTO DE LA FUNCIÓN SERÁ LA PRIMERA
    if(pagina == null){
        pagina = 1;
    }

    var fecha = document.getElementById("filtro-fecha-citas-realizadas").value;
    var turno = document.getElementById("filtro-turno-citas-realizadas").value;
    var busqueda = document.getElementById("filtro-paciente-realizadas").value.trim();
    var orden = document.getElementById("filtro-orden-realizadas").value;

    var peticion = crearObjetoPeticion();
    
    if(!peticion){
        return; 
    }

    var url = "../../controladores/ajax-citas-realizadas.php?pagina="+pagina;

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
                            "<th>Paciente</th>"+
                            "<th>Fecha</th>"+
                            "<th>Hora</th>"+
                            "<th>Motivo</th>"+
                        "</tr>"+
                        "</thead>"+
                        "<tbody>";

            if(respuesta.citas.length === 0){
                tabla += "<tr><td colspan='4' class='text-center' style='color: #064635'>No hay citas realizadas</td></tr>";
            }else{
                respuesta.citas.forEach(function(cita){
                    var partes_de_la_fecha = cita.fecha.split("-");
                    var fecha_formato_bueno = partes_de_la_fecha[2]+"/"+partes_de_la_fecha[1]+"/"+partes_de_la_fecha[0];

                    var partes_de_la_hora = cita.hora.split(":");
                    var hora_sin_segundos = partes_de_la_hora[0]+":"+partes_de_la_hora[1];

                    var motivo_de_cita = cita.motivo;
                    var nombre_completo = cita.nombre+" "+cita.apellidos;

                    tabla += "<tr class='datos-cita'>"+
                                "<td>"+cita.nombre+" "+cita.apellidos+"</td>"+
                                "<td>"+fecha_formato_bueno+"</td>"+
                                "<td>"+hora_sin_segundos+"</td>"+
                                "<td>"+motivo_de_cita+"</td>"+
                             "</tr>";
                });
            }
            tabla += "</tbody></table></div>";

            document.getElementById("tabla-citas-realizadas").innerHTML = tabla;

            //PAGINACIÓN
            var botones = "";
            for(var i = 1; i <= respuesta.total_paginas; i++){
                botones += "<button class='btn btn-sm boton-pagina mr-1' onclick='mostrarCitasRealizadas("+i+")'>"+i+"</button>";
            }
            document.getElementById("paginacion-citas").innerHTML = botones;
        }
    };
    peticion.send();
}

//EVENTOS Y FUNCIONES DE LOS FILTROS
document.getElementById("filtro-fecha-citas-realizadas").addEventListener("change", function(){
    mostrarCitasRealizadas();
});

document.getElementById("filtro-turno-citas-realizadas").addEventListener("change", function(){
    mostrarCitasRealizadas();
});

document.getElementById("filtro-paciente-realizadas").addEventListener("input", function(){
    mostrarCitasRealizadas();
});

document.getElementById("filtro-orden-realizadas").addEventListener("change", function(){
    mostrarCitasRealizadas();
});

//PARA CUANDO CARGUE EL DOM QUE SE EJECUTE LA FUNCIÓN
document.addEventListener("DOMContentLoaded", function(){
    mostrarCitasRealizadas();
});