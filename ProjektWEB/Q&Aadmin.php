<?php

session_start();

include_once('Partials/header.php');

class QandAAdmin {
    private $conn;

    public function __construct() {
        include_once('Partials/db_conn.php');
        $this->conn = $conn;
    }

    public function checkAdminSession() {
        if (!isset($_SESSION['level']) || $_SESSION['level'] != 'admin') {
            header('Location: login.php');
            exit();
        }
    }

    public function createQuestion() {
        if (isset($_POST['create'])) {
            $email = $_POST['email'];
            $question = $_POST['question'];
            $user = $_SESSION['user_name'];

            $sql = "INSERT INTO questions (email, question, user) VALUES ('$email', '$question', '$user')";
            $this->conn->query($sql);
        }
    }

    public function displayQuestions() {
        $sql = "SELECT * FROM questions";
        $result = $this->conn->query($sql);

        while ($row = $result->fetch_assoc()) {
            echo '<form method="post" action="Q&Aadmin.php">';
            echo '<input type="hidden" name="id" value="' . $row['id'] . '">';
            echo 'Email: ' . $row['email'] . "<br>";
            echo 'Question: ' . $row['question'] . "<br>";
            echo 'User: ' . $row['user'];
            echo "<input type='submit' name='delete' value='Delete' onclick='return confirm(\"Are you sure you want to delete this user?\");' style='background-color: red;'>";
            echo '</form>';
        }
    }

    public function deleteQuestion() {
        if (isset($_POST['delete'])) {
            $id = $_POST['id'];

            $sql = "DELETE FROM questions WHERE id = $id";
            $this->conn->query($sql);
            header('Location: Q&Aadmin.php');
            exit();
        }
    }
}

$qAndAAdmin = new QandAAdmin();
$qAndAAdmin->checkAdminSession();
$qAndAAdmin->createQuestion();
$qAndAAdmin->displayQuestions();
$qAndAAdmin->deleteQuestion();

include_once('Partials/footer.php');
?>