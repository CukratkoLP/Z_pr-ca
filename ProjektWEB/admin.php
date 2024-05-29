<?php
session_start();

class AdminPage {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function redirectToLogin() {
        header("Location: login.php");
        exit();
    }

    public function updateUser($id, $username, $level) {
        $sql = "UPDATE users SET user_name='$username', level='$level' WHERE id=$id";
        $result = $this->conn->query($sql);

        if ($result) {
            echo "User updated successfully";
        } else {
            echo "Error updating user: " . $this->conn->error;
        }
    }

    public function deleteUser($id) {
        $sql = "DELETE FROM users WHERE id=$id";
        $result = $this->conn->query($sql);

        if ($result) {
            echo "User deleted successfully";
        } else {
            echo "Error deleting user: " . $this->conn->error;
        }
    }

    public function createUser($username, $password, $level) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (user_name, password, level) VALUES ('$username', '$hashedPassword', '$level')";
        $result = $this->conn->query($sql);

        if ($result) {
            header("Location: admin.php");
            exit();
        } else {
            echo "Error creating user: " . $this->conn->error;
        }
    }

    public function displayUsers() {
        $sql = "SELECT * FROM users";
        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<form method='post' action='admin.php'>";
                echo "<input type='hidden' name='id' value='" . $row['id'] . "'>";

                if ($row['id'] == 1) {
                    echo "Username: $row[user_name]<br>";
                } else {
                    echo "Username: <input type='text' name='username' value='" . $row['user_name'] . "'><br>";
                }
                if ($row['id'] == 1) {
                    echo "Level: Root<br>";
                } else {
                    echo "Level: <select name='level'>
                        <option value='admin'" . ($row['level'] == 'admin' ? ' selected' : '') . ">Admin</option>
                        <option value='user'" . ($row['level'] == 'user' ? ' selected' : '') . ">User</option>
                        </select><br>";
                }
                if ($row['id'] != 1) {
                    echo "<input type='submit' name='update' value='Update'>";
                }
                if ($row['id'] != 1) {
                    echo "<input type='submit' name='delete' value='Delete' onclick='return confirm(\"Are you sure you want to delete this user?\");' style='background-color: red;'>";
                }
                echo "</form>";
            }
            echo "<form method='post'>";
            echo "Username: <input type='text' required name='new_username'><br>";
            echo "Level: <select name='new_level'>
                    <option value='user'>User</option>
                    <option value='admin'>Admin</option>
                    </select><br>";
            echo "Password: <input type='password' required name='new_password'><br>";
            echo "<input type='submit' name='create' value='Create' style='background-color: blue;'>";
            echo "</form>";
        } else {
            echo "0 results";
        }
    }
}

if (!isset($_SESSION['user_name'])) {
    $adminPage = new AdminPage(null);
    $adminPage->redirectToLogin();
}

if ($_SESSION['level'] !== 'admin') {
    $adminPage = new AdminPage(null);
    $adminPage->redirectToLogin();
}

include_once('Partials\db_conn.php');
include_once('Partials\header.php');

$adminPage = new AdminPage($conn);

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $username = $_POST['username'];
    $level = $_POST['level'];

    $adminPage->updateUser($id, $username, $level);
}

if (isset($_POST['delete'])) {
    $id = $_POST['id'];

    $adminPage->deleteUser($id);
}

if (isset($_POST['create'])) {
    $username = $_POST['new_username'];
    $password = $_POST['new_password'];
    $level = $_POST['new_level'];

    $adminPage->createUser($username, $password, $level);
}

$adminPage->displayUsers();

include_once('Partials\footer.php');
?>
