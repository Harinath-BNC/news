<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include the sentiment analysis function
include 'api/sentiment.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News App Demo</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Update Lottie Player library to specific version -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.7.13/lottie.min.js"></script>
    <style>
        /* Global Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary-color: #2563eb;
            --secondary-color: #1e40af;
            --background-color: #f1f5f9;
            --card-background: #ffffff;
            --text-primary: #1e293b;
            --text-secondary: #64748b;
            --border-radius: 12px;
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            line-height: 1.6;
            color: var(--text-primary);
            background-color: var(--background-color);
            background-image: url('https://images.unsplash.com/photo-1504711434969-e33886168f5c?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            background-repeat: no-repeat;
            position: relative;
        }
        
        /* Add a semi-transparent overlay to improve readability */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.45);
            z-index: -1;
        }

        .container {
            width: 100%;
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 24px;
        }

        a {
            text-decoration: none;
            color: var(--text-primary);
            transition: all 0.3s ease;
        }

        ul {
            list-style: none;
        }

        button {
            cursor: pointer;
            border: none;
            background: none;
            font-family: inherit;
        }

        /* Header Styles */
        header {
            position: sticky;
            top: 0;
            z-index: 100;
            background: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .header-top {
            background: #fff;
            padding: 8px 24px;
            border-bottom: 1px solid #e2e2e2;
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1400px;
            margin: 0 auto;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .date-text {
            color: #666;
            font-size: 13px;
            margin-top:10px;
        }

        .e-paper-link {
            color: #d92937;
            text-decoration: none;
            font-weight: 500;
            font-size: 13px;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .header-button {
            padding: 6px 12px;
            font-size: 13px;
            font-weight: 500;
            text-decoration: none;
            border-radius: 3px;
        }

        .login-btn {
            color: #333;
        }

        .trial-btn {
            color: #333;
        }

        .subscribe-btn {
            background: #d92937;
            color: white;
        }

        .main-header {
            padding: 20px 0;
            text-align: center;
            border-bottom: 1px solid #e2e2e2;
            position: relative;
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        .logo {
            margin: 0 auto;
        }
        
        .logo h1 {
            font-family: 'Times New Roman', serif;
            font-size: 42px;
            font-weight: 900;
            color: #000;
            margin: 0;
            line-height: 1;
            letter-spacing: 1px;
        }

        .logo-subtitle {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.8);
            margin-top: 5px;
            letter-spacing: 1px;
        }

        /* Remove all decorative elements */
        .logo h1::before,
        .logo h1::after {
            display: none;
        }

        /* Remove the border */
        .logo h1 {
            border: none;
            background: none;
        }

        /* Hide the subtitle */
        .logo-subtitle {
            display: none;
        }

        .date-header {
            text-align: center;
            font-family: 'Times New Roman', serif;
            font-size: 12px;
            color: #1a1a1a;
            padding: 0;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-bottom: 20px;
        }

        @media (max-width: 768px) {
            .logo h1 {
                font-size: 32px;
                padding: 5px 15px;
            }
        }

        @media (max-width: 480px) {
            .logo h1 {
                font-size: 24px;
                padding: 5px 10px;
            }
        }

        .search-container {
            position: absolute;
            right: 24px;
            top: 50%;
            transform: translateY(-50%);
        }

        .category-nav {
            background: #fff;
            border-bottom: 2px solid #e2e2e2;
            padding: 0;
            max-width: 1400px;
            margin: 0 auto;
        }

        .category-nav ul {
            display: flex;
            justify-content: center;
            gap: 0;
            padding: 0;
            margin: 0;
        }

        .category-nav ul li a {
            padding: 12px 20px;
            color: #333;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            display: block;
            transition: color 0.3s;
            position: relative;
        }

        @media (max-width: 992px) {
            .main-header {
                flex-direction: column;
                padding: 15px 24px;
            }

            .search-container {
                position: relative;
                right: auto;
                top: auto;
                transform: none;
                margin-top: 15px;
                width: 100%;
            }

            #search-input {
                width: 100%;
            }

            .category-nav ul {
                flex-wrap: nowrap;
                overflow-x: auto;
                justify-content: flex-start;
            }
        }

        @media (max-width: 768px) {
            .logo h1 {
                font-size: 28px;
                padding: 5px 15px;
            }

            .category-nav ul li a {
                padding: 10px 15px;
                font-size: 13px;
            }
        }

        @media (max-width: 480px) {
            .logo h1 {
                font-size: 24px;
                padding: 5px 10px;
            }
        }
        
        .news-title {
            font-size: 120px;
            font-weight: 900;
            letter-spacing: -3px;
            color: #000;
            line-height: 0.9;
            font-family: "Times New Roman", Times, serif;
            text-transform: uppercase;
            margin: 0;
            padding: 0;
            position: relative;
            display: inline-block;
        }
        
        .news-title::after {
            content: 'DAILY';
            position: absolute;
            top: -15px;
            right: -80px;
            font-size: 24px;
            font-weight: 900;
            letter-spacing: 4px;
            color: #000;
            transform: rotate(90deg);
            transform-origin: left bottom;
        }
        
        /* Style for the date */
        .logo[data-date] {
            position: relative;
        }
        
        .logo[data-date]::before {
            content: attr(data-date);
            position: absolute;
            bottom: -25px;
            left: 50%;
            transform: translateX(-50%);
            font-size: 14px;
            font-style: normal;
            font-weight: bold;
            color: #000;
            font-family: 'Times New Roman', serif;
            letter-spacing: 2px;
            text-transform: uppercase;
            background: #fff;
            padding: 5px 15px;
            border-left: 2px solid #000;
            border-right: 2px solid #000;
        }
        
        nav {
            background: #fff;
            border-top: 1px solid #e2e2e2;
            padding: 0;
        }
        
        nav ul {
            display: flex;
            gap: 0;
            background-color: transparent;
            padding: 0;
            border-radius: 0;
            max-width: 1400px;
            margin: 0 auto;
        }
        
        nav ul li a {
            padding: 12px 20px;
            border-radius: 0;
            font-weight: 500;
            transition: all 0.3s ease;
            color: #333;
            font-size: 15px;
            position: relative;
        }
        
        nav ul li a:hover {
            background-color: transparent;
            color: #d92937;
        }
        
        nav ul li a.active {
            background-color: transparent;
            color: #d92937;
            box-shadow: none;
        }
        
        nav ul li a.active::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 20px;
            right: 20px;
            height: 2px;
            background: #d92937;
        }

        .premium-tag {
            background: #ffd700;
            color: #000;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 12px;
            font-weight: 600;
            margin-left: 5px;
        }
        
        .search-container {
            margin-left: auto;
        }
        
        #search-input {
            padding: 8px 16px 8px 35px;
            border: 1px solid #e2e2e2;
            border-radius: 4px;
            width: 200px;
            font-size: 14px;
            transition: all 0.3s ease;
        }
        
        #search-input:focus {
            outline: none;
            border-color: #d92937;
            box-shadow: 0 0 0 2px rgba(217, 41, 55, 0.1);
        }
        
        .search-container::before {
            content: '🔍';
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 14px;
            color: #94a3b8;
            pointer-events: none;
        }
        
        #search-btn {
            padding: 12px 20px;
            background-color: #4f46e5;
            color: white;
            border-radius: 30px;
            font-weight: 500;
            transition: all 0.3s ease;
            box-shadow: 0 4px 10px rgba(79, 70, 229, 0.3);
        }
        
        #search-btn:hover {
            background-color: #4338ca;
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(79, 70, 229, 0.4);
        }

        /* Main Content Styles */
        main {
            padding: 40px 0;
        }

        .featured-news, .news-container {
            margin-bottom: 48px;
        }

        h2 {
            margin-bottom: 24px;
            font-size: 24px;
            font-weight: 700;
            color: var(--text-primary);
            position: relative;
            display: inline-block;
        }

        h2::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border-radius: 2px;
        }

        .featured-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 24px;
            margin-bottom: 40px;
        }

        .featured-article {
            position: relative;
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--shadow);
            transition: all 0.3s ease;
            aspect-ratio: 16/9;
        }

        .featured-article:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .featured-article img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .featured-article:hover img {
            transform: scale(1.05);
        }

        .featured-article-content {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 32px;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.9), transparent);
            color: white;
        }

        .featured-article-content h3 {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 12px;
            line-height: 1.4;
        }

        .featured-article-content p {
            font-size: 14px;
            margin-bottom: 12px;
            opacity: 0.9;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .news-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 24px;
        }

        .news-card {
            background-color: var(--card-background);
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--shadow);
            transition: all 0.3s ease;
        }

        .news-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .news-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .news-card:hover img {
            transform: scale(1.05);
        }

        .news-card-content {
            padding: 20px;
        }

        .news-card-content h3 {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 12px;
            line-height: 1.4;
            color: var(--text-primary);
        }

        .news-card-content p {
            font-size: 14px;
            color: var(--text-secondary);
            margin-bottom: 16px;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 12px;
            color: var(--text-secondary);
        }

        .category {
            background-color: rgba(37, 99, 235, 0.1);
            color: var(--primary-color);
            padding: 4px 12px;
            border-radius: 20px;
            font-weight: 500;
        }

        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 16px;
            margin-top: 40px;
        }

        .pagination button {
            padding: 10px 20px;
            background-color: var(--primary-color);
            color: white;
            border-radius: var(--border-radius);
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .pagination button:hover:not(:disabled) {
            background-color: var(--secondary-color);
            transform: translateY(-1px);
        }

        .pagination button:disabled {
            background-color: var(--text-secondary);
            cursor: not-allowed;
            opacity: 0.5;
        }

        #page-info {
            font-size: 14px;
            color: var(--text-secondary);
            font-weight: 500;
        }

        /* Footer Styles */
        footer {
            background-color: var(--text-primary);
            color: white;
            padding: 32px 0;
            text-align: center;
        }

        /* Loading Spinner */
        .loading-spinner {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #faf3e0;
            background-image: url('https://images.unsplash.com/photo-1516139008210-96e45dccd83b?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80');
            background-size: cover;
            background-position: center;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            z-index: 1000;
            display: none;
            animation: fadeIn 0.2s ease;
            min-width: 200px;
            min-height: 200px;
            border: 2px solid #a67c52;
            overflow: hidden;
        }

        .loading-spinner::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(250, 243, 224, 0.9);
            z-index: -1;
        }

        .spinner {
            width: 50px;
            height: 50px;
            border: 4px solid rgba(166, 124, 82, 0.2);
            border-top: 4px solid #a67c52;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
            margin: 0 auto 20px;
        }

        .loading-text {
            text-align: center;
            margin-top: 20px;
            font-size: 16px;
            color: #3d291e;
            font-weight: 600;
            font-family: 'Times New Roman', serif;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .loading-spinner-content {
            position: relative;
            z-index: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        /* Debug Panel */
        .debug-panel {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: rgba(0, 0, 0, 0.9);
            color: white;
            padding: 16px;
            border-radius: var(--border-radius);
            font-size: 12px;
            max-width: 400px;
            max-height: 300px;
            overflow: auto;
            z-index: 1000;
            display: none;
            box-shadow: var(--shadow);
        }

        .debug-toggle {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            font-size: 20px;
            cursor: pointer;
            z-index: 1001;
            box-shadow: var(--shadow);
            transition: all 0.3s ease;
        }

        .debug-toggle:hover {
            transform: scale(1.1);
            background-color: var(--secondary-color);
        }

        /* Updated Modal Styles for newspaper spread effect */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.85);
            z-index: 2000;
            perspective: 1500px;
        }

        .modal.show {
            display: flex !important;
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            width: 90%;
            max-width: 1200px;
            position: relative;
            transform-style: preserve-3d;
        }

        .newspaper-spread {
            display: flex;
            transform-origin: center center;
            transform: rotateX(30deg) scale(0.1);
            opacity: 0;
            transition: all 0.8s ease-out;
        }

        .modal.show .newspaper-spread {
            transform: rotateX(0) scale(1);
            opacity: 1;
        }

        .page {
            flex: 1;
            background: #faf3e0;
            padding: 30px;
            position: relative;
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.2);
            min-height: 80vh;
            max-height: 80vh;
        }

        .page-left {
            border-right: 2px solid #8b4513;
            transform-origin: right center;
            animation: pageOpenLeft 1s ease-out forwards;
        }

        .page-right {
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        .page::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                linear-gradient(to right, rgba(0,0,0,0.1) 0%, transparent 20%),
                url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAMAAAAp4XiDAAAAUVBMVEWFhYWDg4N3d3dtbW17e3t1dXWBgYGHh4d5eXlzc3OLi4ubm5uVlZWPj4+NjY19fX2JiYl/f39ra2uRkZGZmZlpaWmXl5dvb29xcXGTk5NnZ2c8TV1mAAAAG3RSTlNAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEAvEOwtAAAFVklEQVR4XpWWB67c2BUFb3g557T/hRo9/WUMZHlgr4Bg8Z4qQgQJlHI4A8SzFVrapvmTF9O7dmYRFZ60YiBhJRCgh1FYhiLAmdvX0CzTOpNE77ME0Zty/nWWzchDtiqrmQDeuv3powQ5ta2eN0FY0InkqDD73lT9c9lEzwUNqgFHs9VQce3TVClFCQrSTfOiYkVJQBmpbq2L6iZavPnAPcoU0dSw0SUTqz/GtrGuXfbyyBniKykOWQWGqwwMA7QiYAxi+IlPdqo+hYHnUt5ZPfnsHJyNiDtnpJyayNBkF6cWoYGAMY92U2hXHF/C1M8uP/ZtYdiuj26UdAdQQSXQErwSOMzt/XWRWAz5GuSBIkwG1H3FabJ2OsUOUhGC6tK4EMtJO0ttC6IBD3kM0ve0tJwMdSfjZo+EEISaeTr9P3wYrGjXqyC1krcKdhMpxEnt5JetoulscpyzhXN5FRpuPHvbeQaKxFAEB6EN+cYN6xD7RYGpXpNndMmZgM5Dcs3YSNFDHUo2LGfZuukSWyUYirJAdYbF3MfqEKmjM+I2EfhA94iG3L7uKrR+GdWD73ydlIB+6hgref1QTlmgmbM3/LeX5GI1Ux1RWpgxpLuZ2+I+IjzZ8wqE4nilvQdkUdfhzI5QDWy+kw5Wgg2pGpeEVeCCA7b85BO3F9DzxB3cdqvBzWcmzbyMiqhzuYqtHRVG2y4x+KOlnyqla8AoWWpuBoYRxzXrfKuILl6SfiWCbjxoZJUaCBj1CjH7GIaDbc9kqBY3W/Rgjda1iqQcOJu2WW+76pZC9QG7M00dffe9hNnseupFL53r8F7YHSwJWUKP2q+k7RdsxyOB11n0xtOvnW4irMMFNV4H0uqwS5ExsmP9AxbDTc9JwgneAT5vTiUSm1E7BSflSt3bfa1tv8Di3R8n3Af7MNWzs49hmauE2wP+ttrq+AsWpFG2awvsuOqbipWHgtuvuaAE+A1Z/7gC9hesnr+7wqCwG8c5yAg3AL1fm8T9AZtp/bbJGwl1pNrE7RuOX7PeMRUERVaPpEs+yqeoSmuOlokqw49pgomjLeh7icHNlG19yjs6XXOMedYm5xH2YxpV2tc0Ro2jJfxC50ApuxGob7lMsxfTbeUv07TyYxpeLucEH1gNd4IKH2LAg5TdVhlCafZvpskfncCfx8pOhJzd76bJWeYFnFciwcYfubRc12Ip/ppIhA1/mSZ/RxjFDrJC5xifFjJpY2Xl5zXdguFqYyTR1zSp1Y9p+tktDYYSNflcxI0iyO4TPBdlRcpeqjK/piF5bklq77VSEaA+z8qmJTFzIWiitbnzR794USKBUaT0NTEsVjZqLaFVqJoPN9ODG70IPbfBHKK+/q/AWR0tJzYHRULOa4MP+W/HfGadZUbfw177G7j/OGbIs8TahLyynl4X4RinF793Oz+BU0saXtUHrVBFT/DnA3ctNPoGbs4hRIjTok8i+algT1lTHi4SxFvONKNrgQFAq2/gFnWMXgwffgYMJpiKYkmW3tTg3ZQ9Jq+f8XN+A5eeUKHWvJWJ2sgJ1Sop+wwhqFVijqWaJhwtD8MNlSBeWNNWTa5Z5kPZw5+LbVT99wqTdx29lMUH4OIG/D86ruKEauBjvH5xy6um/Sfj7ei6UUVk4AIl3MyD4MSSTOFgSwsH/QJWaQ5as7ZcmgBZkzjjU1UrQ74ci1gWBCSGHtuV1H2mhSnO3Wp/3fEV5a+4wz//6qy8JxjZsmxxy5+4w9CDNJY09T072iKG0EnOS0arEYgXqYnXcYHwjTtUNAcMelOd4xpkoqiTYICWFq0JSiPfPDQdnt+4/wuqcXY47QILbgAAAABJRU5ErkJggg==');
            opacity: 0.1;
            pointer-events: none;
        }

        .page-number {
            position: absolute;
            bottom: 20px;
            font-family: 'Times New Roman', serif;
            font-size: 14px;
            color: #8b4513;
        }

        .page-left .page-number {
            right: 20px;
        }

        .page-right .page-number {
            left: 20px;
        }

        #modal-image {
            width: 100%;
            height: calc(100% - 40px);
            object-fit: cover;
            border: 2px solid #8b4513;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            filter: sepia(20%);
        }

        @keyframes pageOpenLeft {
            from {
                transform: rotateY(90deg);
            }
            to {
                transform: rotateY(0deg);
            }
        }

        @keyframes pageOpenRight {
            from {
                transform: rotateY(-90deg);
            }
            to {
                transform: rotateY(0deg);
            }
        }

        /* Mobile responsiveness */
        @media (max-width: 768px) {
            .newspaper-spread {
                flex-direction: column;
            }
            
            .page {
                min-height: auto;
                max-height: none;
            }
            
            .page-left {
                border-right: none;
                border-bottom: 2px solid #8b4513;
            }
            
            .page-right {
                border-left: none;
                border-top: 2px solid #8b4513;
            }
        }

        .modal-header {
            text-align: center;
            margin-bottom: 20px;
            padding: 10px 0;
            border-bottom: 3px double #8b4513;
            position: relative;
        }

        .modal-masthead {
            font-family: 'Times New Roman', serif;
            font-size: 32px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: #2b1810;
            text-shadow: 1px 1px 1px rgba(139,69,19,0.2);
            line-height: 1;
            margin-bottom: 5px;
        }

        .modal-subtitle {
            font-family: 'Georgia', serif;
            font-style: italic;
            font-size: 12px;
            color: #5c3a21;
            margin: 3px 0;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .modal-date {
            font-family: 'Times New Roman', serif;
            font-size: 11px;
            color: #8b4513;
            margin-top: 5px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .modal-body {
            display: grid;
            grid-template-columns: 1.7fr 1fr;
            gap: 20px;
            padding: 0;
            flex: 1;
            overflow: hidden;
        }

        .main-article {
            border-right: 1px solid #8b4513;
            padding-right: 20px;
            overflow-y: auto;
            padding-bottom: 40px;
        }

        .main-article h1 {
            font-size: 24px;
            margin-bottom: 10px;
            line-height: 1.2;
        }

        .main-article p {
            font-size: 14px;
            line-height: 1.4;
            margin-bottom: 15px;
        }

        .news-sidebar {
            font-family: 'Georgia', serif;
            font-size: 11px;
            overflow-y: auto;
            padding-bottom: 40px;
        }

        .sidebar-title {
            font-family: 'Times New Roman', serif;
            font-size: 14px;
            font-weight: bold;
            text-transform: uppercase;
            color: #2b1810;
            margin-bottom: 10px;
            padding-bottom: 3px;
            border-bottom: 1px solid #8b4513;
        }

        .brief-news {
            margin-bottom: 12px;
            padding-bottom: 12px;
            border-bottom: 1px dotted #8b4513;
        }

        .brief-news h4 {
            font-family: 'Times New Roman', serif;
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 3px;
            color: #2b1810;
            line-height: 1.2;
        }

        .brief-news p {
            font-size: 11px;
            line-height: 1.3;
            color: #5c3a21;
            margin-bottom: 3px;
        }

        .brief-news .brief-meta {
            font-style: italic;
            font-size: 10px;
            color: #8b4513;
        }

        .modal-price {
            position: absolute;
            top: 10px;
            right: 10px;
            font-family: 'Times New Roman', serif;
            font-size: 12px;
            color: #8b4513;
            border: 1px solid #8b4513;
            padding: 3px 8px;
            transform: rotate(15deg);
        }

        .read-more {
            display: inline-block;
            padding: 5px 12px;
            background-color: #8b4513;
            color: #faf3e0;
            text-decoration: none;
            font-family: 'Times New Roman', serif;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 15px;
            transition: all 0.3s ease;
        }

        .read-more:hover {
            background-color: #5c3a21;
        }

        .modal-meta {
            font-size: 11px;
            color: #5c3a21;
            margin-bottom: 10px;
            font-style: italic;
        }

        .modal-author {
            font-style: italic;
            font-size: 11px;
            color: #5c3a21;
            margin: 10px 0;
        }

        .article-category {
            background-color: #d92937;
            color: white;
            padding: 4px 8px;
            font-size: 12px;
            font-weight: 500;
            border-radius: 3px;
            margin-bottom: 10px;
            display: inline-block;
            text-transform: uppercase;
        }

        .article-meta {
            display: flex;
            gap: 8px;
            font-size: 12px;
            color: rgba(255, 255, 255, 0.8);
            margin-top: 8px;
        }

        .featured-article-content {
            background: linear-gradient(to top, rgba(0, 0, 0, 0.9) 0%, rgba(0, 0, 0, 0.7) 60%, transparent 100%);
        }

        .sentiment-score {
            display: inline-flex;
            align-items: center;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 500;
            margin-left: 8px;
        }

        .sentiment-positive {
            background-color: rgba(46, 204, 113, 0.2);
            color: #2ecc71;
        }

        .sentiment-negative {
            background-color: rgba(231, 76, 60, 0.2);
            color: #e74c3c;
        }

        .sentiment-neutral {
            background-color: rgba(149, 165, 166, 0.2);
            color: #95a5a6;
        }

        /* Animation container styles */
        .animation-container {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            width: 60px;
            height: 60px;
            z-index: 10;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .static-icon {
            font-size: 32px;
            color: #d92937;
            position: relative;
            animation: rotate 3s linear infinite;
        }

        .static-icon::after {
            content: '';
            position: absolute;
            top: -5px;
            left: -5px;
            right: -5px;
            bottom: -5px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(217, 41, 55, 0.2) 0%, rgba(217, 41, 55, 0) 70%);
            animation: glow 2s ease-in-out infinite;
            z-index: -1;
        }

        @keyframes rotate {
            from {
                transform: rotate(0deg);
            }
            to {
                transform: rotate(360deg);
            }
        }

        @keyframes glow {
            0% {
                transform: scale(0.8);
                opacity: 0.3;
            }
            50% {
                transform: scale(1.2);
                opacity: 0.7;
            }
            100% {
                transform: scale(0.8);
                opacity: 0.3;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="header-top">
            <div class="header-left mt-5">
                <span class="date-text" id="current-date"></span>
            </div>
        </div>
        <div class="main-header">
            <!-- Simplified animation container -->
            <div class="animation-container">
                <i class="fas fa-globe static-icon"></i>
            </div>
            <div class="logo">
                <h1>The Informer Daily</h1>
            </div>
            <div class="search-container">
                <input type="text" id="search-input" placeholder="Search news...">
                <button id="search-btn"><i class="fas fa-search"></i></button>
            </div>
        </div>
        <nav class="category-nav">
            <ul>
                <li><a href="#" class="active" data-category="general">General</a></li>
                <li><a href="#" data-category="business">Business</a></li>
                <li><a href="#" data-category="technology">Technology</a></li>
                <li><a href="#" data-category="sports">Sports</a></li>
                <li><a href="#" data-category="entertainment">Entertainment</a></li>
            </ul>
        </nav>
    </header>

    <main class="container">
        <div class="featured-news">
            <h2 id="section-title">Featured News</h2>
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
        <div class="loading-spinner-content">
            <div class="spinner"></div>
            <div class="loading-text">Loading news...</div>
        </div>
    </div>
    
    <button class="debug-toggle" id="debug-toggle">?</button>
    <div class="debug-panel" id="debug-panel">
        <h3>Debug Information</h3>
        <div id="debug-content"></div>
    </div>

    <!-- Add this before the closing </body> tag -->
    <div class="modal" id="news-modal">
        <div class="modal-content">
            <span class="close-modal">&times;</span>
            <div class="newspaper-spread">
                <div class="page page-left">
                    <img id="modal-image" src="" alt="News Image">
                    <div class="page-number">1</div>
                </div>
                <div class="page page-right">
            <div class="modal-header">
                <div class="modal-price">FIVE CENTS</div>
                        <div class="modal-masthead">The Informer Daily</div>
                        <div class="modal-subtitle">Truth and Justice</div>
                        <div class="modal-date" id="modal-date"></div>
            </div>
            <div class="modal-body">
                        <div class="main-article">
                <h1 id="modal-title"></h1>
                <div class="modal-meta">
                    <span id="modal-source"></span>
                </div>
                <p id="modal-description"></p>
                <div class="modal-author" id="modal-author"></div>
                <a id="modal-link" href="#" target="_blank" class="read-more">Continue Reading</a>
            </div>
                        <div class="news-sidebar">
                            <h3 class="sidebar-title">In Brief</h3>
                            <div class="brief-news">
                                <h4>Technology Advances in AI</h4>
                                <p>Recent developments in artificial intelligence show promising results in healthcare applications. Researchers have developed new algorithms that can predict patient outcomes with unprecedented accuracy.</p>
                                <div class="brief-meta">Technology Desk</div>
                            </div>
                            <div class="brief-news">
                                <h4>Global Climate Summit</h4>
                                <p>World leaders gather to discuss urgent climate action. New agreements reached on reducing carbon emissions by 2030, with major economies pledging significant reductions.</p>
                                <div class="brief-meta">Environment Desk</div>
                            </div>
                            <div class="brief-news">
                                <h4>Sports Update</h4>
                                <p>Local team advances to championships after stunning victory. Coach credits team's dedication and new training regimen for unprecedented success this season.</p>
                                <div class="brief-meta">Sports Desk</div>
                            </div>
                            <div class="brief-news">
                                <h4>Business Insights</h4>
                                <p>Market analysts predict strong economic growth in emerging sectors. Tech and renewable energy companies lead the way in new job creation.</p>
                                <div class="brief-meta">Business Desk</div>
                            </div>
                        </div>
                    </div>
                    <div class="page-number">2</div>
                </div>
            </div>
        </div>
    </div>

    <script>
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
            const debugToggle = document.getElementById('debug-toggle');
            const debugPanel = document.getElementById('debug-panel');
            const debugContent = document.getElementById('debug-content');
            const modal = document.getElementById('news-modal');
            const closeModal = document.querySelector('.close-modal');

            // App State
            let currentCategory = 'general';
            let currentPage = 1;
            let totalPages = 1;
            let searchQuery = '';
            let articles = [];
            let currentArticles = [];
            let debugLog = [];

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
            
            debugToggle.addEventListener('click', () => {
                debugPanel.style.display = debugPanel.style.display === 'none' ? 'block' : 'none';
            });

            closeModal.addEventListener('click', () => {
                modal.classList.remove('show');
                document.body.style.overflow = '';
            });

            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    modal.classList.remove('show');
                    document.body.style.overflow = '';
                }
            });

            // Functions
            function init() {
                loadNews(currentCategory);
                changeBackgroundImage(currentCategory);
                updateNewspaperDate();
            }

            function updateNewspaperDate() {
                const dateHeader = document.getElementById('current-date');
                const today = new Date();
                const options = { weekday: 'uppercase', year: 'numeric', month: 'long', day: 'numeric' };
                const formattedDate = today.toLocaleDateString('en-US', {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                }).toUpperCase();
                dateHeader.textContent = formattedDate;
            }

            function setActiveCategory(category) {
                // Update section title based on category
                const sectionTitle = document.getElementById('section-title');
                if (category === 'politics') {
                    sectionTitle.textContent = 'Top Stories in Indian Politics';
                } else {
                    sectionTitle.textContent = 'Featured News';
                }

                // Disable all category links during loading
                categoryLinks.forEach(link => {
                    link.style.pointerEvents = 'none';
                    link.classList.remove('active');
                    if (link.getAttribute('data-category') === category) {
                        link.classList.add('active');
                    }
                });
                
                currentCategory = category;
                changeBackgroundImage(category);
                
                // Re-enable category links after loading
                setTimeout(() => {
                    categoryLinks.forEach(link => {
                        link.style.pointerEvents = 'auto';
                    });
                }, 800);
            }

            function changeBackgroundImage(category) {
                const backgroundImages = {
                    'general': 'https://images.unsplash.com/photo-1504711434969-e33886168f5c?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80',
                    'business': 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2015&q=80',
                    'sports': 'https://images.unsplash.com/photo-1461896836934-ffe607ba8211?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80',
                    'entertainment': 'https://images.unsplash.com/photo-1489599849927-2ee91cede3ba?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                    'technology': 'https://images.unsplash.com/photo-1518770660439-4636190af475?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80'
                };
                
                const imageUrl = backgroundImages[category] || backgroundImages['general'];
                document.body.style.backgroundImage = `url('${imageUrl}')`;
            }

            async function loadNews(category, query = '') {
                showLoading();
                
                try {
                    const url = `api/news.php?category=${category}&page=${currentPage}&search=${query}`;
                    const response = await fetch(url);
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

                const featuredArticles = articles.slice(0, 3);
                
                featuredNewsContainer.innerHTML = featuredArticles.map((article, index) => {
                    const sentimentClass = article.sentiment_score > 20 ? 'sentiment-positive' : 
                                         article.sentiment_score < -20 ? 'sentiment-negative' : 
                                         'sentiment-neutral';
                    
                    return `
                    <div class="featured-article" onclick="showArticleDetails(${JSON.stringify(article).replace(/"/g, '&quot;')})">
                            <img src="${article.image || getDefaultImage(currentCategory)}" 
                                 alt="${article.title}" 
                                 onerror="this.onerror=null; this.src='${getDefaultImage(currentCategory)}';">
                        <div class="featured-article-content">
                                <span class="article-category">${currentCategory === 'politics' ? 'Indian Politics' : currentCategory}</span>
                            
                                <p>${article.description || ''}</p>
                                <div class="article-meta">
                                    <span class="date">${formatDate(article.publishedAt)}</span>
                                    ${article.source ? `<span class="source">• ${article.source}</span>` : ''}
                                    <span class="sentiment-score ${sentimentClass}">
                                        ${article.sentiment_score > 0 ? '+' : ''}${article.sentiment_score}% Sentiment
                                    </span>
                        </div>
                    </div>
                        </div>
                    `;
                }).join('');
            }

            function renderNewsGrid() {
                if (articles.length === 0) {
                    newsGrid.innerHTML = '<p>No news articles found.</p>';
                    return;
                }

                const gridArticles = articles.slice(3);
                
                newsGrid.innerHTML = gridArticles.map((article, index) => {
                    const sentimentClass = article.sentiment_score > 20 ? 'sentiment-positive' : 
                                         article.sentiment_score < -20 ? 'sentiment-negative' : 
                                         'sentiment-neutral';
                    
                    return `
                    <div class="news-card" onclick="showArticleDetails(${JSON.stringify(article).replace(/"/g, '&quot;')})">
                        <img src="${article.image || getDefaultImage(currentCategory)}" 
                             alt="${article.title}"
                             onerror="this.onerror=null; this.src='${getDefaultImage(currentCategory)}';">
                        <div class="news-card-content">
                            <h3>${article.title}</h3>
                            <p>${article.description}</p>
                            <div class="meta">
                                <span class="category">${article.category || currentCategory}</span>
                                <span class="date">${formatDate(article.publishedAt)}</span>
                                    <span class="sentiment-score ${sentimentClass}">
                                        ${article.sentiment_score > 0 ? '+' : ''}${article.sentiment_score}% Sentiment
                                    </span>
                            </div>
                        </div>
                    </div>
                    `;
                }).join('');
            }

            function getDefaultImage(category) {
                const defaultImages = {
                    'general': 'https://images.unsplash.com/photo-1504711434969-e33886168f5c?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                    'business': 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?ixlib=rb-4.0.3&auto=format&fit=crop&w=2015&q=80',
                    'sports': 'https://images.unsplash.com/photo-1461896836934-ffe607ba8211?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                    'entertainment': 'https://images.unsplash.com/photo-1489599849927-2ee91cede3ba?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                    'technology': 'https://images.unsplash.com/photo-1518770660439-4636190af475?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80'
                };
                return defaultImages[category] || defaultImages['general'];
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
                const loadingSpinner = document.getElementById('loading-spinner');
                loadingSpinner.innerHTML = `
                    <div class="loading-spinner-content">
                        <div class="spinner"></div>
                        <div class="loading-text">Loading news...</div>
                    </div>
                `;
                loadingSpinner.style.display = 'block';
            }

            function hideLoading() {
                document.getElementById('loading-spinner').style.display = 'none';
            }

            function showError(message) {
                featuredNewsContainer.innerHTML = `<p class="error">${message}</p>`;
                newsGrid.innerHTML = '';
            }
            
            function addDebugLog(message) {
                const timestamp = new Date().toLocaleTimeString();
                debugLog.push(`[${timestamp}] ${message}`);
                console.log(`[${timestamp}] ${message}`);
            }
            
            function updateDebugPanel() {
                debugContent.innerHTML = debugLog.map(log => `<div>${log}</div>`).join('');
            }

            function showArticleDetails(article) {
                const modal = document.getElementById('news-modal');
                const modalImage = document.getElementById('modal-image');
                const modalTitle = document.getElementById('modal-title');
                const modalSource = document.getElementById('modal-source');
                const modalDate = document.getElementById('modal-date');
                const modalDescription = document.getElementById('modal-description');
                const modalAuthor = document.getElementById('modal-author');
                const modalLink = document.getElementById('modal-link');
                const newspaperSpread = document.querySelector('.newspaper-spread');

                // Reset animations
                newspaperSpread.style.transform = 'rotateX(30deg) scale(0.1)';
                newspaperSpread.style.opacity = '0';

                // Set the newspaper date
                const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
                const formattedDate = new Date(article.publishedAt).toLocaleDateString('en-US', options);
                modalDate.textContent = formattedDate;

                // Set the article content
                modalImage.src = article.image || 'https://via.placeholder.com/800x400?text=No+Image';
                modalImage.alt = article.title;
                modalTitle.textContent = article.title.toUpperCase();
                modalSource.textContent = `From our ${article.source} correspondent`;
                modalDescription.textContent = article.description;
                modalAuthor.textContent = article.author ? `By ${article.author}` : '';
                modalLink.href = article.url;

                // Show modal with animation
                modal.style.display = 'flex';
                document.body.style.overflow = 'hidden';

                // Trigger the opening animation after a small delay
                setTimeout(() => {
                    newspaperSpread.style.transform = 'rotateX(0) scale(1)';
                    newspaperSpread.style.opacity = '1';
                }, 100);
            }

            function closeModalHandler() {
                const modal = document.getElementById('news-modal');
                const newspaperSpread = document.querySelector('.newspaper-spread');
                
                // Add closing animation
                newspaperSpread.style.transform = 'rotateX(30deg) scale(0.1)';
                newspaperSpread.style.opacity = '0';
                
                // Wait for animation to complete before hiding modal
                setTimeout(() => {
                    modal.style.display = 'none';
                    document.body.style.overflow = '';
                }, 800);
            }

            // Close modal when clicking outside
            document.getElementById('news-modal').addEventListener('click', (e) => {
                if (e.target === document.getElementById('news-modal')) {
                    closeModalHandler();
                }
            });

            // Close modal when clicking close button
            document.querySelector('.close-modal').addEventListener('click', closeModalHandler);

            // Close modal when pressing Escape key
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && document.getElementById('news-modal').style.display === 'flex') {
                    closeModalHandler();
                }
            });

            // Add click handlers for news articles
            function setupArticleClickHandlers() {
                const articles = document.querySelectorAll('.news-card, .featured-article');
                articles.forEach(article => {
                    article.addEventListener('click', function() {
                        const articleData = {
                            title: this.querySelector('h3')?.textContent || this.querySelector('p')?.textContent,
                            description: this.querySelector('p')?.textContent,
                            image: this.querySelector('img')?.src,
                            publishedAt: new Date().toISOString(),
                            source: this.querySelector('.source')?.textContent?.replace('• ', '') || 'News Source',
                            author: '',
                            url: '#'
                        };
                        showArticleDetails(articleData);
                    });
                });
            }

            // Call setupArticleClickHandlers after rendering news
            const originalRenderFeaturedNews = renderFeaturedNews;
            renderFeaturedNews = function() {
                originalRenderFeaturedNews();
                setupArticleClickHandlers();
            };

            const originalRenderNewsGrid = renderNewsGrid;
            renderNewsGrid = function() {
                originalRenderNewsGrid();
                setupArticleClickHandlers();
            };
        });
    </script>
</body>
</html>