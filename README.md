# Sistema de Login en PHP

Este proyecto es un sistema de inicio de sesión completo y moderno, desarrollado con PHP 8.3.19, HTML5, CSS3, JavaScript y Bootstrap. Incluye funcionalidades avanzadas como verificación de correo electrónico, roles de usuario, subida de imagen de perfil, selección de avatar y protección contra accesos no autorizados.

## 🔐 Características principales

- Registro de usuarios con validaciones en tiempo real
- Verificación de correo electrónico
- Ingreso seguro con control de intentos fallidos
- Gestión de roles y selección de aplicación
- Subida de imagen de perfil o selección de avatar
- Panel de control por roles
- Estilo visual atractivo con Bootstrap y SweetAlert

## 🧰 Tecnologías utilizadas

- PHP 8.3.19
- JavaScript moderno
- HTML5 y CSS3
- Bootstrap 5
- SweetAlert2
- PDO para conexiones seguras a la base de datos
- Git + GitHub

## 📁 Estructura del proyecto

```
Aplicacion_LOGIN/
│
├── controllers/           # Lógica del sistema (registro, login, verificación)
├── includes/              # Conexión a la base de datos y configuración
├── view/                  # Vistas del login, registro y dashboard
├── test/                  # Archivos de prueba para funcionalidades específicas
├── LICENSE                # Licencia GPL v3.0
└── .gitignore             # Archivos ignorados por Git
```

## ⚙️ Requisitos

- Servidor con PHP 8.3.19 o superior
- Servidor web (Apache, Nginx, etc.)
- MySQL o MariaDB
- Acceso para configurar la base de datos y el correo saliente (SMTP)

## 📦 Instalación

1. Clona este repositorio:
   ```bash
   git clone https://github.com/IaManolo/sistema-login.git
   ```

2. Configura la base de datos importando el archivo SQL correspondiente.

3. Renombra `includes/config.example.php` a `config.php` y completa los datos de conexión.

4. Asegúrate de tener habilitada la extensión `pdo_mysql` en tu `php.ini`.

5. Ejecuta el proyecto desde un entorno local (XAMPP, Laragon, etc.) o tu servidor.

## 🧑‍💻 Autor

**Manuel Molina Sánchez**

## 📜 Licencia

Este proyecto está licenciado bajo la **GNU General Public License v3.0**. Consulta el archivo `LICENSE` para más detalles.
