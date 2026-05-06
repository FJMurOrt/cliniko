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

//FUNCIÓN PARA LA LISTA DE HORARIOS
function mostrarHorarios(pagina){
    if(pagina == null){
        pagina = 1;
    }

    //FILTROS
    var fecha = document.getElementById("filtro-fecha-ver-horarios").value;
    var turno = document.getElementById("filtro-turno-ver-horarios").value;

    var peticion = crearObjetoPeticion();

    if(!peticion){
        return;
    }

    var url = "../../controladores/ajax-listar-horarios.php?pagina="+pagina;

    if(fecha != ""){
        url += "&fecha="+fecha;
    }

    if(turno != ""){
        url += "&turno="+encodeURIComponent(turno);
    }

    peticion.open("GET", url, true);

    peticion.onreadystatechange = function(){
        if(peticion.readyState === 4 && peticion.status === 200){
            var respuesta = JSON.parse(peticion.responseText);
            var hoy = new Date();
            var mes = ("0"+(hoy.getMonth()+1)).slice(-2);
            var dia = ("0"+hoy.getDate()).slice(-2);
            var fecha_hoy = hoy.getFullYear()+"-"+mes+"-"+dia;

            var tabla = "<div class='table-responsive tabla-horarios'>"+
                        "<table class='table table-borderless'>"+
                        "<thead>"+
                        "<tr>"+
                            "<th>Fecha de la disponibilidad</th>"+
                            "<th>Turno</th>"+
                            "<th>Desde</th>"+
                            "<th>Hasta</th>"+
                            "<th>¿Qué quieres hacer?</th>"+
                        "</tr>"+
                        "</thead>"+
                        "<tbody>";

            if(respuesta.horarios.length === 0){
                tabla += "<tr><td colspan='5' class='text-center' style='color: #013d69;'>No hay disponibilidades agregadas.</td></tr>";
            }else{
                respuesta.horarios.forEach(function(horario){
                    var partes_fecha = horario.fecha.split("-");
                    var fecha_formato = partes_fecha[2]+"/"+partes_fecha[1]+"/"+partes_fecha[0];

                    var hora_inicio = horario.hora_inicio.substring(0, 5);
                    var hora_fin = horario.hora_fin.substring(0, 5);
                    var turno = horario.turno.charAt(0).toUpperCase()+horario.turno.slice(1);

                    var botones = "";
                    if(horario.fecha >= fecha_hoy){
                        botones += "<a href='editar-horario.php?id="+horario.id_disponibilidad+"' class='btn boton-cuadrado-editar btn-form mb-3'>Editar</a> ";
                    }
                    botones += "<button class='btn boton-cuadrado-eliminar btn-form' onclick='eliminarHorario("+horario.id_disponibilidad+")'>Eliminar</button>";

                    tabla += "<tr><td colspan='5'><hr></td></tr>";
                    tabla += "<tr style='color: #1D4635;'>"+
                                "<td>"+fecha_formato+"</td>"+
                                "<td>"+turno+"</td>"+
                                "<td>"+hora_inicio+"</td>"+
                                "<td>"+hora_fin+"</td>"+
                                "<td>"+botones+"</td>"+
                             "</tr>";
                });
            }
            tabla += "</tbody>";
            tabla += "</table>";
            tabla += "</div>";

            document.getElementById("tabla-horarios").innerHTML = tabla;

            var botones_paginacion = "";
            for(var i = 1; i <= respuesta.total_paginas; i++){
                botones_paginacion += "<button class='btn btn-sm boton-pagina mr-1' onclick='mostrarHorarios("+i+")'>"+i+"</button>";
            }
            document.getElementById("paginacion-horarios").innerHTML = botones_paginacion;
        }
    };
    peticion.send();
}

//FUNCIÓN PARA ELIMINAR EL HORARIO
function eliminarHorario(id){
    var peticion = crearObjetoPeticion();

    if(!peticion){
        return;
    }

    peticion.open("GET", "../../controladores/eliminar-horario.php?id="+id, true);

    peticion.onreadystatechange = function(){
        if(peticion.readyState === 4 && peticion.status === 200){
            var respuesta = JSON.parse(peticion.responseText);
            var div_mensaje = document.getElementById("mensaje-horarios");

            if(respuesta.eliminado){
                div_mensaje.innerHTML = "<p style='color: green;'>"+respuesta.eliminado_error+"</p>";
                mostrarHorarios();
            }else{
                div_mensaje.innerHTML = "<p style='color: red;'>"+respuesta.eliminado_error+"</p>";
            }
        }
    };
    peticion.send();
}

//EVENTOS Y FUNCIONES DE LOS FILTROS
document.getElementById("filtro-fecha-ver-horarios").addEventListener("change", function(){
    mostrarHorarios();
});

document.getElementById("filtro-turno-ver-horarios").addEventListener("change", function(){
    mostrarHorarios();
});

document.addEventListener("DOMContentLoaded", function(){
    mostrarHorarios();
});