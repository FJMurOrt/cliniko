//FUNCION PARA CREAR OBJETO AJAX
function crearObjetoPeticion(){
    var peticion_objeto = false;
    try{
        peticion_objeto = new XMLHttpRequest();
    }catch(error_1){
        try{
            peticion_objeto = new ActiveXObject("Msxml2.XMLHTTP");
        }catch(error_2){
            try{
                peticion_objeto = new ActiveXObject("Microsoft.XMLHTTP");
            }catch(error_3){
                peticion_objeto = false;
            }
        }
    }
    return peticion_objeto;
}

//FUNCION PARA MOSTRAR LA DISPONIBILIDAD
function mostrarDisponibilidad(pagina){
    //LA PÁGINA POR DEFECTO DE LA FUNCIÓN SERÁ LA PRIMERA
    if(pagina == null){
        pagina = 1;
    }

    var fecha = document.getElementById("filtro-fecha").value;
    var id_medico = document.getElementById("id-medico").value;
    var peticion = crearObjetoPeticion();

    if(!peticion){
        return;
    }

    var url = "../../controladores/ajax-disponibilidad-medico.php?id_medico="+id_medico+"&pagina="+pagina;

    if(fecha !== ""){
        url += "&fecha="+fecha;
    }

    peticion.open("GET", url, true);
    peticion.onreadystatechange = function(){
        if(peticion.readyState === 4 && peticion.status === 200){
            var respuesta = JSON.parse(peticion.responseText);
            var tabla = "<div class='table-responsive'>"+
                "<table class='table table-borderless'>"+
                "<thead>"+
                "<tr>"+
                "<th>Fecha</th>"+
                "<th>Turno</th>"+
                "<th>Hora inicio</th>"+
                "<th>Hora fin</th>"+
                "</tr>"+
                "</thead>"+
                "<tbody>";

            if(respuesta.disponibilidad.length === 0){
                tabla += "<tr>"+
                         "<td colspan='4' class='text-center'>No existe ninguna disponibilidad para esta fecha.</td>"+
                         "</tr>";
            }

            respuesta.disponibilidad.forEach(function(dispo){
                var fecha = new Date(dispo.fecha);
                var fecha_formateada =
                    ("0"+fecha.getDate()).slice(-2)+"/"+
                    ("0"+(fecha.getMonth()+1)).slice(-2)+"/"+
                    fecha.getFullYear();

                tabla += "<tr>"+
                        "<td>"+fecha_formateada+"</td>"+
                        "<td>"+dispo.turno.charAt(0).toUpperCase()+dispo.turno.slice(1)+"</td>"+
                        "<td>"+dispo.hora_inicio.substring(0,5)+"</td>"+
                        "<td>"+dispo.hora_fin.substring(0,5)+"</td>"+
                        "</tr>";
            });

            tabla += "</tbody></table></div>";
            document.getElementById("tabla-disponibilidad").innerHTML = tabla;

            //PAGINACION
            var botones = "";
            for(var i=1;i<=respuesta.total_paginas;i++){
                botones += "<button class='btn btn-sm boton-pagina mr-1' "+"onclick='mostrarDisponibilidad("+i+")'>"+i+"</button>";
            }
            document.getElementById("paginacion-disponibilidad").innerHTML = botones;
        }
    };
    peticion.send();
}

function verTodasDisponibilidades(){
    document.getElementById("filtro-fecha").value = "";
    mostrarDisponibilidad();
}

//CARGAR DATOS AL ABRIR PAGINA
document.addEventListener("DOMContentLoaded", function(){
    mostrarDisponibilidad();
});