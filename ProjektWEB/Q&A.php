<?php
    session_start();

    if(!isset($_SESSION['level']) || $_SESSION['level'] != 'user') {
        header("Location: login.php");
        exit();
    }

    include_once('Partials\db_conn.php');

    if(isset($_POST['submit'])) {
        $email = $_POST['email'];
        $question = $_POST['question'];
        $user = $_SESSION['user_name'];
    
        $sql = "INSERT INTO questions (email, question, user) VALUES ('$email', '$question', '$user')";
        $result = $conn->query($sql);
    
        if($result) {
            $_SESSION['message'] = "Question submitted successfully";
        } else {
            $_SESSION['message'] = "Error submitting question: " . $conn->error;
        }
    
        header("Location: Q&A.php");
        exit();
    }
?>

<?php
    include_once('Partials\header.php');
?>

<form method="post" action="Q&A.php">
    Email: <input type="email" name="email" required><br>
    Question: <textarea name="question" required></textarea><br>
    <input type="submit" name="submit" value="Submit">
</form>

<?php
    include_once('Partials\footer.php');
?>