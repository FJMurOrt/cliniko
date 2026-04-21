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

//FUNCIÓN PARA MOSTRAR LAS CITAS CANCELADAS
function mostrarCitasCanceladas(pagina){
    if(pagina == null){
        pagina = 1;
    }

    var fecha = document.getElementById("filtro-fecha-canceladas").value;
    var turno = document.getElementById("filtro-turno-canceladas").value;
    var busqueda = document.getElementById("filtro-paciente-canceladas").value.trim();
    var orden = document.getElementById("filtro-orden-canceladas").value;

    var peticion = crearObjetoPeticion();

    if(!peticion){
        return;
    }

    var url = "../../controladores/ajax-citas-canceladas.php?pagina="+pagina;

    if(fecha != ""){
        url += "&fecha="+fecha;
    }
    if(turno != ""){
        url += "&turno="+turno;
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
                tabla += "<tr><td colspan='4' class='text-center' style='color: #064635;'>No hay citas canceladas.</td></tr>";
            }else{
                respuesta.citas.forEach(function(cita){

                    var partes_de_la_fecha = cita.fecha.split("-");
                    var fecha_formato = partes_de_la_fecha[2]+"/"+partes_de_la_fecha[1]+"/"+partes_de_la_fecha[0];

                    var partes_de_la_hora = cita.hora.split(":");
                    var hora_formato = partes_de_la_hora[0]+":"+partes_de_la_hora[1];

                    var nombre_completo = cita.nombre + " " + cita.apellidos;

                    tabla += "<tr class='datos-cita'>"+
                                "<td>"+nombre_completo+"</td>"+
                                "<td>"+fecha_formato+"</td>"+
                                "<td>"+hora_formato+"</td>"+
                                "<td>"+cita.motivo+"</td>"+
                             "</tr>";
                });
            }
            tabla += "</tbody></table></div>";
            
            document.getElementById("tabla-citas-canceladas").innerHTML = tabla;

            //PAGINACIÓN
            var botones = "";

            for(var i = 1; i <= respuesta.total_paginas; i++){
                botones += "<button class='btn btn-sm boton-pagina mr-1' onclick='mostrarCitasCanceladas("+i+")'>"+i+"</button>";
            }
            document.getElementById("paginacion-citas").innerHTML = botones;
        }
    };
    peticion.send();
}

//EVENTOS Y FUNCIONES DE LOS FILTROS
document.getElementById("filtro-fecha-canceladas").addEventListener("change", function(){
    mostrarCitasCanceladas();
});

document.getElementById("filtro-turno-canceladas").addEventListener("change", function(){
    mostrarCitasCanceladas();
});

document.getElementById("filtro-paciente-canceladas").addEventListener("input", function(){
    mostrarCitasCanceladas();
});

document.getElementById("filtro-orden-canceladas").addEventListener("change", function(){
    mostrarCitasCanceladas();
});

//PARA CARGAR LA TABLA POR DEFECTO
document.addEventListener("DOMContentLoaded", function(){
    mostrarCitasCanceladas();
});