-- Execute this script in phpMyAdmin or your SQL client to add the new CMS tables.

CREATE TABLE IF NOT EXISTS services (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(100) NOT NULL UNIQUE,
    description TEXT NOT NULL,
    icon VARCHAR(100),
    image_url VARCHAR(500),
    features TEXT,
    content LONGTEXT,
    category VARCHAR(100) DEFAULT 'General',
    status VARCHAR(50) DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS settings (
    setting_key VARCHAR(100) PRIMARY KEY,
    setting_value TEXT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Default Settings
INSERT IGNORE INTO settings (setting_key, setting_value) VALUES 
('site_name', 'Marketvry'),
('contact_email', 'contact@marketvry.com'),
('contact_phone', '+44 0000 000000'),
('hero_title', 'Scale Your Brand With Impact'),
('hero_subtitle', 'We craft digital experiences that drive growth and elevate your brand presence in the modern market.');

-- Default Services
INSERT IGNORE INTO services (title, slug, description, icon, image_url, features, category) VALUES
('Digital Marketing', 'digital-marketing', 'Data-driven campaigns that maximize ROI and drive qualified traffic to your business.', 'TrendingUp', 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=800&h=600&fit=crop', '["Google Ads Management", "Meta Ads (Facebook & Instagram)", "Performance Marketing", "E-commerce Marketing", "YouTube Marketing"]', 'Marketing'),
('Web Development', 'web-development', 'Custom websites and web applications built with cutting-edge technologies.', 'Code', 'https://images.unsplash.com/photo-1547658719-da2b51169166?w=800&h=600&fit=crop', '["React & PHP Development", "Shopify & WordPress Sites", "Static & Dynamic Websites", "Landing Page Design", "Website Maintenance"]', 'Development'),
('SEO Services', 'seo', 'Boost your visibility and rank higher with our proven SEO strategies.', 'Search', 'https://images.unsplash.com/photo-1432888622747-4eb9a8efeb07?w=800&h=600&fit=crop', '["Search Engine Optimization", "Social Media Optimization", "Google My Business Optimization", "Local SEO", "Technical SEO Audit"]', 'Marketing'),
('WhatsApp Marketing', 'whatsapp-marketing', 'Reach customers instantly with WhatsApp\'s 98% open rate and AI-powered automation.', 'MessageCircle', 'https://images.unsplash.com/photo-1611746872915-64382b5c76da?w=800&h=600&fit=crop', '["Official WhatsApp API Service", "Unofficial WhatsApp Software", "WhatsApp Virtual Number", "AI WhatsApp Automation", "AI Video Sending"]', 'Communication');
