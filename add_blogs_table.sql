-- Run this SQL to add blogs table
USE marketvry;

CREATE TABLE IF NOT EXISTS blogs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    excerpt TEXT NOT NULL,
    content LONGTEXT NOT NULL,
    image_url VARCHAR(500),
    category VARCHAR(100),
    author VARCHAR(100) DEFAULT 'Admin',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert sample blog
INSERT INTO blogs (title, excerpt, content, category, author) VALUES 
('Welcome to Our Blog', 'This is our first blog post. Stay tuned for more updates!', 'Welcome to our blog! We will be sharing insights, tips, and updates about digital marketing, web development, and more. Stay tuned for exciting content!', 'General', 'Admin');
