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

//FUNCIÓN PARA PODER DESCARGAR EL PDF DE TODOS LOS HISTORIALES
function descargarInformeHistoriales(){
    var peticion = crearObjetoPeticion();

    if(!peticion){
        return;
    }

    peticion.open("GET", "../../controladores/informe-historiales.php", true);

    peticion.onreadystatechange = function(){
        if(peticion.readyState === 4 && peticion.status === 200){
            var historiales = JSON.parse(peticion.responseText);

            var documento_pdf = new PDF24Doc();
            documento_pdf.setCharset("UTF-8");
            documento_pdf.setFilename("Informe_Historiales_Cliniko");
            documento_pdf.setPageSize(210, 297);

            var contenido_pdf = new PDF24Element();
            contenido_pdf.setTitle("Clíniko - Informe de Historiales");
            contenido_pdf.setAuthor("Clíniko");

            var la_informacion_que_genero = "<div style='margin: 20px; font-family: Roboto, sans-serif;'>";
            la_informacion_que_genero += "<h2 style='text-align: center; color: #01497C;'>Informe de Historiales Médicos</h2>";
            la_informacion_que_genero += "<table border='1' style='border-color: #01497C; border-collapse: collapse;' cellpadding='5' width='100%'>";
            la_informacion_que_genero += "<thead>";
            la_informacion_que_genero += "<tr style='background-color: #01497C; color: white;'>";
            la_informacion_que_genero += "<th>Paciente</th>";
            la_informacion_que_genero += "<th>Médico</th>";
            la_informacion_que_genero += "<th>Fecha de la subida</th>";
            la_informacion_que_genero += "<th>Archivo</th>";
            la_informacion_que_genero += "</tr>";
            la_informacion_que_genero += "</thead>";
            la_informacion_que_genero += "<tbody>";

            historiales.forEach(function(h){
                //FORMATEO DE LA FECHA
                var partes = h.fecha_registro.split(" ")[0].split("-");
                var fecha = partes[2]+"/"+partes[1]+"/"+partes[0];

                la_informacion_que_genero += "<tr>";
                la_informacion_que_genero += "<td style='border: 1px solid #01497C;'>"+h.nombre_paciente+" "+h.apellidos_paciente+"</td>";
                la_informacion_que_genero += "<td style='border: 1px solid #01497C;'>"+h.nombre_medico+" "+h.apellidos_medico+"</td>";
                la_informacion_que_genero += "<td style='border: 1px solid #01497C;'>"+fecha+"</td>";
                la_informacion_que_genero += "<td style='border: 1px solid #01497C;'>"+h.archivo_pdf+"</td>";
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