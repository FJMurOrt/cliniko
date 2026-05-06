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

//FUNCIÓN PARA ABRIR LA VENTANA DEL MODAL
function abrirModalCrearAdmin(){
    $("#modal-crear-admin").modal("show");
}

//FUNCIÓN PARA CREAR AL ADMIN Y VALIDAR CAMPOS
function crearAdministrador(){
    //PONGO LOS SPAN DE LOS ERRORES EN BLANCO ANTES DE VALIDAR
    var errores_ids = ["error-admin-nombre","error-admin-apellidos","error-admin-telefono",
                       "error-admin-correo","error-admin-contrasena","error-admin-contrasena2"];

    errores_ids.forEach(function(id){
        document.getElementById(id).innerHTML = "";
    });

    var nombre = document.getElementById("admin-nombre").value.trim();
    var apellidos = document.getElementById("admin-apellidos").value.trim();
    var telefono = document.getElementById("admin-telefono").value.trim();
    var correo = document.getElementById("admin-correo").value.trim();
    var contrasena = document.getElementById("admin-contrasena").value;
    var contrasena2 = document.getElementById("admin-contrasena2").value;

    //EXPRESIONES
    var expresion_nombre = new RegExp("^[A-ZÑa-zñÁÉÍÓÚáéíóúÑñ]{1,20}(\\s[A-ZÑa-zñÁÉÍÓÚáéíóúÑñ]{1,20})?$");
    var expresion_telefono = new RegExp("^[0-9]{9}$");
    var expresion_correo = new RegExp("^[A-Za-z0-9._-]+@[A-Za-z0-9.-]+\\.[A-Za-z]{2,}$");
    var expresion_contrasena = new RegExp("^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[._-]).{8,}$");

    //VALIDACIONES
    var hay_errores = false;

    //NOMBRE
    if(nombre === ""){
        document.getElementById("error-admin-nombre").innerHTML = "El nombre es obligatorio.";
        hay_errores = true;
    }else if(!expresion_nombre.test(nombre)){
        document.getElementById("error-admin-nombre").innerHTML = "El nombre solo puede tener 2 palabras y máximo 20 letras.";
        hay_errores = true;
    }

    //APELLIDOS
    if(apellidos === ""){
        document.getElementById("error-admin-apellidos").innerHTML = "Los apellidos son obligatorios.";
        hay_errores = true;
    }else if(!expresion_nombre.test(apellidos)){
        document.getElementById("error-admin-apellidos").innerHTML = "Los apellidos solo pueden tener 2 palabras y máximo 20 letras.";
        hay_errores = true;
    }

    //TELÉFONO
    if(telefono === ""){
        document.getElementById("error-admin-telefono").innerHTML = "El teléfono es obligatorio.";
        hay_errores = true;
    }else if(!expresion_telefono.test(telefono)){
        document.getElementById("error-admin-telefono").innerHTML = "El teléfono debe contener 9 números.";
        hay_errores = true;
    }

    //CORREO ELECTRÓNICO
    if(correo === ""){
        document.getElementById("error-admin-correo").innerHTML = "El correo es obligatorio.";
        hay_errores = true;
    }else if(!expresion_correo.test(correo)){
        document.getElementById("error-admin-correo").innerHTML = "El correo no tiene un formato válido.";
        hay_errores = true;
    }

    //CONTRASEÑA
    if(contrasena === ""){
        document.getElementById("error-admin-contrasena").innerHTML = "La contraseña es obligatoria.";
        hay_errores = true;
    }else if(!expresion_contrasena.test(contrasena)){
        document.getElementById("error-admin-contrasena").innerHTML = "La contraseña debe tener mínimo 8 caracteres, mayúsculas, minúsculas, números y caracteres especiales.";
        hay_errores = true;
    }

    if(contrasena2 === ""){
        document.getElementById("error-admin-contrasena2").innerHTML = "Debes volver a introducir la contraseña.";
        hay_errores = true;
    }else if(contrasena !== contrasena2){
        document.getElementById("error-admin-contrasena2").innerHTML = "Las contraseñas no coinciden.";
        hay_errores = true;
    }

    if(hay_errores){
        return;
    }

    //Y ENVIO LOS VALORES POR POST AL CONTROLADOR PARA QUE LOS INSERTE SI TODO ESTA BIEN
    var valores_crear_admin = "nombre="+encodeURIComponent(nombre)+"&apellidos="+encodeURIComponent(apellidos)+
                              "&telefono="+encodeURIComponent(telefono)+"&correo="+encodeURIComponent(correo)+
                              "&contrasena="+encodeURIComponent(contrasena)+"&contrasena2="+encodeURIComponent(contrasena2);

    var peticion = crearObjetoPeticion();

    if(!peticion){
       return; 
    }

    peticion.open("POST", "../../controladores/ajax-crear-admin.php", true);
    peticion.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    peticion.onreadystatechange = function(){
        if(peticion.readyState === 4 && peticion.status === 200){
            var respuesta = JSON.parse(peticion.responseText);
            if(respuesta.admin_creado){
                document.getElementById("mensaje-crear-admin").innerHTML = "<p style='color: green;'>El usuario de tipo administrador creado correctamente.</p>";
                $("#modal-crear-admin").modal("hide");
                mostrarUsuarios();
            }else{
                document.getElementById("mensaje-crear-admin").innerHTML = "<p style='color: red;'>"+respuesta.error_al_crear_admin+"</p>";
            }
        }
    };
    peticion.send(valores_crear_admin);
}