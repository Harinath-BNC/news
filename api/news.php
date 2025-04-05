<?php
// Set headers for JSON response
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

// Get parameters from request
$category = isset($_GET['category']) ? $_GET['category'] : 'general';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Validate parameters
if ($page < 1) {
    $page = 1;
}

// Include the RSS feed handler
include 'rss_feed.php';

// If search is provided, we'll need to fetch from multiple feeds and filter
if (!empty($search)) {
    // Get all articles from all feeds
    $allArticles = [];
    foreach ($rssFeeds as $feedCategory => $feedUrl) {
        try {
            $rssContent = fetchRSSFeed($feedUrl);
            $articles = parseRSSFeed($rssContent, $feedCategory);
            $allArticles = array_merge($allArticles, $articles);
        } catch (Exception $e) {
            // Continue with other feeds if one fails
            continue;
        }
    }
    
    // Filter articles based on search query
    $searchResults = array_filter($allArticles, function($article) use ($search) {
        $searchLower = strtolower($search);
        return (
            stripos($article['title'], $search) !== false ||
            stripos($article['description'], $search) !== false
        );
    });
    
    // Reset array keys
    $searchResults = array_values($searchResults);
    
    // Calculate pagination
    $totalArticles = count($searchResults);
    $totalPages = ceil($totalArticles / $pageSize);
    $startIndex = ($page - 1) * $pageSize;
    $paginatedArticles = array_slice($searchResults, $startIndex, $pageSize);
    
    // Return success response
    echo json_encode([
        'status' => 'success',
        'articles' => $paginatedArticles,
        'totalPages' => $totalPages,
        'currentPage' => $page
    ]);
    exit;
}

// For category-based browsing, use the regular RSS feed handler
// The rss_feed.php file already handles the response, so we don't need to do anything else
exit; 