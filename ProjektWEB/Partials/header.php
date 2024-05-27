<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/style.css">
    <title>Lukasko04</title>
</head>
<body>
    <header class="header">
        <a href="#" class="logo">Logo</a>     
        <nav class="navbar">
            <?php
            $links = [
                ['href' => 'domov.php', 'text' => 'Domov'],
                ['href' => 'Q&A.php', 'text' => 'Q&A'],
                ['href' => 'login.php', 'text' => 'Login'],
                ['href' => 'register.php', 'text' => 'Register']
            ];

            foreach ($links as $link) {
                echo '<a href="' . $link['href'] . '">' . $link['text'] . '</a>';
            }
            ?>
        </nav>
    </header>
        
    </header>