document.addEventListener("DOMContentLoaded", function(){
    var select_fechas = document.getElementById("select-fecha");
    var select_turnos = document.getElementById("select-turno");
    var select_horas = document.getElementById("select-hora");
    var boton_pagar = document.getElementById("btn-pagar");
    var id_medico = document.getElementById("id-medico").value;

    //FUNCIÓN PARA CREAR LA PETICIÓN
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

    //FUNCIÓN PARA ACTIVAR O DESACTIVAR EL BOTÓN DEPENDIENDO DE LO QUE TENGAMOS SELECCIONADO EN EL SELECT
    function comprobarFormulario() {
        var fecha = select_fechas.value;
        var turno = select_turnos.value;
        var hora = select_horas.value;

        if(fecha && turno && hora &&
            hora !== "No quedan más horas" &&
            hora !== "Sin disponibilidad hoy"){
            boton_pagar.disabled = false;
        }else{
            boton_pagar.disabled = true;
        }
    }

    //EVENTO CHANGE PARA EL INPUT DATE DE LAS FECHAS
    select_fechas.addEventListener("change", function(){
    select_turnos.innerHTML = "<option value='' selected disabled>Selecciona un turno</option>";
    select_horas.innerHTML = "<option value='' selected disabled>Selecciona una hora</option>";
    comprobarFormulario();
    document.getElementById("mensaje-disponibilidad").innerHTML = "";

    if(select_fechas.value === ""){
        return;
    }

    // VALIDACIÓN DE FECHA ANTERIOR A HOY
    var hoy = new Date();
    var fecha_seleccionada = new Date(select_fechas.value);

    if(fecha_seleccionada.getFullYear() < hoy.getFullYear() || (fecha_seleccionada.getFullYear() === hoy.getFullYear() && fecha_seleccionada.getMonth() < hoy.getMonth()) ||
    (fecha_seleccionada.getFullYear() === hoy.getFullYear() && fecha_seleccionada.getMonth() === hoy.getMonth() && fecha_seleccionada.getDate() < hoy.getDate())){
        document.getElementById("mensaje-disponibilidad").innerHTML = "<p style='color: red;'>No puedes seleccionar una fecha anterior a hoy.</p>";
        select_fechas.value = "";
        return;
    }
    
    var peticion_turnos = crearObjetoPeticion();

    if(peticion_turnos){
        peticion_turnos.open("GET", "../../controladores/obtener-turnos.php?id_medico="+id_medico+"&fecha="+select_fechas.value, true);
        
        peticion_turnos.onreadystatechange = function(){
            if(peticion_turnos.readyState === 4 && peticion_turnos.status === 200){
                var repuesta = JSON.parse(peticion_turnos.responseText);
                if(repuesta.length === 0){
                    document.getElementById("mensaje-disponibilidad").innerHTML = "<p style='color: red;'>No hay disponibilidad para esta fecha.</p>";
                }else{
                    repuesta.forEach(function(turno){
                        var opcion = document.createElement("option");
                        opcion.value = turno;
                        opcion.text = turno;
                        select_turnos.appendChild(opcion);
                    });
                }
            }
        };
        peticion_turnos.send();
    }
});

    //EVENTO PARA CUANDO SELECCIONAMOS EN EL SELECT DE LOS TURNOS
    select_turnos.addEventListener("change", function(){
        select_horas.innerHTML = "<option value='' selected disabled>Selecciona una hora</option>";
        comprobarFormulario();

        if(select_turnos.value === "" || select_fechas.value === ""){
            return;
        }

        var peticion_horas = crearObjetoPeticion();
        if(peticion_horas){
            //ABRIMOS LA PETICION
            peticion_horas.open("GET", "../../controladores/obtener-horas.php?id_medico="+id_medico+"&fecha="+select_fechas.value +"&turno="+select_turnos.value, true);
            
            //COMPROBAMOS EL ESTADO Y OBTENEMOS EL RESULTADOS
            peticion_horas.onreadystatechange = function(){
                if (peticion_horas.readyState === 4 && peticion_horas.status === 200){
                    var repuesta = JSON.parse(peticion_horas.responseText);
                    for(var i = 0; i < repuesta.length; i++){
                        var opcion = document.createElement("option");
                        opcion.value = repuesta[i];
                        opcion.text = repuesta[i];
                        select_horas.appendChild(opcion);
                    }
                }
            };
            peticion_horas.send();
        }
    });

    //COMPROBAMOS FINALMENTE CON LOS TRES SELECT SELECCIONADOS SI ACTIVAMOS O DESACTIVAMOS EL BOTÓN
    select_horas.addEventListener("change", function(){
        comprobarFormulario();
    });
});