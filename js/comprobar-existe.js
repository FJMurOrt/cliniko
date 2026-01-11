//FUNCIÓN CON AJAX PARA COMPROBAR SI EL CORREO EXISTE EN LA BASE DE DATOS.
function comprobarCorreo() {
    let campo = document.getElementById("correo");
    if (!campo) return false;

    let correo = campo.value.trim();
    let error = document.getElementById("error_correo");

    if (correo === "") {
        error.innerHTML = "";
        return false;
    }

    let peticion = new XMLHttpRequest();
    peticion.open(
        "GET",
        "aplicacion/controladores/comprobar-existe.php?tipo=correo&valor=" + encodeURIComponent(correo),
        false
    );
    peticion.send();

    if (peticion.responseText === "existe") {
        error.innerHTML = "Este correo ya está registrado";
        return false;
    } else {
        error.innerHTML = "";
        return true;
    }
}

//FUNCIÓN CON AJAX PARA COMPROBAR SI EL NSS EXISTE YA EN LA BASE DE DATOS.
function comprobarNss() {
    let campo = document.getElementById("nss");
    if (!campo) return true;

    let nss = campo.value.trim();
    let error = document.getElementById("error_nss");

    if (nss === "") {
        error.innerHTML = "";
        return true;
    }

    let peticion = new XMLHttpRequest();
    peticion.open(
        "GET",
        "aplicacion/controladores/comprobar-existe.php?tipo=nss&valor=" + encodeURIComponent(nss),
        false
    );
    peticion.send();

    if (peticion.responseText === "existe") {
        error.innerHTML = "Este NSS ya existe";
        return false;
    } else {
        error.innerHTML = "";
        return true;
    }
}

//FUNCIÓN CON AJAX PARA COMPROBAR SI YA EXISYTE EL NUMERO DE COLEGIADO.
function comprobarColegiado() {
    let campo = document.getElementById("numero_colegiado");
    if (!campo) return true;

    let valor = campo.value.trim();
    let error = document.getElementById("error_colegiado");

    if (valor === "") {
        error.innerHTML = "";
        return true;
    }

    let peticion = new XMLHttpRequest();
    peticion.open(
        "GET",
        "aplicacion/controladores/comprobar-existe.php?tipo=colegiado&valor=" + encodeURIComponent(valor),
        false
    );
    peticion.send();

    if (peticion.responseText === "existe") {
        error.innerHTML = "Este número de colegiado ya existe";
        return false;
    } else {
        error.innerHTML = "";
        return true;
    }
}