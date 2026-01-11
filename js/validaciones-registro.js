//EVENTO Y FUNCIÓN PARA CUANDO CARGA LA PÁGINA
window.onload = function () {
    //ACCEDEMOS A LOS ELEMENTOS QUE VAMOS A NECESITAR
    let formulario = document.getElementById("form-registro");

    let div_error_nombre = document.getElementById("error_nombre");
    let div_error_apellidos = document.getElementById("error_apellidos");
    let div_error_correo = document.getElementById("error_correo");
    let div_error_telefono = document.getElementById("error_telefono");
    let div_error_contrasenia = document.getElementById("error_contrasenia");
    let div_error_rol = document.getElementById("error_rol");
    let div_error_foto = document.getElementById("error_foto");
    let div_error_fecha = document.getElementById("error_fecha");
    let div_error_direccion = document.getElementById("error_direccion");
    let div_error_nss = document.getElementById("error_nss");
    let div_error_colegiado = document.getElementById("error_colegiado");
    let div_error_especialidad = document.getElementById("error_especialidad");
    let div_error_politica = document.getElementById("error_politica");

    //FUNCIÓN PARA LIMPIAR LOS ERRORES AL VOLVER A ENVIAR EL FORMULARIO
    function limpiarErrores(){
        let errores = document.getElementsByClassName("error-text");
        for(let i = 0; i < errores.length; i++){
            errores[i].innerHTML = "";
        }
    }

    formulario.onsubmit = function (event) {
        //LLAMAMOS A LA FUNCIÓN PARA LIMPIAR LOS ERRORES, SI LOS HUBIERA DE ANTES.
        limpiarErrores();

        //VARIABLE BOOLEANA PARA SABER SI EL FORMULARIO ES CORRECTO O NO AL FINAL PARA ENVIARLO
         let valido = true;

         //LLAMADAS AJAX PARA VERIFICAR EXISTENCIA. FUNCIONES DEL OTRO ARCHIVJO JS.
        if (comprobarCorreo() === false) {
            valido = false;
        }

        if (comprobarNss() === false) {
            valido = false;
        }

        if (comprobarColegiado() === false) {
            valido = false;
        }

        // NOMBRE QUE PUEDE SER DE 1 A 3 PALARBAS COMO MÁXIMO
        let nombre = document.getElementById("nombre").value.trim();
        let regexNombre = /^[A-Za-zÁÉÍÓÚáéíóúÑñ]+( [A-Za-zÁÉÍÓÚáéíóúÑñ]+){0,2}$/;

        if (nombre === "") {
            div_error_nombre.innerHTML = "Este campo es obligatorio";
            event.preventDefault();
            valido = false;
        }
        if (!regexNombre.test(nombre)) {
            div_error_nombre.innerHTML = "El nombre debe tener entre 1 y 3 palabras y solo letras";
            event.preventDefault();
            valido = false;
        }

        // APELLIDOS QUE PUEDE SER DE 1 O 2 PALABRAS COMO MÁXIMO.
        let apellidos = document.getElementById("apellidos").value.trim();
        let regexApellidos = /^[A-Za-zÁÉÍÓÚáéíóúÑñ]+( [A-Za-zÁÉÍÓÚáéíóúÑñ]+){0,1}$/;

        if (apellidos === "") {
            div_error_apellidos.innerHTML = "Este campo es obligatorio";
            event.preventDefault();
            valido = false;
        } else if (!regexApellidos.test(apellidos)) {
            div_error_apellidos.innerHTML =
                "Los apellidos deben tener entre 1 y 2 palabras y solo letras";
            event.preventDefault();
            valido = false;
        }

        //CORREO ELECTRÓNICO
        //LETRAS, NÚMEROS, CARACTERES ESPECIALES Y LO DEMÁS EL TIPICO FORMATO CORREO.
        let correo = document.getElementById("correo").value.trim();
        let regexCorreo = /^[a-zA-Z0-9._%+-]+@[a-zA-Z]+\.[a-zA-Z]{2,}$/;

        if (correo === "") {
            div_error_correo.innerHTML = "Este campo es obligatorio";
            event.preventDefault();
            valido = false;
        } else if (!regexCorreo.test(correo)) {
            div_error_correo.innerHTML = "El correo no tiene un formato válido";
            event.preventDefault();
            valido = false;
        }

        //TELÉFONO CON SÓLO 9 NÚMEROS.
        let telefono = document.getElementById("telefono").value.trim();
        let regexTelefono = /^\d{9}$/;

        if (telefono === "") {
            div_error_telefono.innerHTML = "Este campo es obligatorio";
            event.preventDefault();
            valido = false;
        } else if (!regexTelefono.test(telefono)) {
            div_error_telefono.innerHTML =
                "El teléfono debe tener exactamente 9 dígitos";
            event.preventDefault();
            valido = false;
        }

        //CONTRASEÑA
        //8 CARACTERS MÍNIMO, LA PRIMERA EN MAYSUCULA Y UN NÚMERO TAMBIÉN.
        let contrasena = document.getElementById("contrasena").value.trim();
        let regexContrasena = /^(?=.*\d)(?=.*[A-Z]).{8,}$/;
        
        if (contrasena === "") {
            div_error_contrasenia.innerHTML = "Este campo es obligatorio";
            event.preventDefault();
            valido = false;
        } else if (!regexContrasena.test(contrasena)) {
            div_error_contrasenia.innerHTML =
                "La contraseña debe tener mínimo 8 caracteres, una mayúscula y un número";
            event.preventDefault();
            valido = false;
        }

        //ELEGIR UN ROL ES OBLIGATORIO
        let rol = document.getElementById("rol").value;
        if (rol !== "paciente" && rol !== "medico") {
            div_error_rol.innerHTML = "Debes seleccionar un rol: Paciente o Médico";
            event.preventDefault();
            valido = false;
        }

        //NÚMERO DE COLEGIADO PARA LOS USUARIOS MÉDICOS.
        //PUEDE CONTENER LETRAS MAYUSCULAS, NÚMEROS Y GUIONES.
        let numero_colegiado_input = document.getElementById("numero_colegiado");

        if (rol === "medico") {

            if (!numero_colegiado_input || numero_colegiado_input.value.trim() === "") {
                div_error_colegiado.innerHTML = "El número de colegiado es obligatorio para médicos";
                event.preventDefault();
                valido = false;
            } else {
                let numero_colegiado = numero_colegiado_input.value.trim();
                let regexColegiado = /^[A-Z0-9-]+$/;

                if (!regexColegiado.test(numero_colegiado)) {
                    div_error_colegiado.innerHTML =
                        "El número de colegiado solo puede contener letras mayúsculas, números y guiones";
                    event.preventDefault();
                    valido = false;
                }
            }
        }

        //ELEGIR UNA ESPECIALIDAD ES OBLIGATORIO.
        let especialidad_input = document.getElementById("id_especialidad");

        if (rol === "medico") {
            if (!especialidad_input || especialidad_input.value === "" || especialidad_input.value === null) {
                div_error_especialidad.innerHTML = "Debes seleccionar una especialidad";
                event.preventDefault();
                valido = false;
            }
        }

        //FECHA DE NACIMIENTO PARA EL PACIENTE ES OBLIGATORIA.
        let fechaNacimientoInput = document.getElementById("fecha_nacimiento");

        if (rol === "paciente") {

            if (!fechaNacimientoInput || fechaNacimientoInput.value === "") {
                div_error_fecha.innerHTML = "Debes seleccionar una fecha de nacimiento";
                event.preventDefault();
                valido = false;
            } else {

                let nacimiento = new Date(fechaNacimientoInput.value);
                let hoy = new Date();

                let edad = hoy.getFullYear() - nacimiento.getFullYear();
                let mes = hoy.getMonth() - nacimiento.getMonth();
                let dia = hoy.getDate() - nacimiento.getDate();

                if (mes < 0 || (mes === 0 && dia < 0)) {
                    edad--;
                }

                if (edad < 18) {
                    div_error_fecha.innerHTML = "Debes ser mayor de 18 años para registrarte";
                    event.preventDefault();
                    valido = false;
                }
            }
        }

        //DIRECCIÓN PARA EL PACIENTE OBLIGATORIA.
        //NUMEROS Y LETRAS, 5 PALABRAS MÁXIMO.
        let direccion_input = document.getElementById("direccion");

        if (rol === "paciente") {

            if (!direccion_input || direccion_input.value.trim() === "") {
                div_error_direccion.innerHTML = "La dirección es obligatoria para pacientes";
                event.preventDefault();
                valido = false;
            } else {
                let direccion = direccion_input.value.trim();
                let regexDireccion = /^([A-Za-z0-9,º]+( [A-Za-z0-9,º]+){0,4})$/;

                if (!regexDireccion.test(direccion)) {
                    div_error_direccion.innerHTML =
                        "La dirección puede contener hasta 5 palabras con letras y números";
                    event.preventDefault();
                    valido = false;
                }
            }
        }

        //NÚMERO DE LA SEGURIDAD SOCIAL OBLIGATORIO PARA EL PACIENTE.
        //DEBE SEGUIR EL FORMAATO DE 2 DIGITOS, LUEGO ESPACIO, LUEGO 8, LUEGO ESPACIO, LUEGO 2. 12 EN TOTAL.
        let nss_input = document.getElementById("nss");

        if (rol === "paciente") {

            if (!nss_input || nss_input.value.trim() === "") {
                div_error_nss.innerHTML = "El número de la Seguridad Social es obligatorio";
                event.preventDefault();
                valido = false;
            } else {
                let nss = nss_input.value.trim();
                let regexNSS = /^\d{2} \d{8} \d{2}$/;

                if (!regexNSS.test(nss)) {
                    div_error_nss.innerHTML =
                        "El NSS debe tener el formato: XX XXXXXXXX XX";
                    event.preventDefault();
                    valido = false;
                }
            }
        }

        //SUBIR UNA FOTO DE PERFIL ES OBLIGATORIA.
        let foto_input = document.getElementById("foto_perfil");

            if (!foto_input || foto_input.files.length === 0) {
                div_error_foto.innerHTML = "Debes subir una foto de perfil";
                event.preventDefault();
                valido = false;
            }

        //ACEPTAR POLÍTICA DE PRIVACIDAD ES OBLIGATORIO TAMBIÉN.
        let politica_input = document.getElementById("acepta_politica");
            if (!politica_input.checked) {
                div_error_politica.innerHTML = "Debes aceptar la política de privacidad";
                event.preventDefault();
                valido = false;
            }

        if(!valido) {
            event.preventDefault();
            return false;
        }
        //SI TODO ESTA BIÉN PERO SE HACE EL SUBMIT, ES DECIR, QUE SE ENVÍA EL FORMULARIO.
        return true;
    };
};