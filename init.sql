CREATE TABLE users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name VARCHAR(255) NOT NULL UNIQUE, 
    password VARCHAR(255) NOT NULL
);



INSERT INTO users (name, password) VALUES ('John Doe', 'dummyPassword');
