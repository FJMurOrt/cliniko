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
function cargarEspecialidadesCitas(){
    var peticion = crearObjetoPeticion();

    if(!peticion){ 
        alert("El navegador no es compatible con AJAX"); 
        return; 
    }

    peticion.open("GET", "../../controladores/ajax-especialidades.php", true);

    peticion.onreadystatechange = function(){
        if(peticion.readyState === 4 && peticion.status === 200){
            var especialidades = JSON.parse(peticion.responseText);

            var select = document.getElementById("filtro-especialidad-citas");
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
function mostrarMedicosCitas(pagina){
    //LA PÁGINA POR DEFECTO DE LA FUNCIÓN SERÁ LA PRIMERA
    if(pagina == null){
        pagina = 1;
    }

    var filtro = document.getElementById("filtro-especialidad-citas").value;
    var orden = document.getElementById("orden-nombre-medico").value;

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
            
            var contenedor_donde_meto_la_tabla = document.getElementById("tabla-medicos-citas");

            if(respuesta.medicos.length === 0){
                contenedor_donde_meto_la_tabla.innerHTML = "<p style='text-align:center;'>No hay médicos disponibles.</p>";
            }else{
                var tabla = "<div class='table-responsive'>"+
                    "<table class='table table-borderless' id='tabla-medicos-citas-tabla'>"+
                        "<thead>"+
                            "<tr>"+
                                "<th>Nombre</th>"+
                                "<th>Especialidad</th>"+
                                "<th>¿Deseas solicitar una cita?</th>"+
                            "</tr>"+
                        "</thead>"+
                        "<tbody id='tabla-medicos-citas-body'>";

                respuesta.medicos.forEach(function(medico){
                    var especialidad = "No especificada";
                    if(medico.especialidad){
                        especialidad = medico.especialidad;
                    }

                    tabla += "<tr>"+
                                "<td>"+
                                    "<a class='enlace-medico' href='info-medico.php?id="+medico.id_usuario+"'>"+
                                        medico.nombre+" "+medico.apellidos+
                                    "</a>"+
                                "</td>"+
                                "<td><span class='espe-tabla'>"+especialidad+"</span></td>"+
                                "<td>"+
                                    "<a class='btn boton-solicitar' href='solicitar-cita.php?id_medico="+medico.id_usuario+"'>Solicitar</a>"+
                                "</td>"+
                             "</tr>";
                });
                tabla += "</tbody></table></div>";
                contenedor_donde_meto_la_tabla.innerHTML = tabla;
            }

            var botones = "";
            for(var i = 1; i <= respuesta.total_paginas; i++){
                botones += "<button class='btn btn-sm boton-pagina mr-1' onclick='mostrarMedicosCitas("+i+")'>"+i+"</button>";
            }
            document.getElementById("paginacion-citas").innerHTML = botones;
        }
    };
    peticion.send();
}

document.getElementById("filtro-especialidad-citas").addEventListener("change", function(){
    mostrarMedicosCitas();
});

document.addEventListener("DOMContentLoaded", function(){
    cargarEspecialidadesCitas();
    mostrarMedicosCitas();
});

document.getElementById("orden-nombre-medico").addEventListener("change", function(){
    mostrarMedicosCitas();
});