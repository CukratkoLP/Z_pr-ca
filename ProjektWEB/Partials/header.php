<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/style.css">
    <link rel="stylesheet" href="CSS/reglog.css">
    <title>Lukasko04</title>
</head>

<body>
    <header class="header">
        <a href="#" class="logo">Logo</a>     
        <nav class="navbar">
            <?php
                $links = [
                    ['href' => 'domov.php', 'text' => 'Domov'],
                    ['href' => 'login.php', 'text' => 'Login'],
                    ['href' => 'register.php', 'text' => 'Register']
                ];

                if(isset($_SESSION['level']) && ($_SESSION['level'] == 'admin' || $_SESSION['level'] == 'user')) {
                    if($_SESSION['level'] == 'admin') {
                        $links[] = ['href' => 'admin.php', 'text' => 'Admin'];
                        $links[] = ['href' => 'Q&Aadmin.php', 'text' => 'Q&A'];
                    } else {
                        $links[] = ['href' => 'Q&A.php', 'text' => 'Q&A'];
                    }
                }

                foreach ($links as $link) {
                    echo '<a href="' . $link['href'] . '">' . $link['text'] . '</a>';
                }

                if(isset($_SESSION['user_name'])) {
                    echo '<a href="logout.php" class="logout-button">Logout</a>';
                }
            ?>
        </nav>
    </header>
        
    