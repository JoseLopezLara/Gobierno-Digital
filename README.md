# Aplicante: José López Lara

## Evidencia de funcionamiento

[Video mostrando funcionamiento en POSTMAN, mostrando código y hablando de las dificultades](https://youtu.be/WgWapDzJHOQ)

## Como correr el proyecto

1. Clonar unsado  ``https://github.com/JoseLopezLara/Gobierno-Digital.git``
2. Pegar el ``.env`` que envio en el correo
3. Ejecuta ``composer i``
4. Ejecuta ``php artisan migrate --seed``
5. Ejecuta ``php artisan optimize:clear``
6. Ejecuta ``php artisan serve``
7. Descargar el ``Prueba Backend.postman_collection.json`` y abrilo desde postman para poder hacer las pruebas.
8. El usario administrador es:

    - email: ``andoney.betancourtc@sfa.michoacan.gob.mx``
    - contraseña: ``password_no_segura``

9. Los 15 usarios con rol "user" son generados a travez del factory con faker, por lo que el correro es aleatorio y la contrase es ``password_no_segura``

## Estas fueron las buenas practicas que intente aplicar

1. Refactorización de `UserController` para mejorar la mantenibilidad.
2. Implementación de `Code Block` para facilitar el mantenimiento del código.
3. Simulación de `Laravel Permissions` mediante un `trait` en el modelo `User` para la gestión de autorizaciones.
4. Creación de `Seeders` con responsabilidades únicas.
5. Invalidación del token al realizar `logout`.

---

## Configuración del proyecto

1. **Breeze**: Se elige por ser una REST API y ofrecer un modo "Only API" a diferencia de `Jetstream`.
2. **MySQL**: Seleccionado por requerimiento.
3. **JWT**: Integración de `tymon/jwt-auth` para la gestión de `JSON Web Tokens`.

---

## Proceso cronológico mediante `Features`

### #1: FJLL-JWTMigration

- Integración de `tymon/jwt-auth`, configuración del archivo y migración de `Sanctum` a `JWT`.

### #2: FJLL-MigracionesYSeeders

- Creación de migraciones para `roles` y la tabla pivote `many-to-many`.
- Inclusión de la relación en los modelos `User` y `Roles`.
- Creación de seeders para `roles`, `usuarios` (con `factory` para rol `user`) y un seeder para el administrador.

### #3: HFJLL-JWT

- En este punto ya tenía usuarios en la base de datos para probar JWT, pero surgieron problemas debido a que Breeze incorporaba Sanctum por defecto. Habría ahorrado tiempo creando el proyecto sin un starter kit.
- Solución de errores en `AuthController` relacionados con `middleware`.
- Eliminación de configuraciones innecesarias de `Sanctum` en `app.bootstrap`.

### #4: FJLL-CRUD

- Esto fue lo más sencillo y rápido de la prueba.
- Implementación de `CRUD`.
- Creación de un `trait` para la autorización, verificando el `slug` del usuario autenticado con el rol `admin`.

### #5: FJLL-ReadmeYComentariosCodigo

- Documentación en `README`.
- Refactorización final de `UserController` mediante un `trait` debido a que me sobró tiempo y preferí invertirlo en hacer una refactorización profesional y mantenible.

---

## Conclusiones

Mientras trabajaba en el proyecto, encontré un par de errores en los requerimientos. Uno de ellos fue en el tipado de `description`, ya que estaba como `datetime` cuando realmente debería ser `text` nulleable, para permitir más de 255 caracteres. Otro detalle fue el `remember_token`, que estaba definido como `float`, pero según la documentación de Laravel ([Referencia](https://laravel.com/docs/11.x/migrations#column-method-rememberToken)), debe ser `VARCHAR(100)`, ya que de lo contrario podría causar problemas.

Al final, logré completar todo en aproximadamente 6 horas y 30 minutos, incluyendo pruebas. Fue mi primera vez integrando JWT en Laravel; conocía el concepto, pero siempre había usado Sanctum. Algo que me habría ahorrado bastante tiempo habría sido evitar el uso de Breeze, ya que las configuraciones que integraba con Sanctum me impidieron seguir la documentación de JWT de una manera más directa, lo que generó retrasos considerables. A pesar de ello, disfruté mucho el ejercicio.

### Puntos de mejora

Entiendo que este ejercicio buscaba evaluar cómo abordaría la gestión de permisos de manera "manual", pero en un entorno productivo definitivamente usaría `Laravel Permission`, ya que ofrece una alta escalabilidad. Ahora que ya integré JWT por primera vez, si tuviera que repetirlo, evitaría Breeze y estructuraría mejor el código moviendo las funciones del `AuthController` a un patrón basado en servicios, lo que haría que el código fuera mucho más mantenible.
