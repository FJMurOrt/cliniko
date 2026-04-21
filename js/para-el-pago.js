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

// MI CLAVE PUBLICA DE LA API DE STRIPE
const stripe = Stripe("pk_test_51T7RuPLxdshS43I60YRVn1R7TBSrjMI3SsLXiN4Yp6uNSymdKIcRAwGGKDlsvWfivUdKe1oD5arMVo7QbL7tBPVo00BQFP4lF0");

document.getElementById("btn-pagar").addEventListener("click", function(){
    //VALIDAMOS QUE EL CAMPO DLE MOTIVO NO ESTE VACÍO O SE MAYOR A 200 LETRAS
    var motivo = document.getElementById("motivo");
    var texto = motivo.value.trim();

    document.getElementById("error-motivo").innerHTML = "";

    if(texto.length > 200){
        document.getElementById("error-motivo").innerHTML = "El motivo no puede tener más de 200 caracteres.";
        motivo.focus();
        return;
    }

    //COGEMOS LOS DATOS DEL FORMULARIO Y HACEMOS UN FORMDATA PARA ENVIARLOS
    const formulario_solicitar_cita = document.getElementById("formPago");
    const datos_del_formulario = new FormData(formulario_solicitar_cita);

    //CREAMOS LA PETICIÓN
    const peticion = crearObjetoPeticion();
    
    if(!peticion){
        return;
    }

    //LA ABRIMOS
    peticion.open("POST", "../../controladores/crear-pago.php", true);

    //CUANDO RECIBAMOS RESPUESTA
    peticion.onload = function(){
        if (peticion.status === 200){
            //OBTENEMOS LA SESIÓN DE STRIPE DEL CONTROLADOR PHP
            const sesion_stripe = JSON.parse(peticion.responseText);

            //CON LA SESION REDIRIGIMOS A LA PASARELA TENIENDO EN CUENTA EL ID QUE TIENE LA SESION
            stripe.redirectToCheckout({ sessionId: sesion_stripe.id }).then(function(resultado){
                if(resultado.error){
                    alert(resultado.error.message);
                }
            });
        }else{
            alert("Hubo un error al intentar realizar el pago.");
        }
    };
    //ENVIAMOS LOS DATOS DEL FORMULARIO AL CONTROLADOR PARA QUE LOS GUARDE.
    peticion.send(datos_del_formulario);
});