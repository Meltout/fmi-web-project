CREATE TABLE users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name VARCHAR(255) NOT NULL UNIQUE, 
    password VARCHAR(255) NOT NULL
);

CREATE TABLE table_list (
	id INTEGER PRIMARY KEY AUTOINCREMENT,
    name VARCHAR(255) NOT NULL UNIQUE,
	ownerID INTEGER,
	width INTEGER NOT NULL CHECK (width >= 1 AND width <= 8),
    height INTEGER NOT NULL CHECK (height >= 1 AND height <= 8),
	FOREIGN KEY (ownerID) REFERENCES users(id)
);

CREATE TABLE table_cells (
    tableID INTEGER,
    ownerID INTEGER,
	value VARCHAR(255),
    cellX INTEGER NOT NULL,
    cellY INTEGER NOT NULL,
    FOREIGN KEY (tableID) REFERENCES table_list(id),
    FOREIGN KEY (ownerID) REFERENCES users(id),
	CONSTRAINT unique_cell_owner UNIQUE (ownerID, cellX, cellY)
);

INSERT INTO users (name, password) VALUES ('John Doe', 'dummyPassword');

INSERT INTO table_list (name, ownerID, width, height) VALUES ('Johns table' , 1, 5, 5);

INSERT INTO table_cells (tableID, ownerID, value, cellX, cellY) VALUES (1, 2, 'cveti', 0, 0);
