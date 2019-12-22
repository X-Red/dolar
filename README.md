# dolar
Extrae el valor del dolar en pesos chilenos desde el sitio http://mindicador.cl y la guarda en una base de datos MySQL.

Comienza desde la fecha actual y obtiene los datos que el web service entrega, si no hay datos se detiene.

El script se ejecuta con

php dolar.php [fecha en formato dd-mm-yyy]

Ejemplo: php dolar.php 20-12-2019

Se debe crear una base de datos en MySQL y crear la tabla dolar utilizando el script que esta en la carpeta sql.
