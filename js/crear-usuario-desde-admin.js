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

//FUNCIÓN PARA CARGAR LAS ESPECIALIDADES
function cargarEspecialidadesModal(){
    var peticion = crearObjetoPeticion();

    if(!peticion){
        return;
    }

    peticion.open("GET", "../../controladores/ajax-especialidades.php", true);
    peticion.onreadystatechange = function(){
        if(peticion.readyState === 4 && peticion.status === 200){
            var especialidades = JSON.parse(peticion.responseText);
            var select = document.getElementById("crear-especialidad");

            especialidades.forEach(function(especialidad){
                var opcion = document.createElement("option");
                opcion.value = especialidad.id_especialidad;
                opcion.textContent = especialidad.nombre;
                select.appendChild(opcion);
            });
        }
    };
    peticion.send();
}

//FUNCIÓN PARA ABRIR EL MODAL
function abrirModalCrearUsuario(){
    $("#modal-crear-usuario").modal("show");
}

//PARA MOSTRAR LOS CAMPOS OCULTOS
document.getElementById("crear-rol").addEventListener("change", function(){
    var rol = this.value;

    if(rol === "paciente"){
    document.getElementById("campos-paciente-modal").style.display = "block";
    }else{
        document.getElementById("campos-paciente-modal").style.display = "none";
    }

    if(rol === "medico"){
    document.getElementById("campos-medico-modal").style.display = "block";
    }else{
        document.getElementById("campos-medico-modal").style.display = "none";
    }
});

