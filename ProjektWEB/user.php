<?php
session_start();

if(isset($_SESSION['id']) && isset($_SESSION['user_name'])) {
?>
<?php
    include_once('Partials\header.php');
?>
    <link rel="stylesheet" href="CSS/user.css">
    <h1> Welcome back user <?php echo $_SESSION['user_name']; ?></h1>
<?php
    include_once('Partials\footer.php');
?>
<?php
}else {
    header("Location: login.php");
    exit();
}   
?>