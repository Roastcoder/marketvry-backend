-- Add portfolio table
USE marketvry;

CREATE TABLE IF NOT EXISTS portfolio (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    category VARCHAR(100),
    client VARCHAR(100),
    image_url VARCHAR(500),
    project_url VARCHAR(500),
    technologies TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert sample portfolio items
INSERT INTO portfolio (title, description, category, client, image_url, technologies) VALUES 
('E-commerce Platform', 'Built a modern e-commerce platform with advanced features', 'Web Development', 'TechCorp', 'https://images.unsplash.com/photo-1661956602116-aa6865609028?w=800&h=600&fit=crop', 'React, Node.js, MongoDB'),
('Brand Identity Design', 'Complete brand identity redesign for a startup', 'Branding', 'StartupXYZ', 'https://images.unsplash.com/photo-1634942537034-2531766767d1?w=800&h=600&fit=crop', 'Figma, Illustrator'),
('Mobile App Development', 'iOS and Android app for fitness tracking', 'Mobile Development', 'FitLife', 'https://images.unsplash.com/photo-1512941937669-90a1b58e7e9c?w=800&h=600&fit=crop', 'React Native, Firebase');