function crearUsuario(){
    //LIMPIO LOS SPANS DE LOS ERRORES ANTES DE VOLVER A VALIDAR PARA QUE NO SE ACUMULEN LOS ERRORES
    var errores_ids = ["error-crear-nombre","error-crear-apellidos","error-crear-correo","error-crear-correo2",
                       "error-crear-telefono","error-crear-contrasena","error-crear-contrasena2","error-crear-rol",
                       "error-crear-fecha","error-crear-direccion","error-crear-nss",
                       "error-crear-colegiado","error-crear-especialidad"];

    errores_ids.forEach(function(id){
        document.getElementById(id).innerHTML = "";
    });

    //VALIDACIONES DE LOS CAMPOS
    var nombre = document.getElementById("crear-nombre").value.trim();
    var apellidos = document.getElementById("crear-apellidos").value.trim();
    var correo = document.getElementById("crear-correo").value.trim();
    var correo2 = document.getElementById("crear-correo2").value.trim();
    var telefono = document.getElementById("crear-telefono").value.trim();
    var contrasena = document.getElementById("crear-contrasena").value;
    var contrasena2 = document.getElementById("crear-contrasena2").value;
    var rol = document.getElementById("crear-rol").value;

    //EXPRESIONES PARA VALIDAR ALGUNOS DE LOS CAMPOS
    var expresion_nombre = new RegExp("^[A-ZÑa-zñÁÉÍÓÚáéíóúÑñ]{1,20}(\\s[A-ZÑa-zñÁÉÍÓÚáéíóúÑñ]{1,20})?$");
    var expresion_correo = new RegExp("^[A-Za-z0-9._-]+@[A-Za-z0-9.-]+\\.[A-Za-z]{2,}$");
    var expresion_telefono = new RegExp("^[0-9]{9}$");
    var expresion_contrasena = new RegExp("^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[._-]).{8,}$");
    var expresion_colegiado = new RegExp("^[0-9]{9}$");
    var expresion_nss = new RegExp("^[0-9]{12}$");

    var hay_errores = false;

    //NOMBRE
    if(nombre === ""){
        document.getElementById("error-crear-nombre").innerHTML = "El nombre es obligatorio.";
        hay_errores = true;
    }else if(!expresion_nombre.test(nombre)){
        document.getElementById("error-crear-nombre").innerHTML = "El nombre solo puede tener 2 palabras y máximo 20 letras.";
        hay_errores = true;
    }

    //APELLIDOS
    if(apellidos === ""){
        document.getElementById("error-crear-apellidos").innerHTML = "Los apellidos son obligatorios.";
        hay_errores = true;
    }else if(!expresion_nombre.test(apellidos)){
        document.getElementById("error-crear-apellidos").innerHTML = "Los apellidos solo pueden tener 2 palabras y máximo 20 letras.";
        hay_errores = true;
    }

    //CORREO
    if(correo === ""){
        document.getElementById("error-crear-correo").innerHTML = "El correo es obligatorio.";
        hay_errores = true;
    }else if(!expresion_correo.test(correo)){
        document.getElementById("error-crear-correo").innerHTML = "El correo no tiene un formato válido.";
        hay_errores = true;
    }

    if(correo2 === ""){
        document.getElementById("error-crear-correo2").innerHTML = "Debes repetir el correo.";
        hay_errores = true;
    }else if(correo !== correo2){
        document.getElementById("error-crear-correo2").innerHTML = "Los correos no coinciden.";
        hay_errores = true;
    }

    //TELÉFONO
    if(telefono === ""){
        document.getElementById("error-crear-telefono").innerHTML = "El teléfono es obligatorio.";
        hay_errores = true;
    }else if(!expresion_telefono.test(telefono)){
        document.getElementById("error-crear-telefono").innerHTML = "El teléfono debe contener 9 números.";
        hay_errores = true;
    }

    //CONTRASEÑA
    if(contrasena === ""){
        document.getElementById("error-crear-contrasena").innerHTML = "La contraseña es obligatoria.";
        hay_errores = true;
    }else if(!expresion_contrasena.test(contrasena)){
        document.getElementById("error-crear-contrasena").innerHTML = "La contraseña debe tener mínimo 8 caracteres, mayúsculas, minúsculas, números y caracteres especiales.";
        hay_errores = true;
    }

    if(contrasena2 === ""){
        document.getElementById("error-crear-contrasena2").innerHTML = "Debes repetir la contraseña.";
        hay_errores = true;
    }else if(contrasena !== contrasena2){
        document.getElementById("error-crear-contrasena2").innerHTML = "Las contraseñas no coinciden.";
        hay_errores = true;
    }

    //TIPO DE USUARIO QUE SE ELEIGE
    if(rol === ""){
        document.getElementById("error-crear-rol").innerHTML = "El tipo de usuario es obligatorio.";
        hay_errores = true;
    }

    //CAMPOS DEL PACIENTE
    var fecha = "";
    var direccion = "";
    var nss = "";

    if(rol === "paciente"){
        fecha = document.getElementById("crear-fecha").value;
        direccion = document.getElementById("crear-direccion").value.trim();
        nss = document.getElementById("crear-nss").value.trim();

        if(fecha === ""){
            document.getElementById("error-crear-fecha").innerHTML = "La fecha de nacimiento es obligatoria.";
            hay_errores = true;
        }else{
            var hoy = new Date();
            var fechaNac = new Date(fecha);
            var edad = hoy.getFullYear() - fechaNac.getFullYear();
            var mes = hoy.getMonth() - fechaNac.getMonth();
            if(mes < 0 || (mes === 0 && hoy.getDate() < fechaNac.getDate())){
                edad--;
            }
            if(edad < 18){
                document.getElementById("error-crear-fecha").innerHTML = "El usuario debe tener al menos 18 años.";
                hay_errores = true;
            }
        }

        if(direccion === ""){
            document.getElementById("error-crear-direccion").innerHTML = "La dirección es obligatoria.";
            hay_errores = true;
        }

        if(nss !== "" && !expresion_nss.test(nss)){
            document.getElementById("error-crear-nss").innerHTML = "El NSS debe tener exactamente 12 dígitos.";
            hay_errores = true;
        }
    }

    //CAMPOS DEL MÉDICO
    var colegiado = "";
    var especialidad = "";
    if(rol === "medico"){
        colegiado = document.getElementById("crear-colegiado").value.trim();
        especialidad = document.getElementById("crear-especialidad").value;

        if(colegiado === ""){
            document.getElementById("error-crear-colegiado").innerHTML = "El número de colegiado es obligatorio.";
            hay_errores = true;
        }else if(!expresion_colegiado.test(colegiado)){
            document.getElementById("error-crear-colegiado").innerHTML = "El número de colegiado debe tener 9 dígitos.";
            hay_errores = true;
        }

        if(especialidad === ""){
            document.getElementById("error-crear-especialidad").innerHTML = "La especialidad es obligatoria.";
            hay_errores = true;
        }
    }

    if(hay_errores){
        return;
    }

    var valores_de_los_campos = "nombre="+encodeURIComponent(nombre)+"&apellidos="+encodeURIComponent(apellidos)+
                                "&correo="+encodeURIComponent(correo)+"&correo2="+encodeURIComponent(correo2)+
                                "&telefono="+encodeURIComponent(telefono)+"&contrasena="+encodeURIComponent(contrasena)+
                                "&contrasena2="+encodeURIComponent(contrasena2)+"&rol="+encodeURIComponent(rol);

    if(rol === "paciente"){
        valores_de_los_campos += "&fecha_nacimiento="+encodeURIComponent(fecha)+"&direccion="+encodeURIComponent(direccion)+
                                 "&nss="+encodeURIComponent(nss);
    }

    if(rol === "medico"){
        valores_de_los_campos += "&numero_colegiado="+encodeURIComponent(colegiado)+
                                 "&id_especialidad="+encodeURIComponent(especialidad);
    }

    var peticion = crearObjetoPeticion();

    if(!peticion){
        return;
    }

    peticion.open("POST", "../../controladores/ajax-crear-usuario.php", true);
    peticion.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    peticion.onreadystatechange = function(){
        if(peticion.readyState === 4 && peticion.status === 200){
            var respuesta = JSON.parse(peticion.responseText);
            if(respuesta.creacion_usuario_ok){
                document.getElementById("mensaje-crear-usuario").innerHTML = "<p style='color: green;'>El usuario se creó correctamente.</p>";
                $("#modal-crear-usuario").modal("hide");
                mostrarUsuariosNuevos();
            }else{
                document.getElementById("mensaje-crear-usuario").innerHTML = "<p style='color: red;'>"+respuesta.creacion_usuario_error+"</p>";
            }
        }
    };
    peticion.send(valores_de_los_campos);
}

document.addEventListener("DOMContentLoaded", function(){
    cargarEspecialidadesModal();
});