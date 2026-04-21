document.addEventListener("DOMContentLoaded", function(){
    const textarea = document.getElementById("motivo");
    const contador = document.getElementById("contador-motivo");
    const caracteres_maximos = 200;
    const mitad = caracteres_maximos / 2;

    textarea.addEventListener("input", function(){
        const caracteres = textarea.value.length;
        contador.textContent = caracteres+" / "+caracteres_maximos;

        if(caracteres >= caracteres_maximos){
            contador.style.color = "red";
        }else if(caracteres >= mitad){
            contador.style.color = "orange";
        }else{
            contador.style.color = "#48325A";
        }
    });
});