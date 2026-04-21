//FUNCIÓN PARA CREAR EL OBJETO AJAX
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

//FUNCIÓN PARA MOSTRAR LAS CITAS
function mostrarCitasSolicitadas(pagina){
    //LA PÁGINA POR DEFECTO DE LA FUNCIÓN SERÁ LA PRIMERA
    if(pagina == null){
        pagina = 1;
    }

    var fecha = document.getElementById("filtro-fecha-solicitadas").value;
    var turno = document.getElementById("filtro-turno-solicitas").value;
    var busqueda = document.getElementById("filtro-paciente-solicitadas").value.trim();
    var orden = document.getElementById("filtro-orden-solicitadas").value;

    var peticion = crearObjetoPeticion();

    if(!peticion){
        return;
    }

    //CREAMOS LA URL
    var url = "../../controladores/ajax-citas-solicitadas.php?pagina="+pagina;

    if(fecha !== ""){
        url += "&fecha="+fecha;
    }
    if(turno !== ""){
        url += "&turno="+turno;
    }
    if(busqueda !== ""){
       url += "&busqueda="+encodeURIComponent(busqueda); 
    }
    if(orden !== ""){
      url += "&orden="+orden;
    }

    peticion.open("GET", url, true);

    peticion.onreadystatechange = function(){
        if(peticion.readyState === 4 && peticion.status === 200){
            var respuesta = JSON.parse(peticion.responseText);
            var contenedor_de_las_citas = document.getElementById("tabla-citas-solicitadas");

            //SI NO HAY CITAS
            if(respuesta.citas.length === 0){
                contenedor_de_las_citas.innerHTML = "<p style='text-align:center; color: #064635;'>No hay citas por confirmar.</p>";
            }else{
                //SI HAY CITAS, MOSTRAMOS LA TABLA
                var tabla = "<div class='table-responsive tabla-citas-solicitadas'>"+
                            "<table class='table table-borderless'>"+
                            "<thead>"+
                            "<tr>"+
                                "<th>Paciente</th>"+
                                "<th>Fecha</th>"+
                                "<th>Hora</th>"+
                                "<th>Motivo</th>"+
                                "<th>¿Confirmas?</th>"+
                            "</tr>"+
                            "</thead>"+
                            "<tbody>";

                //RECORREMOS LAS CITAS
                respuesta.citas.forEach(function(cita){
                    var partes_de_la_fecha = cita.fecha.split("-");
                    var fecha_formato_bueno = partes_de_la_fecha[2]+"/"+partes_de_la_fecha[1]+"/"+partes_de_la_fecha[0];

                    var partes_de_la_hora = cita.hora.split(":");
                    var hora_sin_segundos = partes_de_la_hora[0]+":"+partes_de_la_hora[1];

                    var motivo_de_cita = cita.motivo;
                    var nombre_completo = cita.nombre+" "+cita.apellidos;

                    tabla += "<tr class='datos-cita'>"+
                                "<td>"+nombre_completo+"</td>"+
                                "<td>"+fecha_formato_bueno+"</td>"+
                                "<td>"+hora_sin_segundos+"</td>"+
                                "<td>"+motivo_de_cita+"</td>"+
                                "<td>"+
                                    "<button class='btn btn-sm boton-cuadrado' onclick='confirmarCita("+cita.id_cita+")'>Confirmar</button>"+
                                "</td>"+
                             "</tr>";
                });
                tabla += "</tbody></table></div>";
                contenedor_de_las_citas.innerHTML = tabla;
            }

            //PAGINACIÓN
            var botones = "";
            for(var i = 1; i <= respuesta.total_paginas; i++){
                botones += "<button class='btn btn-sm boton-pagina mr-1' onclick='mostrarCitasSolicitadas("+i+")'>"+i+"</button>";
            }
            document.getElementById("paginacion-citas").innerHTML = botones;
        }
    };
    peticion.send();
}

//FUNCIÓN PARA CONFIRMAR UNA CITA
function confirmarCita(id_cita){
    var peticion = crearObjetoPeticion();
    
    if(!peticion){
        return;
    }

    var url = "../../controladores/ajax-confirmar-cita.php?id_cita="+id_cita;

    peticion.open("GET", url, true);
    peticion.onreadystatechange = function(){
        if(peticion.readyState === 4 && peticion.status === 200){
            var resp = JSON.parse(peticion.responseText);
            if(resp.confirmada){
                document.getElementById("mensaje-citas-solicitadas").innerHTML = "<p style='color: green;'>Cita confirmada correctamente.</p>";
                mostrarCitasSolicitadas();
            }else{
                document.getElementById("mensaje-citas-solicitadas").innerHTML = "<p style='color: red;'>Hubo un error al intentar confirmar la cita.</p>";
            }
        }
    }
    peticion.send();
}

//EVENTOS Y FUNCIONES DE LOS FILTROS
document.getElementById("filtro-fecha-solicitadas").addEventListener("change", function(){ 
    mostrarCitasSolicitadas();
});

document.getElementById("filtro-turno-solicitas").addEventListener("change", function(){ 
    mostrarCitasSolicitadas();
});

document.getElementById("filtro-paciente-solicitadas").addEventListener("input", function(){
    mostrarCitasSolicitadas();
});

document.getElementById("filtro-orden-solicitadas").addEventListener("change", function(){
    mostrarCitasSolicitadas();
});

//PARA QUE CUANDO CARGUE EL DOM CARGUE LA LISTA
document.addEventListener("DOMContentLoaded", function(){
    mostrarCitasSolicitadas();
});