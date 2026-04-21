//FUNCIÓN PARA CREAR EL OBJETO DE LA PETICIÓN
function crearObjetoPeticion(){
    var objeto = false;
    try{
        objeto = new XMLHttpRequest();
    }catch(error_1){
        try{
            objeto = new ActiveXObject("Msxml2.XMLHTTP");
        }catch(error_2){
            try{
                objeto = new ActiveXObject("Microsoft.XMLHTTP");
            }catch(error_3){
                objeto = false;
            }
        }
    }
    return objeto;
}

//FUNCIÓN PARA CARGAR LAS ESPECIALIDADES
function cargarEspecialidadesVerMedicos(){
    var peticion = crearObjetoPeticion();
    if(!peticion){
        return;
    }

    peticion.open("GET", "../../controladores/ajax-especialidades.php", true);
    peticion.onreadystatechange = function(){
        if(peticion.readyState === 4 && peticion.status === 200){
            var especialidades = JSON.parse(peticion.responseText);

            var select = document.getElementById("filtro-especialidad-ver-medicos");
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

//FUNCIÓN PARA MOSTRAR LOS MEDICOS
function mostrarTablaMedicos(pagina){
    //LA PÁGINA POR DEFECTO DE LA FUNCIÓN SERÁ LA PRIMERA
    if(pagina == null){
        pagina = 1;
    }

    var filtro = document.getElementById("filtro-especialidad-ver-medicos").value;
    var orden = document.getElementById("orden-nombre").value;

    var peticion = crearObjetoPeticion();
    if(!peticion){
        alert("El navegador no es compatible con AJAX");
        return;
    }

    var url = "../../controladores/ajax-lista-medicos.php?pagina="+pagina;
    if(filtro !== ""){
        url += "&especialidad="+filtro;
    }

    if(orden !== ""){
        url += "&orden="+orden;
    }

    peticion.open("GET", url, true);

    peticion.onreadystatechange = function(){
        if(peticion.readyState === 4 && peticion.status === 200){
            var respuesta = JSON.parse(peticion.responseText);
            var el_div_de_la_tabla_en_el_html = document.getElementById("tabla-medicos");

            if(respuesta.medicos.length === 0){
                el_div_de_la_tabla_en_el_html.innerHTML = "<p style='text-align:center;'>No hay médicos disponibles para esta especialidad.</p>";
            }else{
                var tabla = "<div class='table-responsive'>"+
                    "<table class='table table-borderless'>"+
                        "<thead>"+
                            "<tr>"+
                                "<th>Nombre</th>"+
                                "<th>Especialidad</th>"+
                            "</tr>"+
                        "</thead>"+
                        "<tbody>";

                respuesta.medicos.forEach(function(medico){
                    var especialidad;
                    if(medico.especialidad){
                        especialidad = medico.especialidad;
                    }else{
                        especialidad = "No especificada";
                    }

                    tabla += "<tr>"+
                                "<td>"+
                                    "<a class='enlace-medico' href='info-medico.php?id="+medico.id_usuario+"'>"+
                                        medico.nombre+" "+medico.apellidos+
                                    "</a>"+
                                "</td>"+
                                "<td><span class='espe-tabla'>"+especialidad+"</span></td>"+
                             "</tr>";
                });

                tabla += "</tbody></table></div>";
                el_div_de_la_tabla_en_el_html.innerHTML = tabla;
            }
            
            var botones = "";
            for(var i = 1; i <= respuesta.total_paginas; i++){
                botones += "<button class='btn btn-sm boton-pagina mr-1' onclick='mostrarTablaMedicos("+i+")'>"+i+"</button>";
            }
            document.getElementById("paginacion").innerHTML = botones;
        }
    };
    peticion.send();
}

document.getElementById("filtro-especialidad-ver-medicos").addEventListener("change", function(){
    mostrarTablaMedicos();
});

document.addEventListener("DOMContentLoaded", function(){
    cargarEspecialidadesVerMedicos();
    mostrarTablaMedicos();
});

document.getElementById("orden-nombre").addEventListener("change", function(){
    mostrarTablaMedicos();
});