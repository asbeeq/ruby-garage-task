# Ruby Garage TaskList

Тестовое задание для курса "Практический курс подготовки Ruby/Rails разработчиков" 
## Серверная часть
Серверная часть написана на PHP без использования фреймворков. Использовался паттерн MVC.

Для реализации роутинга использовался [nikic/FastRoute](https://github.com/nikic/FastRoute)
##### Структура директорий
```
|- app              Директория основных настроек приложения
    |- config       Директория с конфигурационными файлами
|- controller       Директория контроллеров проектов
|- core             Директория с основными классами проекта
|- libs             Директория с дополнительными библиотеками
|- model            Директория с моделями проекта
|- sql-dump         Директория с дампом БД
|- public           Публичная директория
    |- css          Директория с файлами css
    |- fonts        Директория со шрифтами
    |- images       Директория со статическими изображениями
    |- js           Директория с JavaScript файлами
|- view             Директория с видами страниц
    |- layouts      Директория с Основным шаблоном
    |- templetes    Диреккория с шаблонами страниц
```
## Фронтэнд
На фронтэнде использовались
* Bootdstrap
* JQuery
* JQuery-UI - для реализации сортировки задач
* [DateTimePicker](https://xdsoft.net/jqplugins/datetimepicker/) - для реализации выбора дедлайна

## База данных
##### Структура БД
```
    +----------------------------------+
    | Tables                           |
    +----------------------------------+
    | prioritys                        |
    | projects                         |
    | tasks                            |
    | users                            |
    +----------------------------------+
    mysql> describe prioritys;
    +-------+------------------+------+-----+---------+----------------+
    | Field | Type             | Null | Key | Default | Extra          |
    +-------+------------------+------+-----+---------+----------------+
    | id    | int(10) unsigned | NO   | PRI | NULL    | auto_increment |
    | name  | varchar(40)      | NO   |     | NULL    |                |
    +-------+------------------+------+-----+---------+----------------+
    mysql> describe projects;
    +---------+------------------+------+-----+---------+----------------+
    | Field   | Type             | Null | Key | Default | Extra          |
    +---------+------------------+------+-----+---------+----------------+
    | id      | int(10) unsigned | NO   | PRI | NULL    | auto_increment |
    | name    | varchar(255)     | NO   |     | NULL    |                |
    | user_id | int(10) unsigned | NO   | MUL | NULL    |                |
    +---------+------------------+------+-----+---------+----------------+
    mysql> describe tasks;
    +-------------+------------------+------+-----+---------+----------------+
    | Field       | Type             | Null | Key | Default | Extra          |
    +-------------+------------------+------+-----+---------+----------------+
    | id          | int(10) unsigned | NO   | PRI | NULL    | auto_increment |
    | name        | varchar(255)     | NO   |     | NULL    |                |
    | sort_order  | int(11)          | NO   |     | NULL    |                |
    | priority_id | int(10) unsigned | NO   | MUL | 1       |                |
    | is_done     | tinyint(1)       | NO   |     | 0       |                |
    | project_id  | int(10) unsigned | NO   | MUL | NULL    |                |
    | deadline    | datetime         | YES  |     | NULL    |                |
    +-------------+------------------+------+-----+---------+----------------+
    mysql> describe users;
    +---------------+------------------+------+-----+---------+----------------+
    | Field         | Type             | Null | Key | Default | Extra          |
    +---------------+------------------+------+-----+---------+----------------+
    | id            | int(10) unsigned | NO   | PRI | NULL    | auto_increment |
    | login         | varchar(60)      | NO   | MUL | NULL    |                |
    | email         | varchar(120)     | NO   |     | NULL    |                |
    | password_hash | varchar(72)      | NO   |     | NULL    |                |
    +---------------+------------------+------+-----+---------+----------------+
```
## Список реализованых и не реализованых требований
####Functional requirements
* I want to be able to create/update/delete projects - **реализовано**
* I want to be able to add tasks to my project - **реализовано**
* I want to be able to update/delete tasks - **реализовано**
* I want to be able to prioritize tasks into a project - **реализовано** (предусмотрено 4 типа приоритетов задач: важное и срочное, не важное и срочное, важное не срочное, не важное не срочное)
* I want to be able to choose deadline for my task - **реализовано**
* I want to be able to mark a task as 'done' - **реализовано**
####Additional functionality
* It should work like one page WEB application and should use AJAX technology, load and submit data without reloading a page. - **реализовано** (Добавление, редактирование и удаление задач происходит через AJAX)
* It should have user authentication solution and a user should only have access to their own projects and tasks. - **реализовано** (регистрация и аутентификация не используют AJAX)
* It should have automated tests for the all functionality - **не реализовано**

## SQL task
#####Given tables:
* tasks (id, name, status, project_id)
```mysql
SELECT tasks.id, tasks.name, priorities.name as priority, project_id 
FROM tasks 
INNER JOIN priorities 
ON priority_id = priorities.id

```
* projects (id, name)
```mysql
SELECT id, name 
FROM projects
```
##### Write the queries for:
* get all statuses, not repeating, alphabetically ordered
```mysql
SELECT priorities.name as name 
FROM tasks 
INNER JOIN priorities 
ON priorities.id = priority_id 
GROUP BY name 
ORDER BY name ASC
```
* get the count of all tasks in each project, order by tasks count descending
```mysql
SELECT projects.name as project, COUNT(project_id) as task_count 
FROM tasks 
INNER JOIN projects 
ON projects.id = project_id 
GROUP BY project_id 
ORDER BY task_count DESC
```
* get the count of all tasks in each project, order by projects names
```mysql
SELECT projects.name as project, COUNT(project_id) as task_count 
FROM tasks 
INNER JOIN projects 
ON projects.id = project_id 
GROUP BY project_id 
ORDER BY project ASC
```
* get the tasks for all projects having the name beginning with “N” letter
```mysql
SELECT *
FROM tasks
WHERE name LIKE 'N%'
```
* get the list of all projects containing the ‘a’ letter in the middle of the name, and show the tasks count near each project. Mention that there can exist projects without tasks and tasks with project_id=NULL
```mysql
SELECT projects.name as project, COUNT(tasks.id) as tasks
FROM projects
LEFT JOIN tasks
ON projects.id = tasks.project_id
WHERE projects.name LIKE '%a%'
GROUP BY project
```
* get the list of tasks with duplicate names. Order alphabetically
```mysql
SELECT name, COUNT(*) as count
FROM tasks
GROUP BY name
HAVING count > 1
ORDER BY name
```
* get the list of tasks having several exact matches of both name and status, from the project ‘Garage’. Order by matches count
```mysql
SELECT tasks.name, COUNT(*) as count
FROM tasks
INNER JOIN projects
ON projects.id = project_id
WHERE projects.name LIKE 'Garage'
GROUP BY name, priority_id
HAVING count > 1
ORDER BY name
```
* get the list of project names having more than 10 tasks in status ‘completed’. Order by project_id
```mysql
SELECT projects.id as id, projects.name as project, COUNT(tasks.id) as count
FROM projects
INNER JOIN tasks
ON projects.id = project_id
WHERE tasks.is_done = 1
GROUP BY id
ORDER BY id
```