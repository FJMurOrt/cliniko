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

//FUNCIÓN PARA MOSTRAR A LOS USUARIOS QUE HAYA QUE HABILITAR
function mostrarUsuarios(pagina){
    if(pagina == null){
      pagina = 1;
    }

    var peticion = crearObjetoPeticion();

    if(!peticion){
      return;  
    }

    //LOS ELEMENTOS A LOS QUE ACCEDOR CON POR EL ID DEL HTML PARA LOS FILTROS
    var busqueda = document.getElementById("filtro-busqueda-usuarios").value.trim();
    var tipo_de_usuario = document.getElementById("filtro-rol-usuarios").value;
    var fecha = document.getElementById("filtro-fecha-registro").value;
    var estado = document.getElementById("filtro-estado-usuarios").value;

    var url = "../../controladores/ajax-nuevos-usuarios.php?pagina="+pagina;

    //FILTROS QUE AÑADO A LA URL
    if(busqueda){
        url += "&busqueda="+encodeURIComponent(busqueda);
    }

    if(tipo_de_usuario){
        url += "&tipo_de_usuario="+tipo_de_usuario;
    }

    if(fecha){
        url += "&fecha="+fecha;
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
                lista_de_usuarios = "<div class='col-12 text-center' style='color: #2C2C3E;'><p>No hay usuarios nuevos pendientes por habilitar.</p></div>";
            }else{
                respuesta.usuarios.forEach(function(usuario){
                    //SI TIENE FOTO, LA MUUESTRO
                    var foto = "../../../uploads/perfiles/por_defecto.png";
                    if(usuario.foto_perfil){
                        foto = "../../../uploads/perfiles/"+usuario.foto_perfil;
                    }

                    //FORMATEO LA FECHA EN EL ORDEN ESPAÑOL
                    var partes_fecha = usuario.fecha_registro.split(" ")[0].split("-");
                    var fecha = partes_fecha[2]+"/"+partes_fecha[1]+"/"+partes_fecha[0];

                    //PONGO LA PRIMERA LETRA DEL TIPO DE USUARIO QEU SEA EN MAYUSCULA
                    var tipo_usuario_con_mayuscula = usuario.rol.charAt(0).toUpperCase()+usuario.rol.slice(1);

                    //DEPENEDE DE SI ESTA O NO HABILITADO EL USUARIO, LE PONGO UN ESTILO.
                    var habilitado = "";
                    if(usuario.habilitado === "si"){
                        habilitado = "<b class='estado_habilitado'>Habilitado</b>";
                    }else{
                        habilitado = "<b class='estado_no_habilitado'>No habilitado</b>";
                    }

                    var boton_habilitar = "";
                    if(usuario.habilitado === "no"){
                        boton_habilitar = "<button class='btn boton-cuadrado mb-2' onclick='habilitarUsuario("+usuario.id_usuario+")'>Habilitar</button>";
                    }

                    //Y AQUÍ YA CONSTRUYO CADA UNA DE LAS TARJETITIAS QEU SERÍA CADA USUARIO
                    lista_de_usuarios +=
                    "<div class='col-12 mb-4' id='tarjeta-usuario-"+usuario.id_usuario+"'>"+
                        "<div class='card tarjeta-usuario-nuevo'>"+
                            "<div class='card-body'>"+
                                "<div class='row align-items-center'>"+
                                    "<div class='col-md-2 text-center'>"+
                                        "<img src='"+foto+"' class='img-fluid rounded-circle foto-usuario-habilitar' style='width:80px;height:80px;object-fit:cover;'>"+
                                    "</div>"+
                                    "<div class='col-md-6'>"+
                                        "<h5 class='mb-1 etiqueta-filtro d-inline-block' style='max-width: 100%;'>"+usuario.nombre+" "+usuario.apellidos+"</h5>"+
                                        "<p class='mt-2'><span class='tipo_usuario'>"+tipo_usuario_con_mayuscula+"</span></p>"+
                                        "<p class='mb-0'>Correo electrónico: "+usuario.correo+"</p>"+
                                        "<p class='mb-0'>Teléfono: "+usuario.telefono+"</p>"+
                                        "<p class='mt-2'>Estado: <span id='estado-usuario-"+usuario.id_usuario+"'>"+habilitado+"</span></p>"+
                                        "<p class='mt-3'>Fecha de registro: "+fecha+"</p>"+
                                    "</div>"+
                                    "<div class='col-md-4 text-md-end text-center mt-3 mt-md-0 d-flex flex-column align-items-center'>"+
                                        boton_habilitar+
                                        "<a href='ver-usuario.php?id="+usuario.id_usuario+"' class='btn boton-cuadrado'>Más datos</a>"+
                                        "<button class='btn boton-cuadrado-eliminar mt-2' onclick='abrirModalEliminarUsuario("+usuario.id_usuario+")'>Eliminar</button>"+
                                    "</div>"+
                                "</div>"+
                            "</div>"+
                        "</div>"+
                    "</div>";
                });
            }

            document.getElementById("contenedor-de-usuarios-nuevos").innerHTML = lista_de_usuarios;

            //LOS BOTONES PARA CAMBIAR DE PÁGINA
            var botones = "";
            for(var i = 1; i <= respuesta.total_paginas; i++){
                botones += "<button class='btn btn-sm boton-pagina mr-1' onclick='mostrarUsuarios("+i+")'>"+i+"</button>";
            }
            document.getElementById("paginacion-usuarios").innerHTML = botones;
        }
    };
    peticion.send();
}

