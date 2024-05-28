<?php
    session_start();
    
    if(!isset($_SESSION['level']) || $_SESSION['level'] != 'admin') {
        
        header('Location: login.php');
        exit();
    }
    include_once('Partials\header.php');
    include_once('Partials\db_conn.php');
    if(isset($_POST['create'])) {
        $email = $_POST['email'];
        $question = $_POST['question'];
        $user = $_SESSION['user_name'];

        $sql = "INSERT INTO questions (email, question, user) VALUES ('$email', '$question', '$user')";
        $conn->query($sql);
    }

    $sql = "SELECT * FROM questions";
    $result = $conn->query($sql);

    while($row = $result->fetch_assoc()) {
        echo '<form method="post" action="Q&Aadmin.php">';
        echo '<input type="hidden" name="id" value="' . $row['id'] . '">';
        echo 'Email: ' . $row['email'] . "<br>";
        echo 'Question: ' . $row['question'] . "<br>";
        echo 'User: ' . $row['user'];
        echo "<input type='submit' name='delete' value='Delete' onclick='return confirm(\"Are you sure you want to delete this user?\");' style='background-color: red;'>";
        echo '</form>';
    }

    if(isset($_POST['delete'])) {
        $id = $_POST['id'];

        $sql = "DELETE FROM questions WHERE id = $id";
        $conn->query($sql);
        header('Location: Q&Aadmin.php');
        exit();
    }


include_once('Partials\footer.php');
?>