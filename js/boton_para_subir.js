const boton_para_subir = document.getElementById("boton-para-subir");

window.onscroll = function() {
  //SI SE HACEN MÁS DE 100PÍXELES DE SCROLL HACIA ABAJO, APARECE EL BOTÓN
  if (document.body.scrollTop > 1000 || document.documentElement.scrollTop > 1000) {
    boton_para_subir.style.display = "block";
  } else {
    boton_para_subir.style.display = "none";
  }
};

boton_para_subir.onclick = function() {
  //Y SI LUEGO HACES CLICK EN EL BOTÓN TE MUEVE A 0 PÍXELES VERTICALMENTE, O LO QUE ES LO MISMO, TE MUEVE AL INICIO, ARRIBA DEL TODO Y CON EL SEGUNDO PARAMETRO LE DIDO COMO QUIERO QUE LO HAGA, EN ESTE CASO CON UNA ANIMACION SUAVE.
  window.scrollTo({top: 0, behavior: 'smooth'});
};