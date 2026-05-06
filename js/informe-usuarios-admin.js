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

//FUNCUIÓN PARA EL PDF DE LA LISTA DE USUARIOS
function descargarInformeUsuarios(){
    var peticion = crearObjetoPeticion();

    if(!peticion){
        return;
    }

    peticion.open("GET", "../../controladores/informe-usuarios.php", true);

    peticion.onreadystatechange = function(){
        if(peticion.readyState === 4 && peticion.status === 200){
            var usuarios = JSON.parse(peticion.responseText);

            var documento_pdf = new PDF24Doc();
            documento_pdf.setCharset("UTF-8");
            documento_pdf.setFilename("Informe_Usuarios_Cliniko");
            documento_pdf.setPageSize(210, 297);

            var contenido_pdf = new PDF24Element();
            contenido_pdf.setTitle("Clíniko - Informe de Usuarios");
            contenido_pdf.setAuthor("Clíniko");

            var la_informacion_que_genero = "<div style='margin: 20px; font-family: Roboto, sans-serif;'>";
            la_informacion_que_genero += "<h2 style='text-align: center; color: #01497C;'>Informe de Usuarios</h2>";
            la_informacion_que_genero += "<table border='1' style='border-color: #01497C; border-collapse: collapse;' cellpadding='5' width='100%'>";
            la_informacion_que_genero += "<thead>";
            la_informacion_que_genero += "<tr style='background-color: #01497C; color: white;'>";
            la_informacion_que_genero += "<th>Nombre</th>";
            la_informacion_que_genero += "<th>Apellidos</th>";
            la_informacion_que_genero += "<th>Correo</th>";
            la_informacion_que_genero += "<th>Teléfono</th>";
            la_informacion_que_genero += "<th>Tipo de Usuario</th>";
            la_informacion_que_genero += "<th>Habilitado</th>";
            la_informacion_que_genero += "<th>Fecha de registro</th>";
            la_informacion_que_genero += "</tr>";
            la_informacion_que_genero += "</thead>";
            la_informacion_que_genero += "<tbody>";

            usuarios.forEach(function(usuario){
                //FORMATEO DE LA FECHA AL FORMATO TÍPICO ESPAÑOL
                var partes = usuario.fecha_registro.split(" ")[0].split("-");
                var fecha = partes[2]+"/"+partes[1]+"/"+partes[0];
                var habilitado = usuario.habilitado === "si" ? "Sí" : "No";
                var tipo_de_usuario = usuario.rol.charAt(0).toUpperCase() + usuario.rol.slice(1);

                la_informacion_que_genero += "<tr>";
                la_informacion_que_genero += "<td style='border: 1px solid #01497C;'>"+usuario.nombre+"</td>";
                la_informacion_que_genero += "<td style='border: 1px solid #01497C;'>"+usuario.apellidos+"</td>";
                la_informacion_que_genero += "<td style='border: 1px solid #01497C;'>"+usuario.correo+"</td>";
                la_informacion_que_genero += "<td style='border: 1px solid #01497C;'>"+usuario.telefono+"</td>";
                la_informacion_que_genero += "<td style='border: 1px solid #01497C;'>"+tipo_de_usuario+"</td>";
                la_informacion_que_genero += "<td style='border: 1px solid #01497C;'>"+habilitado+"</td>";
                la_informacion_que_genero += "<td style='border: 1px solid #01497C;'>"+fecha+"</td>";
                la_informacion_que_genero += "</tr>";
            });

            la_informacion_que_genero += "</tbody></table></div>";

            contenido_pdf.setBody(la_informacion_que_genero);
            documento_pdf.addElement(contenido_pdf);
            documento_pdf.create();
        }
    };
    peticion.send();
}