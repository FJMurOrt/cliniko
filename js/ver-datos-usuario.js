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

//FUNCIÓN PARA CARGAR MÁS INFORMACIÓN DEL USUARIO QUE SE HAYA SELECCIONADO
function verMasDatosUsuario(){
    var id_usuario = document.getElementById("id-usuario").value;

    var peticion = crearObjetoPeticion();

    if(!peticion){
       return; 
    }

    peticion.open("GET", "../../controladores/ajax-ver-usuario.php?id_usuario="+id_usuario, true);

    peticion.onreadystatechange = function(){
        if(peticion.readyState === 4 && peticion.status === 200){
            var usuario = JSON.parse(peticion.responseText);

            var foto = "../../../uploads/perfiles/por_defecto.png";
            if(usuario.foto_perfil){
               foto = "../../../uploads/perfiles/"+usuario.foto_perfil; 
            }

            //TEXTO DE SI ESTÁ O NO ESTÁ HABILITADO
            var habilitado = usuario.habilitado;

            //PONGO OTRA VEZ EL TIPO DE USUARIO CON LA PRIMERA EN MAYÚSCULA
            var rol = usuario.rol.charAt(0).toUpperCase()+usuario.rol.slice(1);

            //FORMATEO LA FECHA DE NUEVO DEL REGISTRO AL FORMATO ESPAÑOL
            var partes_registro = usuario.fecha_registro.split(" ")[0].split("-");
            var fecha_registro = partes_registro[2]+"/"+partes_registro[1]+"/"+partes_registro[0];

            var mas_datos_usuario = "";
            mas_datos_usuario += "<div class='text-center mb-4'>";
            mas_datos_usuario += "<img src='"+foto+"' class='img-fluid rounded-circle foto-usuario-habilitar' style='width:120px;height:120px;object-fit:cover;'>";
            mas_datos_usuario += "<h4 class='mt-3 etiqueta-filtro d-inline-block ml-2'>"+usuario.nombre+" "+usuario.apellidos+"</h4>";
            mas_datos_usuario += "<hr>";
            mas_datos_usuario += "</div>";
            mas_datos_usuario += "<p class='info-paciente-contenido'><span class='tipo_usuario'>Correo:</span>"+usuario.correo+"</p>";
            mas_datos_usuario += "<p class='info-paciente-contenido'><span class='tipo_usuario'>Teléfono:</span>"+usuario.telefono+"</p>";
            mas_datos_usuario += "<p class='info-paciente-contenido'><span class='tipo_usuario'>Tipo de Usuario:</span>"+rol+"</p>";
            mas_datos_usuario += "<p class='info-paciente-contenido'><span class='tipo_usuario'>Habilitado:</span>"+habilitado+"</p>";
            mas_datos_usuario += "<p class='info-paciente-contenido'><span class='tipo_usuario'>Fecha de Registro:</span>"+fecha_registro+"</p>";

            //COMO LOS DOS ROLES O TIPOS DE USUARIOS NO TIENEN LOS MISMOS DATOS, DEPENDIENDO SI ES MEDICO O PACIENTE AL QUE ESTAMOS VIENDO, MUESTRO UNOS CAMPOS U OTROS
            //SI EL USUARIO ES TIPO PACIENTE
            if(usuario.rol === "paciente"){
                if(usuario.fecha_nacimiento){
                    //FORMATEO LA FECHA DE NACIMIENTO IGUAL QUE LA DEL REGISTRO
                    var partes_nac = usuario.fecha_nacimiento.split("-");
                    var fecha_nac = partes_nac[2]+"/"+partes_nac[1]+"/"+partes_nac[0];
                    mas_datos_usuario += "<p class='info-paciente-contenido'><span class='tipo_usuario'>Fecha de Nacimiento:</span>"+fecha_nac+"</p>";
                }
                if(usuario.direccion) mas_datos_usuario += "<p class='info-paciente-contenido'><span class='tipo_usuario'>Domicilio:</span>"+usuario.direccion+"</p>";
                if(usuario.nss) mas_datos_usuario += "<p class='info-paciente-contenido'><span class='tipo_usuario'>Número de la Seguridad Social (NSS):</span>"+usuario.nss+"</p>";
            }

            //SIN EMBARGO, SI EL USUARIO ES TIPO MÉDICO
            if(usuario.rol === "medico"){
                if(usuario.numero_colegiado) mas_datos_usuario += "<p class='info-paciente-contenido'><span class='tipo_usuario'>Número de Colegiado:</span>"+usuario.numero_colegiado+"</p>";
                if(usuario.especialidad) mas_datos_usuario += "<p class='info-paciente-contenido'><span class='tipo_usuario'>Especialidad:</span>"+usuario.especialidad+"</p>";
            }
            document.getElementById("contenedor-datos-usuario").innerHTML = mas_datos_usuario;
        }
    };
    peticion.send();
}

//EVENTO Y FUNCIÓN PARA CUANDO CARGA EL DOM
document.addEventListener("DOMContentLoaded", function(){
    verMasDatosUsuario();
});