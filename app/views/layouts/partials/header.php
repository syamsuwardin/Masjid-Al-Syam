<?php
if (!defined('APP_START')) {
    die('No direct access');
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masjid Al-Syam</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="/css/style.css">
    <?php if(isset($title) && strpos($title, 'Donasi') !== false): ?>
        <script src="/js/donation.js" defer></script>
    <?php endif; ?>
</head>
<body>