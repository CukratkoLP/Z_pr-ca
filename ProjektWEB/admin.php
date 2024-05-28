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
    <h1> Welcome back, <?php echo $_SESSION['user_name']; ?></h1>
    <?php
include_once('Partials\db_conn.php');
include_once('Partials\header.php');


if(isset($_POST['update'])) {
    $id = $_POST['id'];
    $username = $_POST['username'];
    $level = $_POST['level'];

    $sql = "UPDATE users SET user_name='$username', level='$level' WHERE id=$id";
    $result = $conn->query($sql);

    if($result) {
        echo "User updated successfully";
    } else {
        echo "Error updating user: " . $conn->error;
    }
}

if(isset($_POST['delete'])) {
    $id = $_POST['id'];

    $sql = "DELETE FROM users WHERE id=$id";
    $result = $conn->query($sql);

    if($result) {
        echo "User deleted successfully";
    } else {
        echo "Error deleting user: " . $conn->error;
    }
}

if(isset($_POST['create'])) {
    $username = $_POST['new_username'];
    $password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
    $level = $_POST['new_level'];

    $sql = "INSERT INTO users (user_name, password, level) VALUES ('$username', '$password', '$level')";
    $result = $conn->query($sql);

    if($result) {
        header("Location: admin.php");
        exit();
    } else {
        echo "Error creating user: " . $conn->error;
    }
}

$sql = "SELECT * FROM users";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
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
?>
<?php
    include_once('Partials\footer.php');
?>
<?php
}else {
    header("Location: login.php");
    exit();
}   
?>
