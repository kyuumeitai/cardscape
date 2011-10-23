CREATE TABLE users(
	uid INT AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(15),
	password VARCHAR(32),
	mail VARCHAR(31),
	role ENUM( 'user', 'moderator', 'gamemaker', 'admin' ),
	date TIMESTAMP );

CREATE TABLE comments(
	id INT AUTO_increment PRIMARY KEY,
	user INT,
	card INT,
	parent INT,
	date TIMESTAMP,
	text TEXT );

CREATE TABLE posting(
	id INT AUTO_increment PRIMARY KEY,
	user INT,
	card INT,
	revision INT,
	text VARCHAR(255) );

CREATE TABLE official(
	id INT AUTO_INCREMENT PRIMARY KEY,
	revision INT DEFAULT 0,
	dev_id INT,
	img_url VARCHAR(63),
	promotion TIMESTAMP );

CREATE TABLE last_revision(
	card_id INT PRIMARY KEY,
	revision INT );

CREATE TABLE history(
	id INT AUTO_INCREMENT PRIMARY KEY,
	user INT,
	card INT,
	action VARCHAR(31),
	date TIMESTAMP );

