const expresion_telefono = new RegExp("^[0-9]{9}$");
const expresion_correo = new RegExp("^[A-Za-z0-9._-]+@[A-Za-z0-9.-]+\\.[A-Za-z]{2,}$");
const expresion_contrasena = new RegExp("^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[._-]).{8,}$");

//VALIDACIÓN CAMBIAR FOTO
document.getElementById("form-foto").addEventListener("submit", function(evento){
    document.getElementById("error-cambiar-foto").innerHTML = "";
    let errores = false;

    let foto = document.getElementById("cambiar-foto");

    if(!foto.files || foto.files.length === 0){
        document.getElementById("error-cambiar-foto").innerHTML = "Debes seleccionar una foto.";
        errores = true;
    }else{
        const archivo = foto.files[0];
        if(archivo.size > 2 * 1024 * 1024){
            document.getElementById("error-cambiar-foto").innerHTML = "La foto no puede pesar más de 2MB.";
            errores = true;
        }
        const formatos_permitidos = ["image/jpeg", "image/png"];
        if(!formatos_permitidos.includes(archivo.type)){
            document.getElementById("error-cambiar-foto").innerHTML = "Solo se permiten imágenes con formato .JPG o .PNG.";
            errores = true;
        }
    }

    if(errores) evento.preventDefault();
});

//VALIDACIÓN CAMBIAR CORREO
document.getElementById("form-correo").addEventListener("submit", function(evento){
    document.getElementById("error-cambiar-correo").innerHTML = "";
    let errores = false;

    let correo = document.getElementById("correo1").value.trim();
    let correo2 = document.getElementById("correo2").value.trim();

    if(correo === ""){
        document.getElementById("error-cambiar-correo").innerHTML = "Debes introducir un correo.";
        errores = true;
    }else if(!expresion_correo.test(correo)){
        document.getElementById("error-cambiar-correo").innerHTML = "El formato del correo electrónico no es correcto.";
        errores = true;
    }else if(correo !== correo2){
        document.getElementById("error-cambiar-correo").innerHTML = "Los correos electrónicos introducidos no coinciden.";
        errores = true;
    }

    if(errores) evento.preventDefault();
});

//VALIDACIÓN CAMBIAR TELÉFONO
document.getElementById("form-telef").addEventListener("submit", function(evento){
    document.getElementById("error-cambiar-telef").innerHTML = "";
    let errores = false;

    let telef = document.getElementById("telef1").value.trim();
    let telef2 = document.getElementById("telef2").value.trim();

    if(telef === ""){
        document.getElementById("error-cambiar-telef").innerHTML = "Debes introducir un teléfono.";
        errores = true;
    }else if(!expresion_telefono.test(telef)){
        document.getElementById("error-cambiar-telef").innerHTML = "El número de teléfono debe tener 9 números.";
        errores = true;
    }else if(telef !== telef2){
        document.getElementById("error-cambiar-telef").innerHTML = "Los números de teléfono no coinciden.";
        errores = true;
    }

    if(errores) evento.preventDefault();
});

//VALIDACIÓN CAMBIAR CONTRASEÑA
document.getElementById("form-contra").addEventListener("submit", function(evento){
    document.getElementById("error-cambiar-contra").innerHTML = "";
    let errores = false;

    let contra = document.getElementById("contra1").value.trim();
    let contra2 = document.getElementById("contra2").value.trim();

    if(contra === ""){
        document.getElementById("error-cambiar-contra").innerHTML = "Debes introducir una contraseña.";
        errores = true;
    }else if(!expresion_contrasena.test(contra)){
        document.getElementById("error-cambiar-contra").innerHTML = "La contraseña debe contener mínimo 8 caracteres, mayúsculas, minúsculas, números y caracteres especiales.";
        errores = true;
    }else if(contra !== contra2){
        document.getElementById("error-cambiar-contra").innerHTML = "Las contraseñas introducidas no coinciden.";
        errores = true;
    }

    if(errores) evento.preventDefault();
});