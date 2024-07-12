# ОПИСАНИЕ 

• Symfony 6.2
• PHP 8.2
• MySQL 8
• Nginx
• Docker


<summary>Взаимодействие с API:</summary>
<details>
  
- `book/create/{book_json}` Принимает JSON строку содержащую title, releaseDate, bookPublisher, bookAuthor.
- `book/all` Возвращает JSON (поля книг, авторы, издатели).
- `book/delete/{id}` Принимает id книги.

- `author/create/{author_json}` Принимает JSON строку содержащую name, surname, books_ids[].
- `author/delete/{id}` Принимает id автора.

- `publisher/create/{publisher_json}` Принимает JSON строку содержащую name, address, books_ids[].
- `publisher/update/{publisher_json}` Принимает JSON строку содержащую (опционально) name, (опционально) address, (опционально) books_ids[].
- `publisher/delete/{id}` Принимает id издателя.
</details>

<summary>Команды консоли:</summary>
<details>
  - CleanupAuthorsCommand Команда по удалению всех авторов, у которых нет книг
  - TestDataGen Команда по наполнению БД тестовыми данными (несколько авторов/книг/издательств) 
</details>

<summary>Как поднять:</summary>
<details>
  
- Репозиторий скачать и поместить в домашнюю директорию пользователя 
- Настраиваем `.env`
- Запускаем билд `docker-compose up -d --build`
- Делаем миграции `php bin/console doctrine:migrations:migrate`

Стандартный url `http://127.0.0.1`
</details>

<summary>Тестовое задание</summary>
<details>
Тестовое задание

Требования
• Symfony 6 или 7
• Doctrine ORM
• Без нативных запросов SQL
• MySQL
• Документация по установке и запуску (можно в readme.md)

Спецификация
Сущности:
• Книга (наименование, год издания, издатель (MtO), автор(MtM))
• Автор (имя, фамилия, книги (MtM))
• Издатель (наименование, адрес, книги (OtM))

HTTP API (пользовательские интерфейсы не нужны):
• Получение всех книг (помимо полей книги, возвращать фамилию автора и наименование издательства)
• Создание нового автора
• Создание книги с привязкой к существующему автору
• Редактирование издателя
• Удаление книги/автора/издателя

Symfony команды:
• Команда по наполнению БД тестовыми данными (несколько авторов/книг/издательств)
• Команда по удалению всех авторов, у которых нет книг
</details>
