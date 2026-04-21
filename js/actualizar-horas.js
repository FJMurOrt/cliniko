document.addEventListener("DOMContentLoaded", function(){
    const select_turnos = document.getElementById("turno");
    const inicio = document.getElementById("hora_inicio");
    const fin = document.getElementById("hora_fin");

    select_turnos.addEventListener("change", function(){
        const turno = this.value;

        inicio.innerHTML = "";
        fin.innerHTML = "";

        let horas = [];
        if(turno === "mañana"){
            horas = ["09:00","10:00","11:00","12:00","13:00","14:00"];
        } else if(turno === "tarde"){
            horas = ["16:00","17:00","18:00","19:00","20:00"];
        }

        horas.forEach(h => {
            const opcion1 = document.createElement("option");
            opcion1.value = h;
            opcion1.textContent = h;
            inicio.appendChild(opcion1);

            const opcion2 = document.createElement("option");
            opcion2.value = h;
            opcion2.textContent = h;
            fin.appendChild(opcion2);
        });
    });
});