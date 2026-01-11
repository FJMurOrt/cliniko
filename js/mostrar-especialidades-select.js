//PRIMERO ACCEDEMOS EN EL FORMULARIO AL ROL, AL CONTENEDOR DE LOS CAMPOS DE PACIENTE Y AL CONTENEDOR DE LOS CAMPOS DE MÉDICO Y LOS GUARDAMOS EN UNA VARIABLE CADA UNO.
  const rol = document.getElementById("rol");
  const camposPaciente = document.getElementById("campos_paciente");
  const camposMedico = document.getElementById("campos_medico");

  rol.addEventListener("change", function() {
    if (this.value === "paciente") {
      //SI SE SELECCIONA PACIENTE, MODIFICAMOS EL ESTILO DEL DIV DE LOS CAMPOS DE PACIENTE Y LE PONEMOS DE VALOR BLOCK PARA MOSTRARLO.
        camposPaciente.style.display = "block";
    } else {
        camposPaciente.style.display = "none"; //Y SI NO SE SE SELECCIONA, DEJAMOS EL ATRIBUTO DISPLAY EN NONE PARA QUE SIMPLEMENTE NO SE MUESTRE.
    }

    if (this.value === "medico") {
      //LO MISMO CON EL MÉDICO, SE SI SE SELECCIONA MOSTRAMOS EL DIV CON LOS CAMPOS DEL MÉDICO Y SI NO, PUES NADA.
        camposMedico.style.display = "block";
    } else {
        camposMedico.style.display = "none";
    }
});