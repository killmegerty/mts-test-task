# Пререквизиты

```sh
$ composer install
```
```sql
mysql> CREATE DATABASE minenko_konstantin DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci;
mysql> GRANT ALL PRIVILEGES ON minenko_konstantin.* TO minenko_konstantin@localhost IDENTIFIED BY 'minenko_konstantin';
```
```sh
$ mysql -uminenko_konstantin -pminenko_konstantin minenko_konstantin < __sql/minenko_konstantin_2018-05-30.sql
```

# Комментарии

Дамп БД с тестовыми данными в папке __sql/

На всякий , константы для подключения к БД лежат в /src/config.php

Корневая папка для вебсервера - /webroot/

Скрипт для перевода денег - /webroot/transfer-money.php

Пример запроса: /transfer-money.php?fromUserId=1&toUserId=2&amount=10
