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

//FUNCIÓN PARA MOSTRAR LA LISTA DE LOS USUARIOS A LOS QUE SE LES PUEDE ENVIAR UN MENSAJE
function mostrarUsuariosEnviarCorreo(pagina){
    if(!pagina){
        pagina = 1;
    }

    var peticion = crearObjetoPeticion();
    if(!peticion){
        return;
    }

    //FILTROS
    var busqueda = document.getElementById("filtro-busqueda-enviar").value.trim();
    var rol = document.getElementById("filtro-rol-enviar").value;
    var fecha = document.getElementById("filtro-fecha-enviar").value;
    var estado = document.getElementById("filtro-estado-enviar").value;

    var url = "../../controladores/ajax-enviar-usuario.php?pagina="+pagina;

    if(busqueda){
        url += "&busqueda="+encodeURIComponent(busqueda); 
    }
    if(rol){
        url += "&rol="+rol;
    }
    if(fecha){
        url += "&fecha="+fecha
    }
    if(estado){
        url += "&estado="+estado; 
    }

    peticion.open("GET", url, true);

    peticion.onreadystatechange = function(){
        if(peticion.readyState === 4 && peticion.status === 200){
            var respuesta = JSON.parse(peticion.responseText);
            var lista_de_usuarios = "";

            if(respuesta.usuarios.length === 0){
                lista_de_usuarios = "<div class='col-12 text-center' style='color: #2C2C3E;'><p>No se encontraron usuarios.</p></div>";
            }else{
                respuesta.usuarios.forEach(function(usuario){
                    var foto = "../../../uploads/perfiles/por_defecto.png";
                    if(usuario.foto_perfil){
                        foto = "../../../uploads/perfiles/"+usuario.foto_perfil;
                    }

                    //FORMATEO EL TIPO DE USUARIO PARA PONERLO EN MAYUSUCLA
                    var tipo_de_usuario = usuario.rol.charAt(0).toUpperCase() + usuario.rol.slice(1);

                    //SI ES HABILITADO O NO LO MUESTRO DE UN COLOR
                    var habilitado = "";
                    if(usuario.habilitado === "si"){
                        habilitado = "<span class='estado_habilitado'>Habilitado</span>";
                    }else{
                        habilitado = "<span class='estado_no_habilitado'>No habilitado</span>";
                    }

                    lista_de_usuarios +=
                        "<div class='col-12 mb-4'>"+
                            "<div class='card tarjeta-usuario-nuevo'>"+
                                "<div class='card-body'>"+
                                    "<div class='row align-items-center'>"+
                                        "<div class='col-md-2 text-center'>"+
                                            "<img src='"+foto+"' class='img-fluid rounded-circle foto-usuario-habilitar' style='width:80px;height:80px;object-fit:cover;'>"+
                                        "</div>"+
                                        "<div class='col-md-6'>"+
                                            "<div><h5 class='etiqueta-filtro mb-2 d-inline-block'>"+usuario.nombre+" "+usuario.apellidos+"</h5></div>"+
                                            "<div class='mb-3'><span class='tipo_usuario'>"+tipo_de_usuario+"</span></div>"+
                                            "<div>"+habilitado+"</div>"+
                                        "</div>"+
                                        "<div class='col-md-4 text-md-end text-center mt-3 mt-md-0 d-flex flex-column align-items-center'>"+
                                            "<button class='btn boton-cuadrado btn-form' onclick='abrirModalEnviar("+'"'+usuario.correo+'"'+")'>Enviar mensaje</button>"+
                                        "</div>"+
                                    "</div>"+
                                "</div>"+
                            "</div>"+
                        "</div>";
                });
            }

            document.getElementById("contenedor-usuarios-enviar").innerHTML = lista_de_usuarios;

            var botones = "";
            for(var i = 1; i <= respuesta.total_paginas; i++){
                botones += "<button class='btn btn-sm boton-pagina mr-1' onclick='mostrarUsuariosEnviarCorreo("+i+")'>"+i+"</button>";
            }
            document.getElementById("paginacion-usuarios-enviar").innerHTML = botones;
        }
    };
    peticion.send();
}

function abrirModalEnviar(correo){
    document.getElementById("correo-destinatario").value = correo;
    document.getElementById("asunto-usuario").value = "";
    document.getElementById("mensaje-usuario").value = "";
    document.getElementById("contador-mensaje-usuario").textContent = "0/1000";
    $("#modal-enviar-mensaje").modal("show");
}

function enviarMensajeUsuario(){
    var correo = document.getElementById("correo-destinatario").value;
    var asunto = document.getElementById("asunto-usuario").value.trim();
    var mensaje = document.getElementById("mensaje-usuario").value.trim();

    if(asunto === ""){
        document.getElementById("mensaje-enviar-usuario").innerHTML = "<p style='color: red;'>El asunto es obligatorio.</p>";
        return;
    }

    if(mensaje === ""){
        document.getElementById("mensaje-enviar-usuario").innerHTML = "<p style='color: red;'>El mensaje es obligatorio.</p>";
        return;
    }

    var peticion = crearObjetoPeticion();
    if(!peticion){
        return; 
    }

    peticion.open("POST", "../../controladores/ajax-enviar-usuario.php?loquesevaahacer=enviar", true);

    peticion.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    peticion.onreadystatechange = function(){
        if(peticion.readyState === 4 && peticion.status === 200){
            var respuesta = JSON.parse(peticion.responseText);
            if(respuesta.enviado){
                $("#modal-enviar-mensaje").modal("hide");
                document.getElementById("mensaje-enviar-usuario").innerHTML = "<p style='color: green;'>El mensaje fue enviado correctamente.</p>";
            }else{
                document.getElementById("mensaje-enviar-usuario").innerHTML = "<p style='color: red;'>"+respuesta.error+"</p>";
            }
        }
    };
    peticion.send("correo="+encodeURIComponent(correo)+"&asunto="+encodeURIComponent(asunto)+"&mensaje="+encodeURIComponent(mensaje));
}

document.getElementById("filtro-busqueda-enviar").addEventListener("input", function(){
    mostrarUsuariosEnviarCorreo();
});

document.getElementById("filtro-rol-enviar").addEventListener("change", function(){
    mostrarUsuariosEnviarCorreo();
});

document.getElementById("filtro-fecha-enviar").addEventListener("change", function(){
    mostrarUsuariosEnviarCorreo();
});

document.getElementById("filtro-estado-enviar").addEventListener("change", function(){
    mostrarUsuariosEnviarCorreo();
});

document.getElementById("mensaje-usuario").addEventListener("input", function(){
    document.getElementById("contador-mensaje-usuario").textContent = this.value.length+"/1000";
});

document.addEventListener("DOMContentLoaded", function(){
    mostrarUsuariosEnviarCorreo();
});