<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News App</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <header>
        <div class="container">
            <div class="">
                <h1>News</h1>
            </div>
            <nav>
                <ul>
                    <li><a href="#" class="active" data-category="general">General</a></li>
                    <li><a href="#" data-category="business">Business</a></li>
                    <li><a href="#" data-category="technology">Technology</a></li>
                    <li><a href="#" data-category="sports">Sports</a></li>
                    <li><a href="#" data-category="entertainment">Entertainment</a></li>
                </ul>
            </nav>
            <div class="search-container">
                <input type="text" id="search-input" placeholder="Search news...">
                <button id="search-btn"><i class="fas fa-search"></i></button>
            </div>
        </div>
    </header>

    <main class="container">
        <div class="featured-news">
            <h2>Featured News</h2>
            <div class="featured-container" id="featured-news">
                <!-- Featured news will be loaded here -->
            </div>
        </div>

        <div class="news-container">
            <h2>Latest News</h2>
            <div class="news-grid" id="news-grid">
                <!-- News articles will be loaded here -->
            </div>
            <div class="pagination">
                <button id="prev-page" disabled><i class="fas fa-chevron-left"></i> Previous</button>
                <span id="page-info">Page 1 of 1</span>
                <button id="next-page">Next <i class="fas fa-chevron-right"></i></button>
            </div>
        </div>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2023 NewsApp. All rights reserved.</p>
        </div>
    </footer>

    <div class="loading-spinner" id="loading-spinner">
        <div class="spinner"></div>
    </div>

    <script src="js/script.js"></script>
</body>
</html> 