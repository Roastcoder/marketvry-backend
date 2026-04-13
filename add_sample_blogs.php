<?php
require_once __DIR__ . '/config/database.php';

$_ENV = parse_ini_file(__DIR__ . '/.env');

$db = new Database();
$conn = $db->connect();

$sampleBlogs = [
    [
        'title' => '10 Digital Marketing Trends to Watch in 2024',
        'excerpt' => 'Stay ahead of the curve with these emerging trends that will shape the digital marketing landscape in 2024.',
        'content' => "The digital marketing landscape is constantly evolving. Here are the top 10 trends you need to watch:\n\n1. AI-Powered Marketing Automation\nArtificial intelligence is revolutionizing how businesses approach marketing. From chatbots to predictive analytics, AI tools are making campaigns more efficient and personalized.\n\n2. Video Content Dominance\nShort-form video content continues to dominate social media platforms. Brands that embrace video marketing see higher engagement rates and better ROI.\n\n3. Voice Search Optimization\nWith the rise of smart speakers and voice assistants, optimizing for voice search is becoming crucial for SEO success.\n\n4. Personalization at Scale\nConsumers expect personalized experiences. Use data analytics to deliver tailored content to your audience.\n\n5. Social Commerce\nSocial media platforms are becoming shopping destinations. Integrate e-commerce features into your social strategy.\n\nStay updated with these trends to remain competitive in the digital landscape!",
        'category' => 'Digital Marketing',
        'author' => 'Marketing Team',
        'image_url' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=800&h=500&fit=crop'
    ],
    [
        'title' => 'The Complete Guide to SEO in 2024',
        'excerpt' => 'Everything you need to know about optimizing your website for search engines this year.',
        'content' => "Search Engine Optimization (SEO) remains crucial for online visibility. Here's your complete guide:\n\nUnderstanding SEO Basics\nSEO is the practice of optimizing your website to rank higher in search engine results. It involves both technical and creative elements.\n\nKey SEO Strategies:\n- Keyword Research: Find the right keywords your audience is searching for\n- On-Page SEO: Optimize your content, meta tags, and URLs\n- Technical SEO: Improve site speed, mobile-friendliness, and crawlability\n- Link Building: Earn quality backlinks from reputable websites\n- Content Quality: Create valuable, engaging content that answers user queries\n\nMobile-First Indexing\nGoogle now primarily uses the mobile version of your site for indexing and ranking. Ensure your site is mobile-responsive.\n\nCore Web Vitals\nPage experience metrics like loading speed, interactivity, and visual stability are now ranking factors.\n\nImplement these strategies to improve your search rankings and drive organic traffic!",
        'category' => 'SEO',
        'author' => 'SEO Specialist',
        'image_url' => 'https://images.unsplash.com/photo-1432888622747-4eb9a8efeb07?w=800&h=500&fit=crop'
    ],
    [
        'title' => 'Building a Strong Brand Identity',
        'excerpt' => 'Learn how to create a memorable brand that resonates with your target audience.',
        'content' => "A strong brand identity is essential for business success. Here's how to build one:\n\nDefine Your Brand Purpose\nWhat does your brand stand for? What problems do you solve? Your purpose should guide all branding decisions.\n\nKnow Your Audience\nUnderstand your target customers' needs, preferences, and pain points. Create buyer personas to guide your strategy.\n\nDevelop Your Visual Identity\n- Logo: Create a memorable, versatile logo\n- Color Palette: Choose colors that reflect your brand personality\n- Typography: Select fonts that are readable and on-brand\n- Imagery: Use consistent visual styles across all platforms\n\nCraft Your Brand Voice\nHow does your brand communicate? Professional? Friendly? Authoritative? Maintain consistency across all channels.\n\nBuild Brand Consistency\nEnsure all touchpoints - website, social media, packaging, customer service - reflect your brand identity.\n\nTell Your Story\nShare your brand's journey, values, and mission. Authentic storytelling creates emotional connections with customers.\n\nA strong brand identity differentiates you from competitors and builds customer loyalty!",
        'category' => 'Branding',
        'author' => 'Brand Strategist',
        'image_url' => 'https://images.unsplash.com/photo-1561070791-2526d30994b5?w=800&h=500&fit=crop'
    ],
    [
        'title' => 'Web Design Best Practices for 2024',
        'excerpt' => 'Design principles that turn visitors into customers and boost your conversion rates.',
        'content' => "Great web design combines aesthetics with functionality. Follow these best practices:\n\nUser-Centered Design\nPut your users first. Design with their needs, goals, and behaviors in mind.\n\nResponsive Design\nYour website must work flawlessly on all devices - desktop, tablet, and mobile.\n\nFast Loading Speed\nOptimize images, minimize code, and use caching to ensure quick page loads. Users abandon slow sites.\n\nClear Navigation\nMake it easy for visitors to find what they need. Use intuitive menus and clear labels.\n\nStrong Visual Hierarchy\nGuide users' attention with size, color, and placement. Important elements should stand out.\n\nAccessibility\nDesign for all users, including those with disabilities. Use proper contrast, alt text, and keyboard navigation.\n\nWhite Space\nDon't clutter your design. White space improves readability and creates a clean, professional look.\n\nCall-to-Action (CTA)\nUse clear, compelling CTAs that guide users toward desired actions.\n\nConsistent Branding\nMaintain visual consistency across all pages to reinforce brand identity.\n\nImplement these practices to create websites that engage users and drive conversions!",
        'category' => 'Web Design',
        'author' => 'Design Team',
        'image_url' => 'https://images.unsplash.com/photo-1467232004584-a241de8bcf5d?w=800&h=500&fit=crop'
    ]
];

try {
    $stmt = $conn->prepare("INSERT INTO blogs (title, excerpt, content, category, author, image_url) VALUES (?, ?, ?, ?, ?, ?)");
    
    foreach ($sampleBlogs as $blog) {
        $stmt->execute([
            $blog['title'],
            $blog['excerpt'],
            $blog['content'],
            $blog['category'],
            $blog['author'],
            $blog['image_url']
        ]);
        echo "✓ Added: {$blog['title']}\n";
    }
    
    echo "\n✅ Successfully added " . count($sampleBlogs) . " sample blogs!\n";
    
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
