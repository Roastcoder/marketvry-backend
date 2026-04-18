<?php
require_once __DIR__ . '/config/database.php';

$db = new Database();
$conn = $db->connect();

if (!$conn) {
    die("Database connection failed\n");
}

$services = [
    [
        "title" => "Digital Marketing",
        "slug" => "digital-marketing",
        "description" => "Data-driven campaigns that maximize ROI and drive qualified traffic to your business.",
        "image_url" => "https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=800&h=600&fit=crop",
        "features" => json_encode(["Google Ads Management", "Meta Ads (Facebook & Instagram)", "Performance Marketing", "E-commerce Marketing", "YouTube Marketing"]),
        "category" => "Marketing",
        "status" => "active"
    ],
    [
        "title" => "Web Development",
        "slug" => "web-development",
        "description" => "Custom websites and web applications built with cutting-edge technologies.",
        "image_url" => "https://images.unsplash.com/photo-1547658719-da2b51169166?w=800&h=600&fit=crop",
        "features" => json_encode(["React & PHP Development", "Shopify & WordPress Sites", "Static & Dynamic Websites", "Landing Page Design", "Website Maintenance"]),
        "category" => "Development",
        "status" => "active"
    ],
    [
        "title" => "SEO Services",
        "slug" => "seo",
        "description" => "Boost your visibility and rank higher with our proven SEO strategies.",
        "image_url" => "https://images.unsplash.com/photo-1432888622747-4eb9a8efeb07?w=800&h=600&fit=crop",
        "features" => json_encode(["Search Engine Optimization", "Social Media Optimization", "Google My Business Optimization", "Local SEO", "Technical SEO Audit"]),
        "category" => "SEO",
        "status" => "active"
    ],
    [
        "title" => "WhatsApp Marketing",
        "slug" => "whatsapp-marketing",
        "description" => "Reach customers instantly with WhatsApp's 98% open rate and AI-powered automation.",
        "image_url" => "https://images.unsplash.com/photo-1611746872915-64382b5c76da?w=800&h=600&fit=crop",
        "features" => json_encode(["Official WhatsApp API Service", "Unofficial WhatsApp Software", "WhatsApp Virtual Number", "AI WhatsApp Automation", "AI Video Sending"]),
        "category" => "Automation",
        "status" => "active"
    ],
    [
        "title" => "Bulk Messaging Services",
        "slug" => "bulk-messaging",
        "description" => "Mass communication solutions including SMS, Email, and Voice Call campaigns.",
        "image_url" => "https://images.unsplash.com/photo-1596526131083-e8c633c948d2?w=800&h=600&fit=crop",
        "features" => json_encode(["DLT Brand Registration", "SIM-Based SMS", "Bulk Email Marketing", "Database Marketing", "Bulk Voice Call DTMF"]),
        "category" => "Messaging",
        "status" => "active"
    ],
    [
        "title" => "AI Agent Services",
        "slug" => "ai-agent",
        "description" => "Intelligent AI agents that automate customer support, lead qualification, and tasks 24/7.",
        "image_url" => "https://images.unsplash.com/photo-1677442136019-21780ecad995?w=800&h=600&fit=crop",
        "features" => json_encode(["Intelligent Chatbots", "24/7 Customer Support", "Lead Qualification", "Task Automation", "Multi-Channel Deployment"]),
        "category" => "AI",
        "status" => "active"
    ]
];

foreach ($services as $s) {
    try {
        $stmt = $conn->prepare("INSERT INTO services (title, slug, description, image_url, features, category, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $s['title'],
            $s['slug'],
            $s['description'],
            $s['image_url'],
            $s['features'],
            $s['category'],
            $s['status']
        ]);
        echo "Inserted: {$s['title']}\n";
    } catch (PDOException $e) {
        echo "Error inserting {$s['title']}: " . $e->getMessage() . "\n";
    }
}
echo "Seeding complete.\n";