//FUNCIÓN PARA ABRIR EL MODAL AL ELIMINAR UN USUARIO
function abrirModalEliminarUsuario(id_usuario){
    document.getElementById("id-usuario-eliminar").value = id_usuario;
    $("#modal-eliminar-usuario").modal("show");
}

//FUNCIÓN PARA ELIMINAR UN USUARIO
function eliminarUsuario(){
    var id_usuario = document.getElementById("id-usuario-eliminar").value;

    var peticion = crearObjetoPeticion();
    if(!peticion){
       return; 
    }

    peticion.open("GET", "../../controladores/ajax-eliminar-usuario-admin.php?id_usuario="+id_usuario, true);

    peticion.onreadystatechange = function(){
        if(peticion.readyState === 4 && peticion.status === 200){
            var respuesta = JSON.parse(peticion.responseText);
            if(respuesta.eliminado){
                $("#modal-eliminar-usuario").modal("hide");
                document.getElementById("mensaje-habilitar").innerHTML = "<p style='color: green;'>El usuario fue eliminado correctamente.</p>";
                mostrarUsuarios();
            }else{
                document.getElementById("mensaje-habilitar").innerHTML = "<p style='color: red;'>Hubo un error al intentar eliminar el usuario.</p>";
            }
        }
    };
    peticion.send();
}

//FUNCIÓN PARA HABILTIAR EL USUARIO
function habilitarUsuario(id_usuario){
    var peticion = crearObjetoPeticion();

    if(!peticion){
       return; 
    }

    peticion.open("GET", "../../controladores/ajax-habilitar-usuario.php?id_usuario="+id_usuario, true);

    peticion.onreadystatechange = function(){
        if(peticion.readyState === 4 && peticion.status === 200){
            var respuesta = JSON.parse(peticion.responseText);
            if(respuesta.usuario_habilitado){
                document.getElementById("mensaje-habilitar").innerHTML = "<p style='color: green;'>El usuario se habilitó correctamente.</p>";
                document.getElementById("estado-usuario-"+id_usuario).innerHTML = "<b style='color: green;'>Habilitado</b>";
            }
        }
    };
    peticion.send();
}

//EVENTOS Y FUNCIONES DE LOS FILTROS Y DEL DOM
document.getElementById("filtro-busqueda-usuarios").addEventListener("input", function(){
    mostrarUsuarios();
});

document.getElementById("filtro-rol-usuarios").addEventListener("change", function(){
    mostrarUsuarios();
});

document.getElementById("filtro-fecha-registro").addEventListener("change", function(){
    mostrarUsuarios();
});

document.getElementById("filtro-estado-usuarios").addEventListener("change", function(){
    mostrarUsuarios();
});

document.addEventListener("DOMContentLoaded", function(){
    mostrarUsuarios();
});