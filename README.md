На хостовой машине добавляем домены в hosts file
(Linux|Mac /etc/hosts)
(Windows %SystemRoot%\system32\drivers\etc\hosts)
```text
127.0.0.1 api-test.loc test.loc
```
Структура папок
-------------------

```
common
config/              contains shared configurations
mail/                contains view files for e-mails
models/              contains model classes used in both api and frontend
tests/               contains tests for common classes    
console
config/              contains console configurations
controllers/         contains console controllers (commands)
migrations/          contains database migrations
models/              contains console-specific model classes
runtime/             contains files generated during runtime
api
config/              contains api configurations
modules/
v1/           api version contains controllers models
controllers/         contains Web controller classes
models/              contains api-specific model classes
runtime/             contains files generated during runtime
tests/               contains tests for api application    
views/               contains view files for the Web application
web/                 contains the entry script and Web resources
backend
config/              contains api configurations
modules/
controllers/         contains Web controller classes
models/              contains api-specific model classes
runtime/             contains files generated during runtime
tests/               contains tests for api application    
views/               contains view files for the Web application
web/                 contains the entry script and Web resources
vendor/                  contains dependent 3rd-party packages
environments/            contains environment-based overrides
```
Добавляем соединение для работы с базой MySQL
---
```
Host: localhost
Database: yii_test
User: root
Password: root
```
Запускаем ./yii migrate
для создания БД и тестовых данных
логин и пароль для админа alex

```
cd api/runtime
ssh-keygen -t rsa -b 4096 -m PEM -f jwtRS256.key
```
# Don't add passphrase (Генерировать ключи без задания пароля)
```
openssl rsa -in jwtRS256.key -pubout -outform PEM -out jwtRS256.key.pub
cat jwtRS256.key
cat jwtRS256.key.pub
```
документация по API по адресу 

```
http://api-test.loc/swagger/v1/alex
```
