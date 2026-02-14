window.onload = function() {
    if (!localStorage.getItem("cookies")) {
    document.getElementById("alerta-para-que-aceptes").style.display = "block";
    }
    document.getElementById("aceptar_cookies").onclick = function() {
    localStorage.setItem("cookies", "aceptadas");
    document.getElementById("alerta-para-que-aceptes").style.display = "none";
    }
    document.getElementById("rechazar_cookies").onclick = function() {
    localStorage.setItem("cookies", "rechazadas");
    document.getElementById("alerta-para-que-aceptes").style.display = "none";
    }
}