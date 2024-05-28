<?php
    include_once('Partials\header.php');
    include_once('Partials\db_conn.php');
?>

<link rel="stylesheet" href="register.css">
<main>
    <form action="register.php" method="post">
    <h1>Register</h1>
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username" placeholder="User name" required><br>
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" placeholder="Password" required><br>
        <input type="submit" value="Register" name="register">
    </form>
</main>

<?php
    class User {
        private $conn;

        public function __construct($conn) {
            $this->conn = $conn;
        }

        public function userExists($username) {
            $sql = "SELECT * FROM users WHERE user_name = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();

            return $result->num_rows > 0;
        }

        public function register($username, $password) {
            if($this->userExists($username)) {
                echo "Username already exists";
                return;
            }

            $level = "user";
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO users (user_name, password, level) VALUES (?, ?, ?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("sss", $username, $hashed_password, $level);

            if($stmt->execute()){
                echo "New user created successfully, <br> ";
                echo "Please <a href='login.php'>Login</a> to continue";
            } else {
                echo "Error: " . $sql . "<br>" . $this->conn->error;
            }
        }
    }

    if(isset($_POST['register'])){
        $username = $_POST['username'];
        $password = $_POST['password'];

        $user = new User($conn);
        $user->register($username, $password);
    }

    include_once('Partials\footer.php');
?>