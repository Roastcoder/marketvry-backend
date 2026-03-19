-- Seed Data for Marketvry Database

-- Insert Sample Blogs
INSERT INTO blogs (title, excerpt, content, image_url, category, author) VALUES
('10 Digital Marketing Trends for 2026', 'Stay ahead of the curve with these emerging digital marketing trends that will shape the industry.', 'Digital marketing is constantly evolving. In 2026, we\'re seeing major shifts in AI-powered personalization, voice search optimization, and interactive content. Businesses that adapt to these trends will gain a significant competitive advantage...', 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=800', 'Digital Marketing', 'Admin'),

('The Ultimate Guide to SEO in 2026', 'Master the art of search engine optimization with our comprehensive guide.', 'SEO has become more sophisticated than ever. From Core Web Vitals to E-A-T signals, understanding what Google values is crucial for ranking success. This guide covers everything from technical SEO to content optimization...', 'https://images.unsplash.com/photo-1432888622747-4eb9a8efeb07?w=800', 'SEO', 'Admin'),

('How to Build a High-Converting Website', 'Learn the essential elements that turn visitors into customers.', 'A beautiful website isn\'t enough - it needs to convert. In this article, we explore the psychology of web design, the importance of clear CTAs, mobile optimization, and how to create a seamless user experience that drives conversions...', 'https://images.unsplash.com/photo-1547658719-da2b51169166?w=800', 'Web Development', 'Admin'),

('Social Media Marketing Strategies That Work', 'Boost your brand presence with proven social media tactics.', 'Social media is more than just posting content. It\'s about building relationships, engaging with your audience, and creating value. We share strategies for each major platform including Instagram, LinkedIn, Facebook, and TikTok...', 'https://images.unsplash.com/photo-1611926653458-09294b3142bf?w=800', 'Social Media', 'Admin'),

('WhatsApp Marketing: The Future of Customer Engagement', 'Discover how WhatsApp is revolutionizing business communication.', 'With a 98% open rate, WhatsApp has become the most effective channel for customer communication. Learn how to leverage WhatsApp Business API, automation, and AI chatbots to scale your customer support and marketing efforts...', 'https://images.unsplash.com/photo-1611746872915-64382b5c76da?w=800', 'WhatsApp Marketing', 'Admin');

-- Insert Sample Portfolio Items
INSERT INTO portfolio (title, description, image_url, category, client_name, project_url, technologies) VALUES
('E-commerce Platform Redesign', 'Complete redesign and development of a modern e-commerce platform with improved UX and conversion rates.', 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=800', 'Web Development', 'TechStore Inc', 'https://example.com', 'React, Node.js, MongoDB, Stripe'),

('Digital Marketing Campaign', 'Comprehensive digital marketing campaign that increased leads by 300% in 6 months.', 'https://images.unsplash.com/photo-1557804506-669a67965ba0?w=800', 'Digital Marketing', 'GreenLeaf Co', NULL, 'Google Ads, Facebook Ads, SEO'),

('Brand Identity & UI/UX Design', 'Complete brand identity design including logo, color palette, and modern website UI/UX.', 'https://images.unsplash.com/photo-1626785774573-4b799315345d?w=800', 'Branding', 'StartupXYZ', 'https://example.com', 'Figma, Adobe Illustrator'),

('SEO Optimization Project', 'SEO strategy that helped client rank #1 for 15+ competitive keywords.', 'https://images.unsplash.com/photo-1432888622747-4eb9a8efeb07?w=800', 'SEO', 'FoodCo', NULL, 'Technical SEO, Content Strategy, Link Building'),

('WhatsApp Automation System', 'AI-powered WhatsApp automation system handling 10,000+ customer queries daily.', 'https://images.unsplash.com/photo-1611746872915-64382b5c76da?w=800', 'WhatsApp Marketing', 'RetailHub', NULL, 'WhatsApp API, Python, AI/ML');
