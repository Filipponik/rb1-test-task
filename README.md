# Тестовое задание для RB1
Были использованы PHP, JS, MySQL, ReadBeanPHP, Chart.js, Tailwind.css

## Установка
1. Склонировать репозиторий
```
git clone https://github.com/Filipponik/rb1-test-task.git
```
2. Создать БД в MySQL
3. Импортировать [скрипт базы данных sql.sql](sql.sql)
3. Настроить подключение RedBeanPHP к БД в [config.php](config.php) по [этой инструкции](https://www.redbeanphp.com/index.php?p=/connection)

## Использование
1. Подключаем `script.js` на нужную страницу
2. На сервере (в корне сайта) смотрим в корне графики данные по кликам, отдельно по сайтам и отдельно по страницам

## Результат
Посмотреть результат можно [здесь (клиентская часть)](http://filipponik.tk/client_page.html)
и [здесь (серверная часть)](http://filipponik.tk/)

P.S. Использовать для запросов чистый JS мне не особо понравилось :)

Схема базы данных:
![Схема бд](https://user-images.githubusercontent.com/44286080/107145540-63a6a600-6953-11eb-949b-5492baa90a2f.png "Схема базы данных")