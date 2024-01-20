-- Create a table named 'users'
CREATE TABLE users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL
);

-- Insert some sample data
INSERT INTO users (name) VALUES
    ('John Doe'),
    ('Jane Doe'),
    ('Alice'),
    ('Bob');
