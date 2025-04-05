<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

// Include the sentiment analysis function
include 'sentiment.php';

// RSS feed URLs for different categories
$feeds = [
    'general' => [
        'url' => 'https://timesofindia.indiatimes.com/rssfeedstopstories.cms',
        'source' => 'Times of India'
    ],
    'business' => [
        'url' => 'https://timesofindia.indiatimes.com/rssfeeds/1898055.cms',
        'source' => 'Times of India'
    ],
    'sports' => [
        'url' => 'https://timesofindia.indiatimes.com/rssfeeds/4719148.cms',
        'source' => 'Times of India'
    ],
    'entertainment' => [
        'url' => 'https://www.thehindu.com/entertainment/feeder/default.rss',
        'source' => 'The Hindu'
    ],
    'technology' => [
        'url' => 'https://timesofindia.indiatimes.com/rssfeeds/66949542.cms',
        'source' => 'Times of India'
    ]
];

// Source names for different categories
$sourceNames = [
    'general' => 'Times of India',
    'business' => 'Times of India',
    'sports' => 'Times of India',
    'entertainment' => 'The Hindu',
    'technology' => 'Times of India'
];

function fetchRSSFeed($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $response = curl_exec($ch);
    
    if (curl_errno($ch)) {
        throw new Exception('RSS feed request failed: ' . curl_error($ch));
    }
    
    curl_close($ch);
    return $response;
}

function parseRSSFeed($xmlString, $category) {
    global $sourceNames;
    
    $xml = simplexml_load_string($xmlString);
    if ($xml === false) {
        throw new Exception('Failed to parse RSS feed');
    }

    $articles = [];
    foreach ($xml->channel->item as $item) {
        // Extract image URL using multiple methods
        $image = '';
        
        // Method 1: Check for media:content
        if (isset($item->children('media', true)->content)) {
            $image = (string)$item->children('media', true)->content->attributes()->url;
        }
        
        // Method 2: Check for content:encoded
        if (empty($image) && isset($item->children('content', true)->encoded)) {
            preg_match('/<img[^>]+src="([^">]+)"/', $item->children('content', true)->encoded, $matches);
            if (!empty($matches[1])) {
                $image = $matches[1];
            }
        }
        
        // Method 3: Check description for images
        if (empty($image) && isset($item->description)) {
            // Try to find image in description
            preg_match('/<img[^>]+src="([^">]+)"/', $item->description, $matches);
            if (!empty($matches[1])) {
                $image = $matches[1];
            }
            
            // Try to find image URL without img tag
            if (empty($image)) {
                preg_match('/(https?:\/\/[^"\']+\.(?:jpg|jpeg|png|gif))/i', $item->description, $matches);
                if (!empty($matches[1])) {
                    $image = $matches[1];
                }
            }
        }
        
        // Method 4: Check for enclosure
        if (empty($image) && isset($item->enclosure)) {
            $image = (string)$item->enclosure->attributes()->url;
        }
        
        // Method 5: Check for image tag
        if (empty($image) && isset($item->image)) {
            $image = (string)$item->image;
        }
        
        // Clean up image URL if found
        if (!empty($image)) {
            // Remove any query parameters that might cause issues
            $image = preg_replace('/\?.*$/', '', $image);
            // Ensure URL is absolute
            if (strpos($image, 'http') !== 0) {
                $image = 'https:' . $image;
            }
        }

        // Get the title and description for sentiment analysis
        $title = (string)$item->title;
        $description = strip_tags((string)$item->description);
        
        // Combine title and description for better sentiment analysis
        $textForAnalysis = $title . ' ' . $description;
        
        // Calculate sentiment score
        $sentiment_score = analyzeSentiment($textForAnalysis);

        $articles[] = [
            'title' => $title,
            'description' => $description,
            'url' => (string)$item->link,
            'image' => $image,
            'publishedAt' => (string)$item->pubDate,
            'source' => $sourceNames[$category],
            'category' => $category,
            'sentiment_score' => $sentiment_score
        ];
    }

    return $articles;
}

// Get parameters from request
$category = isset($_GET['category']) ? $_GET['category'] : 'general';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$pageSize = 12;

// Validate category
if (!isset($feeds[$category])) {
    $category = 'general';
}

try {
    // Fetch and parse RSS feed
    $rssUrl = $feeds[$category]['url'] ?? $feeds['general']['url'];
    $rssContent = fetchRSSFeed($rssUrl);
    $articles = parseRSSFeed($rssContent, $category);
    
    // Calculate pagination
    $totalArticles = count($articles);
    $totalPages = ceil($totalArticles / $pageSize);
    $startIndex = ($page - 1) * $pageSize;
    $paginatedArticles = array_slice($articles, $startIndex, $pageSize);
    
    // Return success response
    echo json_encode([
        'status' => 'success',
        'articles' => $paginatedArticles,
        'totalPages' => $totalPages,
        'currentPage' => $page
    ]);
    
} catch (Exception $e) {
    // Return error response
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
} 