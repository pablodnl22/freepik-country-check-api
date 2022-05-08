# freepik-country-check-api
Ejercicio propuesto por Freepik donde se plantea una API para comprobar diferentes criterios sobre un pais.
Implementada utilizando Symfony 6.0, Php 8.1 y Nginx como balanceador

## Instalación

```sh
docker-compose up -d --build
docker exec -it fpm_country_check bin/composer.phar install
```

Para ejecutar todos los test usando un script de Composer fuera del docker

```sh
docker exec -it fpm_country_check bin/composer.phar tests
```

## Endpoint para comprobar un pais
```sh
http://localhost:8023/country-check/{country-code}
```

## Respuesta
```json
{"result":false,"criteria":{"code":true,"region":true,"population":false,"rival":true}}
```
## Requerimientos
- El parametro `code` debe devolver `true` en caso de que el codigo del pais empiece por vocal.
- El parametro `region` debe devolver `true` en caso de que la region del pais sea Europa.
- El parametro `population` debe devolver `true` en caso de que el pais tenga una población mayor o igual 50.000.000, en caso de ser un pais asiático debe devolver `true` si la población es mayor o igual a 80.000.000.
- El parametro `rival` debe devolver `true` en caso de que la población del pais sea mayor a la de Noruega.
- El parametro `result` debe devolver `true` en caso de que todos los parametros anteriores sean validos.
