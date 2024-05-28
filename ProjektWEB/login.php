<?php
session_start();
include "db_conn.php";

class Login {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function validate($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    public function loginUser($uname, $pass) {
        if(empty($uname)) {
            header("Location: login.php?error=User Name is required");
            exit();
        }
        else if(empty($pass)) {
            header("Location: login.php?error=Password is required");
            exit();
        }
        else {
            $stmt = $this->conn->prepare("SELECT * FROM users WHERE user_name=?");
            $stmt->bind_param("s", $uname);
            $stmt->execute();
            $result = $stmt->get_result();

            if($result->num_rows === 1) {
                $row = $result->fetch_assoc();
                if($row['user_name'] === $uname && password_verify($pass, $row['password'])) {
                    $_SESSION['user_name'] = $row['user_name'];
                    $_SESSION['name'] = $row['name'];
                    $_SESSION['id'] = $row['id'];
                    $_SESSION['level'] = $row['level']; 
                
                    if($row['level'] === 'admin') {
                        header("Location: admin.php");
                    } 
                    else {
                        header("Location: user.php");
                    }
                }
                else {
                    header("Location: login.php?error=Incorrect User name or password");
                    exit();
                }
            }
            else {
                header("Location: login.php?error=Incorrect User name or password");
                exit();
            }
        }
    }
}
$login = new Login($conn);

if(isset($_POST['uname']) && isset($_POST['password'])) {
    $uname = $login->validate($_POST['uname']);
    $pass = $login->validate($_POST['password']);
    $login->loginUser($uname, $pass);
}
?>

<?php
    include_once('Partials\header.php');
?>
<main>
    <form action="login.php" method="post">
        <h1>Login</h1>
        <?php if(isset($_GET['error'])) { ?>
            <p class="error"> <?php echo $_GET['error']; ?></p>
        <?php } ?>
        <label>User name</label>
        <input type="text" name="uname" placeholder="User Name"><br>
        <label>Password</label>
        <input type="password" name="password" placeholder="Password"><br>
            
        <button type="submit">Login</button>
    </form>
</main>

<?php
    include_once('Partials\footer.php');
?>