<?php
session_start();

if(!isset($_SESSION['user_name'])) {
    header("Location: login.php");
    exit();
}

if($_SESSION['level'] !== 'admin') {
    header("Location: login.php");
    exit();
}
?>
<?php
if(isset($_SESSION['id']) && isset($_SESSION['user_name'])) {
    ?>
<?php
    include_once('Partials\header.php');
?>
    <link rel="stylesheet" href="CSS/user.css">
    <h1> Hello, <?php echo $_SESSION['user_name']; ?></h1>
<?php
    include_once('Partials\footer.php');
?>
<?php
}else {
    header("Location: login.php");
    exit();
}   
?>
