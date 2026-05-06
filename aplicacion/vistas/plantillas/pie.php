<!-- ESTO ES SIMPLEMENTE EL PIE DE PÁGINA QUE SE MOSTRARÁ EN TODAS LAS PÁGINAS DE LA WEB -->
<footer>
  <div class="container">
    <!--ENLACES DEL FOOTER DE LA IZQUIERDA-->
    <p style="text-align: left; display: inline-block; width: 48%; vertical-align: top;">
      <a href="aviso-legal.php" style="color: white; text-decoration: none;">Aviso legal</a><br>
      <a href="politica-privacidad.php" style="color: white; text-decoration: none;">Política de privacidad</a><br>
      <a href="politica-cookies.php" style="color: white; text-decoration: none;">Política de cookies</a><br>
      <a href="terminos-uso.php" style="color: white; text-decoration: none;">Términos y condiciones de uso</a>
    </p>

    <!--ENLACES DEL FOOTER DE LA DERECHA-->
    <p style="text-align: right; display: inline-block; width: 48%; vertical-align: top;">
      <a href="como-funciona.php" style="color: white; text-decoration: none;">Cómo funciona Clíniko</a><br>
      <a href="información-especialidades.php" style="color: white; text-decoration: none;">Especialidades médicas</a><br>
      <a href="pagos.php" style="color: white; text-decoration: none;">Métodos de pago</a><br>
    <!--IMAGEN DONDE SALEN LOS TIPOS DE TARJETA BANCARIA CON STRIPE. IMAGEN QUE OCUPE SIEMPRE EL 100% DEL ANCHO DEL CONTENEDOR PARA QEU NO SALGA EN RESPONSIVE Y NO SEA MÁS GRANDE 160PX DE ANCHO-->
    <img class="imagen-stripe" src="img/tarjetas_stripe.png">
    </p>
  </div>

  <div class="container text-center mt-3">
      <a href="https://docs.google.com/forms/d/e/1FAIpQLSfwruEhtJZNHEvVgSWiaHVoGVLMWJUKGTHOVQLj26PkE7A2xA/viewform?usp=preview" target="_blank" style="color: white; text-decoration: none;">¡Dejanos saber tu opinión sobre Clíniko!</a>
  </div>
  <div class="container text-center mt-3">
    <p>&copy; 2026 Clíniko. Francisco Javier Muriel Orta. Desarrollo de Aplicaciones Web. IES La Arboleda.</p>
  </div>
</footer>
<!--LOS SCRIPTS DE LA LANDING PAGE-->
  <script src = "js/aceptar_cookies.js"></script>
  <script src = "js/boton_para_subir.js"></script>
  <script src = "js/validacion-inicio-sesion.js"></script>
  <script src = "js/validar-formulario-recuperar-contrasena.js"></script>
  <script src = "js/mostrar-especialidades-select.js"></script>
  <script src = "js/validaciones-form-registro.js"></script>
  <script src = "js/validar-cambiar-contrasena.js"></script>
</body>
</html>