# Запуск проект
```bash
make run
```
# Остановка проекта
```bash
make stop
```
# Отправка сообщений в очередь
```bash
make push
```
# Файл с урлами
```bash
cat ./storage/urls
```
# Урл вывода результата
http://localhost:8090/
# Структура проекта
```
├── docker                                          # Каталог с настройками docker сервисов
│    ├── .env                                       # env для docker compose
│    ├── docker-compose.yml                         #
│    ├── clickhouse                                 #
│    │    ├── config.xml                            # конфиг
│    │    ├── init-db.sh                            # команды которые выполняются при старте проекта
│    │    └── log                                   # логи
│    │        ├── clickhouse-server.err.log         #
│    │        └── clickhouse-server.log             #
│    ├── db                                         #
│    │    ├── init.sql                              # команды которые выполняются при старте проекта
│    │    └── my.cnf                                # конфиг
│    ├── nginx                                      #
│    │    ├── def.conf                              # конфиг
│    │    └── Dockerfile                            #
│    ├── php                                        #
│    │    ├── conf                                  # конфиг
│    │    └── Dockerfile                            #
│    └── supervisor                                 #
│        └── supervisord.conf                       # конфиг
├── src                                             # Код проекта
│    ├── .env                                       # env проекта
│    ├── base                                       # Базовые классы
│    │    ├── Config.php                            # Класс разбора .env файла
│    │    ├── daemon                                # Реализация демонизизованного скрпита
│    │    │    ├── DaemonAbstract.php               #
│    │    │    └── DaemonInterface.php              #
│    │    ├── db                                    # Настройка коннектов к бд
│    │    │    ├── ClickhouseConnection.php         #
│    │    │    └── MysqlConnection.php              #
│    │    ├── Logger.php                            # Логер 
│    │    └── queue                                 # Настройка коннектов к кролику
│    │        └── RabbitConnection.php              #
│    ├── public                                     # Публичные скрипты
│    │    └── index.php                             # Скрипт доступный через nginx
│    ├── scripts                                    # Консольные скрипты
│    │    ├── consumer.php                          # Консьюмер обработки сообщений из кролика
│    │    ├── healthcheck.php                       # Проверка работоспособности ифраструктуры проекта
│    │    └── publisher.php                         # Паблишер сообщений в очередь 
│    ├── services                                   # Помойка с логическими классами
│    │    ├── Consumer.php                          # Логика работы консьюмера
│    │    ├── DbStorage.php                         # Логика работы с бд
│    │    ├── FileParser.php                        # Логика работы с файлами
│    │    ├── HtmlPresenter.php                     # Логика вывода хтмл
│    │    ├── Publisher.php                         # Логика паблишера
│    │    └── UrlParser.php                         # Логика парса урл
│    └── templates                                  # Хтмл шаблоны
│        └── index.php                              #
├── storage                                         # 
│    ├── logs                                       # Логи
│    └── urls                                       # Файл с урлами
├── Makefile                                        # Шорткаты команд
├── README.md                                       #
├── composer.json                                   #
```