# News App

A modern, responsive news application that displays news articles from various categories using RSS feeds.

## Features

- Browse news by categories (General, Business, Technology, Sports, Entertainment)
- Search for specific news articles
- Featured news section with highlighted articles
- Responsive design that works on all devices
- Pagination for browsing through multiple pages of news
- Loading indicators for better user experience

## Technologies Used

- HTML5
- CSS3 (with Flexbox and Grid)
- JavaScript (ES6+)
- PHP
- RSS Feeds (for fetching news data)

## Setup Instructions

1. Clone or download this repository to your local machine.
2. Make sure you have a web server with PHP support (like XAMPP, WAMP, or MAMP) installed.
3. Place the project files in your web server's document root (e.g., `htdocs` for XAMPP).
4. Start your web server and MySQL service.
5. The application uses RSS feeds from various sources:
   - India Today for general, sports, entertainment, technology, science, health, and world news
   - The Hindu Business Line for business news
6. Open your browser and navigate to `http://localhost/practice` to view the application.

## Project Structure

```
news-app/
├── api/
│   ├── news.php
│   └── rss_feed.php
├── css/
│   └── style.css
├── js/
│   └── script.js
├── images/
│   └── placeholder.jpg
├── index.php
└── README.md
```

## Usage

- Click on the category links in the navigation to filter news by category.
- Use the search bar to find specific news articles.
- Navigate through pages using the pagination controls at the bottom.
- Click on article titles to read the full article on the source website.

## RSS Feed Sources

This application uses the following RSS feeds:

- India Today: General, sports, entertainment, technology, science, health, and world news
- The Hindu Business Line: Business news

## Implementation Details

The application fetches news directly from RSS feeds for each category:

1. `api/rss_feed.php` - Handles fetching and parsing RSS feeds for each category
2. `api/news.php` - Processes requests for news articles, including search functionality
3. `index.php` - Main application file with the user interface
4. `js/script.js` - JavaScript code for handling user interactions and rendering news articles

## License

This project is licensed under the MIT License - see the LICENSE file for details.

## Acknowledgments

- [India Today](https://www.indiatoday.in/) for providing general news content
- [The Hindu Business Line](https://www.thehindubusinessline.com/) for providing business news content
- [Font Awesome](https://fontawesome.com/) for the icons 