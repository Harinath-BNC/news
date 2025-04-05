document.addEventListener('DOMContentLoaded', () => {
    // DOM Elements
    const featuredNewsContainer = document.getElementById('featured-news');
    const newsGrid = document.getElementById('news-grid');
    const categoryLinks = document.querySelectorAll('nav ul li a');
    const searchInput = document.getElementById('search-input');
    const searchBtn = document.getElementById('search-btn');
    const prevPageBtn = document.getElementById('prev-page');
    const nextPageBtn = document.getElementById('next-page');
    const pageInfo = document.getElementById('page-info');
    const loadingSpinner = document.getElementById('loading-spinner');

    // App State
    let currentCategory = 'general';
    let currentPage = 1;
    let totalPages = 1;
    let searchQuery = '';
    let articles = [];

    // Initialize the app
    init();

    // Event Listeners
    categoryLinks.forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            const category = e.target.getAttribute('data-category');
            setActiveCategory(category);
            loadNews(category);
        });
    });

    searchBtn.addEventListener('click', () => {
        searchQuery = searchInput.value.trim();
        if (searchQuery) {
            currentPage = 1;
            loadNews(currentCategory, searchQuery);
        }
    });

    searchInput.addEventListener('keyup', (e) => {
        if (e.key === 'Enter') {
            searchQuery = searchInput.value.trim();
            if (searchQuery) {
                currentPage = 1;
                loadNews(currentCategory, searchQuery);
            }
        }
    });

    prevPageBtn.addEventListener('click', () => {
        if (currentPage > 1) {
            currentPage--;
            loadNews(currentCategory, searchQuery);
        }
    });

    nextPageBtn.addEventListener('click', () => {
        if (currentPage < totalPages) {
            currentPage++;
            loadNews(currentCategory, searchQuery);
        }
    });

    // Functions
    function init() {
        loadNews(currentCategory);
    }

    function setActiveCategory(category) {
        categoryLinks.forEach(link => {
            link.classList.remove('active');
            if (link.getAttribute('data-category') === category) {
                link.classList.add('active');
            }
        });
        currentCategory = category;
    }

    async function loadNews(category, query = '') {
        showLoading();
        
        try {
            const response = await fetch(`api/news.php?category=${category}&page=${currentPage}&search=${query}`);
            const data = await response.json();
            
            if (data.status === 'success') {
                articles = data.articles;
                totalPages = data.totalPages;
                
                updatePagination();
                renderFeaturedNews();
                renderNewsGrid();
            } else {
                showError(data.message);
            }
        } catch (error) {
            showError('Failed to load news. Please try again later.');
            console.error('Error loading news:', error);
        } finally {
            hideLoading();
        }
    }

    function renderFeaturedNews() {
        if (articles.length === 0) {
            featuredNewsContainer.innerHTML = '<p>No news articles found.</p>';
            return;
        }

        // Get the first 3 articles for featured news
        const featuredArticles = articles.slice(0, 3);
        
        featuredNewsContainer.innerHTML = featuredArticles.map(article => `
            <div class="featured-article">
                <img src="${article.image || 'images/placeholder.jpg'}" alt="${article.title}">
                <div class="featured-article-content">
                    <h3>${article.title}</h3>
                    <p>${article.description}</p>
                    <div class="date">${formatDate(article.publishedAt)}</div>
                </div>
            </div>
        `).join('');
    }

    function renderNewsGrid() {
        if (articles.length === 0) {
            newsGrid.innerHTML = '<p>No news articles found.</p>';
            return;
        }

        // Skip the first 3 articles as they're already in featured news
        const gridArticles = articles.slice(3);
        
        newsGrid.innerHTML = gridArticles.map(article => `
            <div class="news-card">
                <img src="${article.image || 'images/placeholder.jpg'}" alt="${article.title}">
                <div class="news-card-content">
                    <h3>${article.title}</h3>
                    <p>${article.description}</p>
                    <div class="meta">
                        <span class="category">${article.category || currentCategory}</span>
                        <span class="date">${formatDate(article.publishedAt)}</span>
                    </div>
                </div>
            </div>
        `).join('');
    }

    function updatePagination() {
        pageInfo.textContent = `Page ${currentPage} of ${totalPages}`;
        prevPageBtn.disabled = currentPage === 1;
        nextPageBtn.disabled = currentPage === totalPages;
    }

    function formatDate(dateString) {
        const options = { year: 'numeric', month: 'short', day: 'numeric' };
        const date = new Date(dateString);
        return date.toLocaleDateString(undefined, options);
    }

    function showLoading() {
        loadingSpinner.style.display = 'flex';
    }

    function hideLoading() {
        loadingSpinner.style.display = 'none';
    }

    function showError(message) {
        featuredNewsContainer.innerHTML = `<p class="error">${message}</p>`;
        newsGrid.innerHTML = '';
    }
}); 