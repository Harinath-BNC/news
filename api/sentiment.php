<?php
function analyzeSentiment($text) {
    // Simple sentiment analysis based on positive and negative word lists
    $positive_words = ['good', 'great', 'excellent', 'amazing', 'wonderful', 'positive', 'success', 'win', 'winning', 'achievement', 'growth', 'profit', 'gain', 'improve', 'improvement'];
    $negative_words = ['bad', 'poor', 'terrible', 'awful', 'negative', 'loss', 'losing', 'failure', 'decline', 'decrease', 'problem', 'issue', 'concern', 'worry', 'risk'];
    
    $text = strtolower($text);
    $words = str_word_count($text, 1);
    
    $positive_count = 0;
    $negative_count = 0;
    
    foreach ($words as $word) {
        if (in_array($word, $positive_words)) {
            $positive_count++;
        }
        if (in_array($word, $negative_words)) {
            $negative_count++;
        }
    }
    
    $total = $positive_count + $negative_count;
    if ($total == 0) {
        return 0; // Neutral
    }
    
    $score = ($positive_count - $negative_count) / $total;
    return round($score * 100); // Convert to percentage
}
?> 