
<?php
    include_once('Partials\header.php');
?>
    <link rel="stylesheet" href="CSS/login.css">
<main>
    <form action="process_register.php" method="post">
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username" required><br>
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br>
        <input type="submit" value="Register">
    </form>
</main>

<?php
    include_once('Partials\footer.php');
?>