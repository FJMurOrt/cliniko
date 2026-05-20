# Clíniko

Aplicación web para la gestión de citas médicas entre pacientes y médicos.

Clíniko es el proyecto final de mi Ciclo Formativo de Grado Superior en Desarrollo de Aplicaciones Web. Es una plataforma digital que ofrece la comunicación entre pacientes y médicos, y que permite gestionar citas médicas, historiales, valoraciones y notificaciones.

⚠️ Este proyecto se encuentra en fase alfa.


## 🐳 Ejecutar con Docker

La forma más fácil de levantar el proyecto es usando la imagen que está en DockerHub.

### Requisitos
- Docker instalado

### Pasos

```bash
docker pull fjmurort/cliniko:latest
```

Crea un archivo `docker-compose.yml` con el siguiente contenido:

```yaml
version: "3.8"

services:
  web:
    image: fjmurort/cliniko:latest
    ports:
      - "8080:80"
    depends_on:
      - db
    environment:
      - DB_HOST=db
      - DB_NAME=cliniko
      - DB_USER=root
      - DB_PASS=rootpassword

  db:
    image: mysql:8.0
    environment:
      - MYSQL_ROOT_PASSWORD=rootpassword
      - MYSQL_DATABASE=cliniko
    volumes:
      - ./cliniko.sql:/docker-entrypoint-initdb.d/cliniko.sql
```

```bash
docker-compose up
```

Accede en: **http://localhost:8080**

### Usuarios de prueba

| Rol | Email | Contraseña |
|-----|-------|------------|
| Administrador | admin@test.com | Test1234. |
| Médico | medico@test.com | Test1234. |
| Paciente | paciente@test.com | Test1234. |

---

## ⚠️ Avisos importantes

- **Brevo API:** El envío de emails requiere configurar una API key propia de Brevo en el archivo de configuración.
- **Stripe:** Los pagos requieren configurar las claves de Stripe propias.
- Las funcionalidades de email y pagos no están activas en la imagen de Docker por defecto.

---

## 🏗️ Estructura del proyecto (MVC)

La aplicación sigue la estructura MVC para mantener la organización del código.

---

## 👥 Roles y permisos

- **Paciente:** solicita, modifica o cancela citas, valora médicos y recibe notificaciones.
- **Médico:** gestiona sus citas, consulta historiales y recibe valoraciones.
- **Administrador:** gestiona usuarios, supervisa valoraciones y la configuración general.

---

## ⚙️ Funcionalidades clave

- Gestión completa de citas médicas (CRUD)
- Sistema de roles
- Notificaciones por correo electrónico
- AJAX con XMLHttpRequest
- Filtros, paginación y búsqueda en tiempo real
- Validaciones en frontend y backend
- Diseño responsive con Bootstrap

---

## 🛠️ Tecnologías utilizadas

**Backend:** PHP (procedural), MySQL

**Frontend:** HTML5, CSS3, Bootstrap 5, JavaScript, AJAX

**Herramientas:** Docker, Git y GitHub, Brevo API, Stripe, Tidio, pdf24.js

---

# Landing page y páginas públicas

<p align="center"><b>Landing page 1</b></p>
<<p align="center">
  <img src="capturas/1.png" width="80%">
</p>
<p align="center"><b>Landing page 2</b></p>
<p align="center">
  <img src="capturas/2.png" width="80%">
</p>
<p align="center"><b>Landing page 3</b></p>
<p align="center">
  <img src="capturas/3.png" width="80%">
</p>
<p align="center"><b>Landing page 4</b></p>
<p align="center">
  <img src="capturas/4.png" width="80%">
</p>
<p align="center"><b>Sobre Clíniko 1</b></p>
<p align="center">
  <img src="capturas/5.png" width="80%">
</p>
<p align="center"><b>Sobre Clíniko 2</b></p>
<p align="center">
  <img src="capturas/6.png" width="80%">
</p>
<p align="center"><b>Registro</b></p>
<p align="center">
  <img src="capturas/7.png" width="80%">
</p>
<p align="center"><b>Login</b></p>
<p align="center">
  <img src="capturas/8.png" width="80%">
</p>

# Paneles de usuario

<p align="center"><b>Panel del Paciente</b></p>
<p align="center">
  <img src="capturas/9.png" width="80%">
</p>

<p align="center"><b>Panel del Médico</b></p>
<p align="center">
  <img src="capturas/10.png" width="80%">
</p>

<p align="center"><b>Panel del Administrador</b></p>
<p align="center">
  <img src="capturas/11.png" width="80%">
</p>

# Demo desde Infinity Free
También puedes ver la aplicación en funcionamiento en el siguiente enlace:
[Clíniko](https://cliniko.infinityfreeapp.com/)



























