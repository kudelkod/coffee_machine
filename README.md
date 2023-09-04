# Coffee machine

## Требования 
```
Для запуска проекта необходимо на рабочей машине иметь Docker и docker-compose.
```

## Запуск приложения
```
1) docker-compose up -d 
2) docker-compose exec app composer install 
3) docker-compose exec app composer dump-autoload
4) docker-compose exec app php artisan migrate --seed
```

## Описание методов api:
``Приложени доступно по адресу http://localhost/api/``
```
1) [GET] /coffee/create - Метод для отправки запроса на кофе в очередь;
2) [POST] /coffee/machine/refuel - Метод для дозаправки кофемашины (кофе и вода на 100%) (P.S. без параметров)!!!!!;
3) [GET] /coffee/machine/status - Метод для получения статуса кофемашины;
4) [GET] /coffee/machine/reminder - Метод для получения остатка воды и кофе в кофемашине;
5) [GET] /coffee/machine/reminder_cups - Метод для получения остатка воды и кофе (в чашках кофе) в кофемашине;
```
