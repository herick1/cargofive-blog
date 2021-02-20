# cargofive-blog

------------
Contenido del proyecto:

* una app de blogging.
* Los usuarios pueden hacer login y/o regististrarse.
* Los usuarios logiados pueden crear, actualizar, eliminar y ver todos los blogs.
* Los usuarios no logiados pueden ver los blogs con el estatus "published".
* Los usuarios logiados pueden comentar en un blog.

Demo
------------
Demo de la app. [Show demo](http://cargofive-blog.herokuapp.com/)


Instalación
------------

1. Instalar Laragon
2. Copiar este proyeto dentro de la ruta /www/
3. configurar su .env segun su nombre de su base de datos.
3. Ejecutar en una terminal 
*  `composer install`
*  `php artisan migrate` 


Base de Datos
------------

![](https://github.com/herick1/cargofive-blog/blob/main/public/captures/cargofive.png)

* users (default + role)
* posts (id, author, title, body, slug, published_on, last_modified, status)
* comments (id, on_post, from_user, body, at_time)




