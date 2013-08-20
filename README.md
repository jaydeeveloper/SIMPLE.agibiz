#SOFTWARE PÚBLICO
#SIMPLE - Sistema de Implementación de Procesos Ligeramente Estandarizados (demo.chilesinpapeleo.cl)


### Resumen
SIMPLE (Sistema para la Implementación de Procesos Ligeramente Estandarizados) corresponde a un sistema para la implementación de procesos electrónicos mediante un diseñador simplificado, desarrollado para entregar una solución flexible a instituciones públicas que deseen digitalizar sus trámites de forma amigable, rápida y sencilla.


### Ambiente de Ejecución
Los usuarios deben ingresar mediante ambiente web, a través de la URL provista por el organismo.

### Plataforma, Framework o Lenguaje de Programación / BBDD
PHP, HTML, Javascript, CSS, MySQL  
Codeigniter 2.1.0  
Twitter Bootstrap 2.3.1  
jQuery 1.7.2  

### Requisitos Técnicos
PHP >= 5.3.x, MySQL >= 5.5.x

### Tipo de Licencia
El código de esta aplicación está licenciado bajo los términos de la Licencia de Software Público (Chile) (más información [http://www.softwarepublico.cl](http://www.softwarepublico.cl)).

### Configuración de la plataforma
#### Framework
- Cambiar el nombre del archivo de configuración del framework que se encuentra dentro de la carpeta "application/config" de "config.sample.php" a "config.php"
#### Base de datos
- Crear una base de datos para la plataforma
- Cargar la estructura inicial del archivo "sql/estructura.sql"
- Cargar los datos iniciales del archivo "sql/datos.sql"
- Cambiar el nombre del archivo de configuración de base de datos que se encuentra dentro de la carpeta "application/config" de "database.sample.php" a "database.php"
- Editar el archivo "database.php" y actualizar los valores con los de su configuración, normalmente se deben editar sólo los campos "username, password, database"
#### Aplicación de parches
- Aplicar los últimos parches a base de datos situandose en la raiz de la aplicación y ejecutando el comando: php index.php migration migrate