<?php

//CRUD

$dbSource = __DIR__ . '/blogsWithCategories.db';
//Указываем путь к файлу базы данных

if (file_exists($dbSource)) {
	unlink($dbSource);
}
//Удаляем старую базу данных в случае её существования для очистки данных

$db = new PDO("sqlite:$dbSource");

//Подключаем к базе данных SQLite 

$statement = $db->query("DROP TABLE IF EXISTS posts");
$statement = $db->query("DROP TABLE IF EXISTS categories");

//Удаляем таблицы если они существуют

$statement = $db->query('CREATE TABLE IF NOT EXISTS `categories` (
	`id` INTEGER PRIMARY KEY,
	`title` VARCHAR NOT NULL
);');

//Создаём таблицу категорий

$statement = $db->query('CREATE TABLE IF NOT EXISTS `posts` (
	`id` integer primary key,
	`title` VARCHAR NOT NULL,
	`content` TEXT NOT NULL,
	`category_id` INTEGER,
	FOREIGN KEY (category_id) REFERENCES categories(id)
);');

//Создаём таблицу постов

$categories = ['Coding', 'Finance', 'Movies'];
$statement = $db->query("INSERT INTO categories (id, title) VALUES (1, 'Coding'), (2, 'Finance'), (3, 'Movies')");
//Добавляем категории в массив с помощью цикла foreach, который проходится по каждому элементу
//и добавляет в таблицу три категории

$posts = [
	['title' => 'PHP 101',
	'content' => 'PHP is easy to learn but hard to master.',
	'category_id' => 1],
	['title' => 'Saving for the future',
	'content' => 'How to manage your money to make sure you save enough.',
	'category_id' => 2],
	['title' => 'The Tarantino Effect',
	'content' => 'An impact of one director dedicated to his craft.',
	'category_id' => 3],
];

$statement = $db->query("INSERT INTO posts (title, content, category_id) VALUES 	('PHP 101', 'PHP is easy to learn but hard to master.', 1),
('Saving for the future', 'How to manage your money to make sure you save enough.', 2),
('The Tarantino Effect', 'An impact of one director dedicated to his craft.', 3)");

//Создаём массив постов, с помощью цикла foreach проходим по каждому его элементу и заполняем соответствующими значениями

$statement = $db->prepare("INSERT INTO posts (title, content, category_id) values (:title, :content, :category_id)");
$statement->execute([':title' => 'Заголовок 1', ':content' => 'Text text', ':category_id' => 3]);

//Добавляем в таблицу постов пост с названием "Заголовок 1" и содержанием "Text text" с 3-ей категорией

$id = 2;

$statement = $db->prepare("UPDATE posts SET title = :title WHERE id = :id");
$statement->execute([':title' => 'Заголовок 2', ':id' => $id]);

//Обновляем пост с id=2, его название изменится на "Заголовок 2"

$statement = $db->prepare('SELECT * from posts');
$statement->execute();

//Выбираем все посты из таблицы постов

print_r($statement->fetchAll(PDO::FETCH_ASSOC));

//Выводим все посты из ассоциативного массива