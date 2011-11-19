CREATE DATABASE linkshift;

USE linkshift;

CREATE TABLE links (
	id INTEGER AUTO_INCREMENT PRIMARY KEY,
	token VARCHAR(255),
	longurl VARCHAR(2000) );

CREATE TABLE token (
	id INTEGER PRIMARY KEY,
	nexttoken VARCHAR(255) );

INSERT INTO token (id, nexttoken) VALUES (1, '1');
