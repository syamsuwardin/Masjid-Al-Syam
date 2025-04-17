function getArticleImage($image) {
    $imagePath = "img/articles/{$image}";
    $fullPath = PUBLIC_PATH . '/' . $imagePath;
    
    // Cek apakah file exist
    if ($image && file_exists($fullPath)) {
        return BASE_URL . '/' . $imagePath;
    }
    
    // Return default image jika tidak ada
    return BASE_URL . '/img/articles/default.jpg';
}