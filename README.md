## Tech. task on Symfony by Программный Регион (regium)
Необходимо добавить новый раздел Статьи на сайте. Статьи распределены по категориям, обязательно содержат заголовок, текст статьи, превью (изображение).
Ниже приведена часть кода, которую передал frontend-разработчик:

`POST(category = 'categoryName')`

`Response = JSON(title, description, image) || 'end'`

На стороне backend требуется:
- спроектировать БД для хранения статей;
- передать на фронт 5 последних статей из заданной категории в формате json.

Результат выполнения задания: дамп БД, php-код.


## RUN
git clone

composer install

php bin/console doctrine:migrations:migrate

php bin/console doctrine:fixtures:load

php bin/phpunit